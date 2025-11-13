<?php
// /local/customplugin/ajax/update_one2one.php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

require_login();
// require_sesskey();

@header('Content-Type: application/json; charset=utf-8');

try {
    global $DB, $CFG, $USER;

    if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === false) {
        throw new moodle_exception('invalidaccess', 'error', '', 'Expected application/json');
    }

    $raw  = file_get_contents('php://input') ?: '';
    $json = json_decode($raw, true);
    if (!is_array($json)) {
        throw new moodle_exception('invaliddata', 'error', '', 'Invalid JSON');
    }

    // Same fixed course as in schedule_one2one.php
    $courseid = 24;

    $data = $json['data'] ?? null;
    if (!is_array($data)) {
        throw new moodle_exception('missingparam', 'error', '', 'data required');
    }

    // --- IDs from payload ---
    $teacherid = (int)($data['teacher']['id'] ?? $data['teacherId'] ?? 0);
    $studentid = (int)($data['student']['id'] ?? $data['studentId'] ?? 0);
    // cmid might come at root or inside singleLesson/weeklyLesson
    $cmid      = (int)($data['cmid'] ?? ($data['singleLesson']['cmid'] ?? ($data['weeklyLesson']['cmid'] ?? 0)));

    if (!$teacherid || !$studentid) {
        throw new moodle_exception('missingparam', 'error', '', 'teacher.id and student.id required');
    }
    if (!$cmid) {
        throw new moodle_exception('missingparam', 'error', '', 'cmid required to update existing session');
    }

    // --- Fetch main records ---
    $teacher = $DB->get_record('user', ['id' => $teacherid], 'id,firstname,lastname,email', MUST_EXIST);
    $student = $DB->get_record('user', ['id' => $studentid], 'id,firstname,lastname,email', MUST_EXIST);

    $teacherFirst  = trim((string)$teacher->firstname);
    $teacherLast   = trim((string)$teacher->lastname);
    $teacherEmail  = trim((string)$teacher->email);
    $studentFirst  = trim((string)$student->firstname);
    $studentLast   = trim((string)$student->lastname);
    $studentEmail  = trim((string)$student->email);
    $studentFull   = trim($studentFirst . ' ' . $studentLast);

    // Course & cm.
    $course = get_course($courseid);
    $context = context_course::instance($courseid);
    require_capability('moodle/course:manageactivities', $context);
    require_capability('mod/googlemeet:addinstance', $context);

    // The CM we are updating.
    $cm = get_coursemodule_from_id('googlemeet', $cmid, $courseid, false, MUST_EXIST);
    $modcontext = context_module::instance($cm->id);
    require_capability('moodle/course:manageactivities', $modcontext);

    // The Google Meet instance.
    $meet = $DB->get_record('googlemeet', ['id' => $cm->instance], '*', MUST_EXIST);

    // --- Helpers (same spirit as schedule_one2one) ---
    $dayname_to_index = [
        'Sun' => 0, 'Sunday' => 0,
        'Mon' => 1, 'Monday' => 1,
        'Tue' => 2, 'Tues' => 2, 'Tuesday' => 2,
        'Wed' => 3, 'Wednesday' => 3,
        'Thu' => 4, 'Thurs' => 4, 'Thursday' => 4,
        'Fri' => 5, 'Friday' => 5,
        'Sat' => 6, 'Saturday' => 6,
    ];
    $index_to_daykey = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];

    $parse_ampm = function(string $label) : array {
        $label = trim($label);
        if (!preg_match('/^(\d{1,2}):(\d{2})\s*([ap]m)$/i', $label, $m)) {
            throw new moodle_exception('invaliddata', 'error', '', 'Bad time: ' . $label);
        }
        $h = (int)$m[1];
        $i = (int)$m[2];
        $ampm = strtolower($m[3]);
        if ($ampm === 'pm' && $h < 12) $h += 12;
        if ($ampm === 'am' && $h === 12) $h = 0;
        return [$h, $i];
    };

    $parse_date = function(string $label) : array {
        $label = trim($label);
        $t = strtotime($label);
        if ($t === false) {
            throw new moodle_exception('invaliddata', 'error', '', 'Bad date: ' . $label);
        }
        return [(int)date('Y', $t), (int)date('n', $t), (int)date('j', $t), $t];
    };

    $make_ts = function(int $y, int $m, int $d, int $h, int $i, ?string $tzid = null) : int {
        $old = date_default_timezone_get();
        $use = $tzid ?: $old;
        date_default_timezone_set($use);
        $ts = mktime($h, $i, 0, $m, $d, $y);
        date_default_timezone_set($old);
        return $ts;
    };

    $profile_availability = function(string $fieldname, string $value) : string {
        $child = [
            'type' => 'profile',
            'sf'   => $fieldname,
            'op'   => 'isequalto',
            'v'    => $value,
        ];
        $tree = [
            'op'    => '&',
            'c'     => [ $child ],
            'showc' => [ true ],
        ];
        return json_encode($tree, JSON_UNESCAPED_SLASHES);
    };

    // --- Availability for the student (update cm) ---
    $activityAvailability = $profile_availability('email', $studentEmail);

    // Update course_modules availability to match the (possibly new) student.
    $cmupdate = (object)[
        'id'           => $cm->id,
        'availability' => $activityAvailability,
    ];
    $DB->update_record('course_modules', $cmupdate);

    // Base name (if you ever want to change it on update, you can adapt here).
    $baseMeetName = $meet->name ?: ('1:1 ' . $studentFull . ' with Teacher ' . $teacherFirst);

    $lessonType  = strtolower((string)($data['lessonType'] ?? 'single'));
    $tzid        = null;
    $updated     = 0;

    // ================= SINGLE LESSON UPDATE =================
    if ($lessonType === 'single') {

        $single  = $data['singleLesson'] ?? [];
        $dateLbl = (string)($single['date'] ?? '');
        $timeLbl = (string)($single['time'] ?? '');
       $durLbl  = (string)($single['duration'] ?? '60'); // duration in minutes

        if ($dateLbl === '' || $timeLbl === '') {
            throw new moodle_exception('missingparam', 'error', '', 'date/time required for single lesson');
        }

        [$Y, $n, $j] = $parse_date($dateLbl);
        [$H, $i]     = $parse_ampm($timeLbl);

        // Duration is already minutes from frontend
        $duration = (int)$durLbl;
        if ($duration <= 0) {
            $duration = 60;
        }

        $eventdate = $make_ts($Y, $n, $j, 0, 0, $tzid);
        $starthour   = $H;
        $startminute = $i;

        // calculate end time based on duration in minutes
        $totalminutes = ($H * 60) + $i + $duration;
        $endhour      = intdiv($totalminutes, 60) % 24;
        $endminute    = $totalminutes % 60;



        // Update main googlemeet record.
        $meet->name          = $baseMeetName;
        $meet->eventdate     = $eventdate;
        $meet->starthour     = $starthour;
        $meet->startminute   = $startminute;
        $meet->endhour       = $endhour;
        $meet->endminute     = $endminute;
        $meet->eventenddate  = $eventdate;
        $meet->period        = 1;  // Single.
        $meet->addmultiply   = 1;  // Keep original behaviour.

        // NOTE: We are NOT touching the "days" pattern here (keeps existing day-of-week).

        $DB->update_record('googlemeet', $meet);
        $updated = 1;

    // ================= WEEKLY / RECURRING UPDATE =================
    } else {
        $weekly = $data['weeklyLesson'] ?? [];
        $interval     = max(1, (int)($weekly['interval'] ?? 1));
        $period       = strtolower((string)($weekly['period'] ?? 'week'));
        $endOptionId  = (string)($weekly['endOption'] ?? 'wl_end_never');
        $endsOnLbl    = (string)($weekly['endsOn']   ?? '');
        $daysIn       = is_array($weekly['days'] ?? null) ? $weekly['days'] : [];

        if ($period !== 'week') {
            throw new moodle_exception('invaliddata', 'error', '', 'Only weekly recurrence supported here.');
        }
        if (empty($daysIn)) {
            throw new moodle_exception('missingparam', 'error', '', 'No days selected for weekly lesson');
        }

        // Normalize days + times.
        $normalized = [];
        foreach ($daysIn as $d) {
            $dayname  = (string)($d['day'] ?? '');
            if ($dayname === '' || !isset($dayname_to_index[$dayname])) {
                continue;
            }
            $key = $index_to_daykey[$dayname_to_index[$dayname]];

            $startLbl = (string)($d['start'] ?? '09:00 AM');
            [$H,$i]   = $parse_ampm($startLbl);

            $endLbl   = (string)($d['end'] ?? '');
            if ($endLbl !== '') {
                [$eH, $eI] = $parse_ampm($endLbl);
            } else {
                $eH = $H + 1;
                $eI = $i;
            }

            $normalized[] = ['key' => $key, 'H' => $H, 'i' => $i, 'eH' => $eH, 'eI' => $eI];
        }
        if (empty($normalized)) {
            throw new moodle_exception('invaliddata', 'error', '', 'Could not parse weekly days/times');
        }

        // For updating an existing Meet we assume **one time window**.
        $first = $normalized[0];
        foreach ($normalized as $t) {
            if ($t['H'] !== $first['H'] || $t['i'] !== $first['i'] || $t['eH'] !== $first['eH'] || $t['eI'] !== $first['eI']) {
                throw new moodle_exception('invaliddata', 'error', '', 'Update expects same time across selected days for this Meet');
            }
        }

        $today     = time();
        $eventdate = $make_ts((int)date('Y',$today), (int)date('n',$today), (int)date('j',$today), 0, 0, $tzid);

        if ($endOptionId === 'wl_end_on' && $endsOnLbl !== '') {
            [$EY,$En,$Ej] = $parse_date($endsOnLbl);
            $eventenddate = $make_ts($EY,$En,$Ej, 0, 0, $tzid);
        } else {
            $eventenddate = $eventdate;
        }

        // Simple days array (if your table has a proper 'days' column, adapt here).
        $days = ['Sun'=>"0",'Mon'=>"0",'Tue'=>"0",'Wed'=>"0",'Thu'=>"0",'Fri'=>"0",'Sat'=>"0"];
        foreach ($normalized as $t) {
            $days[$t['key']] = "1";
        }

        $meet->name         = $baseMeetName;
        $meet->eventdate    = $eventdate;
        $meet->starthour    = $first['H'];
        $meet->startminute  = $first['i'];
        $meet->endhour      = $first['eH'];
        $meet->endminute    = $first['eI'];
        $meet->eventenddate = $eventenddate;
        $meet->period       = $interval;
        $meet->addmultiply  = 1;

        // If your googlemeet table has a 'days' field, map $days into it here.

        $DB->update_record('googlemeet', $meet);
        $updated = 1;
    }

    echo json_encode([
        'success' => true,
        'updated' => $updated,
        'item'    => [
            'cmid'     => (int)$cm->id,
            'instance' => (int)$cm->instance,
            'name'     => (string)$meet->name,
        ],
        'student' => [
            'id'    => $student->id,
            'email' => $studentEmail,
        ],
        'teacher' => [
            'id'    => $teacher->id,
            'email' => $teacherEmail,
        ],
    ]);
    exit;

} catch (moodle_exception $ex) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => $ex->errorcode ?? 'moodle_exception',
        'message' => $ex->getMessage()
    ]);
    exit;

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'server_error',
        'message' => $e->getMessage()
    ]);
    exit;
}
