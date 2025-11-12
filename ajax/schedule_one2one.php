<?php
// /local/customplugin/ajax/schedule_one2one.php
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

    $courseid = 24;

    $data = $json['data'] ?? null;
    if (!is_array($data)) {
        throw new moodle_exception('missingparam', 'error', '', 'data required');
    }

    $teacherid = (int)($data['teacher']['id'] ?? 0);
    $studentid = (int)($data['student']['id'] ?? 0);
    if (!$teacherid || !$studentid) {
        throw new moodle_exception('missingparam', 'error', '', 'teacher.id and student.id required');
    }

    $teacher = $DB->get_record('user', ['id' => $teacherid], 'id,firstname,lastname,email', MUST_EXIST);
    $student = $DB->get_record('user', ['id' => $studentid], 'id,firstname,lastname,email', MUST_EXIST);

    $teacherFirst  = trim((string)$teacher->firstname);
    $teacherLast   = trim((string)$teacher->lastname);
    $teacherEmail  = trim((string)$teacher->email);
    $studentFirst  = trim((string)$student->firstname);
    $studentLast   = trim((string)$student->lastname);
    $studentEmail  = trim((string)$student->email);
    $studentFull   = trim($studentFirst . ' ' . $studentLast);

    $course  = get_course($courseid);
    $context = context_course::instance($courseid);
    require_capability('moodle/course:manageactivities', $context);
    require_capability('mod/googlemeet:addinstance', $context);

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
        $h = (int)$m[1]; $i = (int)$m[2]; $ampm = strtolower($m[3]);
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

    $section_has_teacher_email = function(?string $availabilityjson, string $email) : bool {
        if (empty($availabilityjson)) return false;
        $tree = json_decode($availabilityjson, true);
        if (!is_array($tree)) return false;
        if (!empty($tree['c']) && is_array($tree['c'])) {
            foreach ($tree['c'] as $cond) {
                if (!is_array($cond)) continue;
                if (($cond['type'] ?? '') === 'profile'
                    && strtolower((string)($cond['sf'] ?? '')) === 'email'
                    && strtolower((string)($cond['op'] ?? '')) === 'isequalto'
                    && strtolower((string)($cond['v'] ?? '')) === strtolower($email)) {
                    return true;
                }
            }
        }
        return false;
    };

    // ---------- Locate or create the teacher's section ----------
    $targetSection = null;
    $sections = $DB->get_records('course_sections', ['course' => $courseid], 'section ASC', 'id,section,name,availability');
    if ($sections) {
        foreach ($sections as $sec) {
            $nm = (string)($sec->name ?? '');
            if (stripos($nm, 'Teacher ') !== 0) {
                continue;
            }
            if ($section_has_teacher_email($sec->availability ?? null, $teacherEmail)) {
                $targetSection = $sec;
                break;
            }
        }
    }

    if (!$targetSection) {
        // 👉 Ensure a **new main section** (even with Multi Topic format): pick next section number explicitly.
        $maxsection = (int)$DB->get_field_sql('SELECT MAX(section) FROM {course_sections} WHERE course = ?', [$courseid]);
        $newsectionnum = $maxsection + 1;

        // Create at the explicit number.
        $newsec = course_create_section($course, $newsectionnum);

        // Re-fetch full record to be sure we have the final 'section' value.
        $newsec = $DB->get_record('course_sections', ['id' => $newsec->id], '*', MUST_EXIST);
        $newsec->name = 'Teacher ' . $teacherFirst . ' ' . (strlen($teacherLast) ? strtoupper($teacherLast[0]).'.' : '');
        $newsec->availability = $profile_availability('email', $teacherEmail);
        // Use course_update_section to let format handlers react if needed.
        course_update_section($course, $newsec);

        $targetSection = $newsec;
    }

    $sectionnum = (int)$targetSection->section;

    $activityAvailability = $profile_availability('email', $studentEmail);

    $baseMeetName = '1:1 ' . $studentFull . ' with Teacher ' . $teacherFirst;

    $lessonType  = strtolower((string)($data['lessonType'] ?? 'single'));
    $tzid        = null;

    $created = 0;
    $items   = [];

    $create_meet = function(array $fields) use ($courseid, $sectionnum, $activityAvailability, $baseMeetName) : stdClass {
        $moduleinfo = (object)array_merge([
            'course'          => $courseid,
            'section'         => $sectionnum,
            'modulename'      => 'googlemeet',
            'visible'         => 1,
            'showdescription' => 0,
            'name'            => $baseMeetName,
            'availability'    => $activityAvailability,
            'introeditor'     => ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0],
            'completion'      => COMPLETION_TRACKING_NONE,
        ], $fields);

        return create_module($moduleinfo);
    };

    if ($lessonType === 'single') {
        $single  = $data['singleLesson'] ?? [];
        $dateLbl = (string)($single['date'] ?? '');
        $timeLbl = (string)($single['time'] ?? '');
        $durLbl  = (string)($single['duration'] ?? '60');

        if ($dateLbl === '' || $timeLbl === '') {
            throw new moodle_exception('missingparam', 'error', '', 'date/time required for single lesson');
        }

        [$Y, $n, $j] = $parse_date($dateLbl);
        [$H, $i]     = $parse_ampm($timeLbl);
        $duration    = (int)filter_var($durLbl, FILTER_SANITIZE_NUMBER_INT);
        if ($duration <= 0) $duration = 60;

        $eventdate = $make_ts($Y, $n, $j, 0, 0, $tzid);

        $wIndex   = (int)date('w', $make_ts($Y, $n, $j, $H, $i, $tzid));
        $dayKey   = $index_to_daykey[$wIndex];

        $days = ['Sun'=>"0",'Mon'=>"0",'Tue'=>"0",'Wed'=>"0",'Thu'=>"0",'Fri'=>"0",'Sat'=>"0"];
        $days[$dayKey] = "1";

        $starthour   = $H;
        $startminute = $i;
        $endhour     = $starthour + 1;
        $endminute   = $startminute;

        $cm = $create_meet([
            'name'               => $baseMeetName,
            'client_islogged'    => 1,
            'eventdate'          => $eventdate,
            'starthour'          => $starthour,
            'startminute'        => $startminute,
            'endhour'            => $endhour,
            'endminute'          => $endminute,
            'addmultiply'        => "1",
            'days'               => $days,
            'period'             => "1",
            'eventenddate'       => $eventdate,
            'url'                => "",
            'creatoremail'       => $USER->email ?? "",
            'notify'             => "1",
            'minutesbefore'      => "5",
            'visibleoncoursepage'=> 1,
            'cmidnumber'         => "",
            'lang'               => "",
        ]);

        $created++;
        $items[] = ['cmid' => (int)$cm->id, 'instance' => (int)$cm->instance];

    } else {
        $weekly = $data['weeklyLesson'] ?? [];
        $interval     = max(1, (int)($weekly['interval'] ?? 1));
        $period       = strtolower((string)($weekly['period'] ?? 'week'));
        $endOptionId  = (string)($weekly['endOption'] ?? 'wl_end_never');
        $endsOnLbl    = (string)($weekly['endsOn']   ?? '');
        $occurrencesN = (int)($weekly['occurrences'] ?? 0);
        $daysIn       = is_array($weekly['days'] ?? null) ? $weekly['days'] : [];

        if ($period !== 'week') {
            throw new moodle_exception('invaliddata', 'error', '', 'Only weekly recurrence supported here.');
        }
        if (empty($daysIn)) {
            throw new moodle_exception('missingparam', 'error', '', 'No days selected for weekly lesson');
        }

        // --- build normalized day/time entries ---
$normalized = [];
foreach ($daysIn as $d) {
    $dayname  = (string)($d['day'] ?? '');
    if ($dayname === '' || !isset($dayname_to_index[$dayname])) continue;

    $key = $index_to_daykey[$dayname_to_index[$dayname]];

    $startLbl = (string)($d['start'] ?? '09:00 AM');
    [$H,$i]   = $parse_ampm($startLbl);

    $endLbl   = (string)($d['end'] ?? '');
    if ($endLbl !== '') {
        [$eH, $eI] = $parse_ampm($endLbl);
    } else {
        $eH = $H + 1; $eI = $i;
    }

    $normalized[] = ['key' => $key, 'H' => $H, 'i' => $i, 'eH' => $eH, 'eI' => $eI];
}
if (empty($normalized)) {
    throw new moodle_exception('invaliddata', 'error', '', 'Could not parse weekly days/times');
}

// --- anchor event dates (same as before) ---
$today     = time();
$eventdate = $make_ts((int)date('Y',$today), (int)date('n',$today), (int)date('j',$today), 0, 0, $tzid);

if ($endOptionId === 'wl_end_on' && $endsOnLbl !== '') {
    [$EY,$En,$Ej] = $parse_date($endsOnLbl);
    $eventenddate = $make_ts($EY,$En,$Ej, 0, 0, $tzid);
} else {
    $eventenddate = $eventdate;
}

/**
 * Group selected days by their time window.
 * - key format: "HH:MM-HH:MM"
 * - each group => one Meet with all those days
 */
$groups = [];
foreach ($normalized as $t) {
    $sig = sprintf('%02d:%02d-%02d:%02d', $t['H'], $t['i'], $t['eH'], $t['eI']);
    if (!isset($groups[$sig])) {
        $groups[$sig] = ['time' => $t, 'days' => []];
    }
    $groups[$sig]['days'][] = $t['key'];
}

if (count($groups) === 1) {
    // === Same time across all selected days → one Meet (your current behavior) ===
    $g = reset($groups);
    $t = $g['time'];

    $days = ['Sun'=>"0",'Mon'=>"0",'Tue'=>"0",'Wed'=>"0",'Thu'=>"0",'Fri'=>"0",'Sat'=>"0"];
    foreach ($g['days'] as $dk) { $days[$dk] = "1"; }

    $cm = $create_meet([
        'name'               => $baseMeetName,
        'client_islogged'    => 1,
        'eventdate'          => $eventdate,
        'starthour'          => $t['H'],
        'startminute'        => $t['i'],
        'endhour'            => $t['eH'],
        'endminute'          => $t['eI'],
        'addmultiply'        => "1",
        'days'               => $days,
        'period'             => (string)$interval,  // "1" weekly, "2" every 2 weeks, etc.
        'eventenddate'       => $eventenddate,
        'url'                => "",
        'creatoremail'       => $USER->email ?? "",
        'notify'             => "1",
        'minutesbefore'      => "5",
        'visibleoncoursepage'=> 1,
        'cmidnumber'         => "",
        'lang'               => "",
    ]);
    $created++;
    $items[] = ['cmid' => (int)$cm->id, 'instance' => (int)$cm->instance];

} else {
    // === Different times present → one Meet per time group ===
    foreach ($groups as $sig => $g) {
        $t = $g['time'];

        $days = ['Sun'=>"0",'Mon'=>"0",'Tue'=>"0",'Wed'=>"0",'Thu'=>"0",'Fri'=>"0",'Sat'=>"0"];
        foreach ($g['days'] as $dk) { $days[$dk] = "1"; }

        // Optional: append the days to title so it's clear (e.g., "(Mon/Thu)")
        $labelDays = implode('/', $g['days']);

        $cm = $create_meet([
            'name'               => $baseMeetName . ' (' . $labelDays . ')',
            'client_islogged'    => 1,
            'eventdate'          => $eventdate,
            'starthour'          => $t['H'],
            'startminute'        => $t['i'],
            'endhour'            => $t['eH'],
            'endminute'          => $t['eI'],
            'addmultiply'        => "1",
            'days'               => $days,
            'period'             => (string)$interval,
            'eventenddate'       => $eventenddate,
            'url'                => "",
            'creatoremail'       => $USER->email ?? "",
            'notify'             => "1",
            'minutesbefore'      => "5",
            'visibleoncoursepage'=> 1,
            'cmidnumber'         => "",
            'lang'               => "",
        ]);
        $created++;
        $items[] = ['cmid' => (int)$cm->id, 'instance' => (int)$cm->instance];
    }
}
    }

    echo json_encode([
        'success' => true,
        'created' => $created,
        'items'   => $items,
        'section' => [
            'id'      => (int)$targetSection->id,
            'section' => (int)$targetSection->section,
            'name'    => (string)($targetSection->name ?? ''),
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
