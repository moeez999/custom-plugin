<?php
// /local/customplugin/ajax/update_one2one.php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->libdir . '/gradelib.php'); // Needed for grade_item etc.

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

    $data = $json['data'] ?? null;
    if (!is_array($data)) {
        throw new moodle_exception('missingparam', 'error', '', 'data required');
    }

    // --- IDs from payload ---
    $teacherid = (int)($data['teacher']['id'] ?? $data['teacherId'] ?? 0);
    $studentid = (int)($data['student']['id'] ?? $data['studentId'] ?? 0);

    // In payload, "cmid" is actually the googlemeet INSTANCE id.
    $instanceid = (int)($data['cmid'] ?? ($data['singleLesson']['cmid'] ?? ($data['weeklyLesson']['cmid'] ?? 0)));

    if (!$teacherid || !$studentid) {
        throw new moodle_exception('missingparam', 'error', '', 'teacher.id and student.id required');
    }
    if (!$instanceid) {
        throw new moodle_exception('missingparam', 'error', '', 'googlemeet id (cmid in payload) required to update existing session');
    }

    // // --- Fetch main records ---
    // $teacher = $DB->get_record('user', ['id' => $teacherid], 'id,firstname,lastname,email', MUST_EXIST);
    // $student = $DB->get_record('user', ['id' => $studentid], 'id,firstname,lastname,email', MUST_EXIST);

    // $teacherFirst  = trim((string)$teacher->firstname);
    // $teacherLast   = trim((string)$teacher->lastname);
    // $teacherEmail  = trim((string)$teacher->email);
    // $studentFirst  = trim((string)$student->firstname);
    // $studentLast   = trim((string)$student->lastname);
    // $studentEmail  = trim((string)$student->email);
    // $studentFull   = trim($studentFirst . ' ' . $studentLast);

    // // The Google Meet instance we are updating.
    // $meet = $DB->get_record('googlemeet', ['id' => $instanceid], '*', MUST_EXIST);

    // // Find its course module (cmid) from the instance.
    // $cm = get_coursemodule_from_instance('googlemeet', $meet->id, 0, false, MUST_EXIST);

    // // Derive course from cm.
    // $courseid = (int)$cm->course;
    // $course   = get_course($courseid);

    // // Cap checks.
    // $coursecontext = context_course::instance($courseid);
    // require_capability('moodle/course:manageactivities', $coursecontext);
    // $modcontext = context_module::instance($cm->id);
    // require_capability('mod/googlemeet:addinstance', $modcontext);

    // // --- Helpers (same spirit as schedule_one2one) ---
    // $dayname_to_index = [
    //     'Sun' => 0, 'Sunday' => 0,
    //     'Mon' => 1, 'Monday' => 1,
    //     'Tue' => 2, 'Tues' => 2, 'Tuesday' => 2,
    //     'Wed' => 3, 'Wednesday' => 3,
    //     'Thu' => 4, 'Thurs' => 4, 'Thursday' => 4,
    //     'Fri' => 5, 'Friday' => 5,
    //     'Sat' => 6, 'Saturday' => 6,
    // ];
    // $index_to_daykey = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];

    // $parse_ampm = function(string $label) : array {
    //     $label = trim($label);
    //     if (!preg_match('/^(\d{1,2}):(\d{2})\s*([ap]m)$/i', $label, $m)) {
    //         throw new moodle_exception('invaliddata', 'error', '', 'Bad time: ' . $label);
    //     }
    //     $h = (int)$m[1];
    //     $i = (int)$m[2];
    //     $ampm = strtolower($m[3]);
    //     if ($ampm === 'pm' && $h < 12) $h += 12;
    //     if ($ampm === 'am' && $h === 12) $h = 0;
    //     return [$h, $i];
    // };

    // $parse_date = function(string $label) : array {
    //     $label = trim($label);
    //     $t = strtotime($label);
    //     if ($t === false) {
    //         throw new moodle_exception('invaliddata', 'error', '', 'Bad date: ' . $label);
    //     }
    //     return [(int)date('Y', $t), (int)date('n', $t), (int)date('j', $t), $t];
    // };

    // $make_ts = function(int $y, int $m, int $d, int $h, int $i, ?string $tzid = null) : int {
    //     $old = date_default_timezone_get();
    //     $use = $tzid ?: $old;
    //     date_default_timezone_set($use);
    //     $ts = mktime($h, $i, 0, $m, $d, $y);
    //     date_default_timezone_set($old);
    //     return $ts;
    // };

    // $profile_availability = function(string $fieldname, string $value) : string {
    //     $child = [
    //         'type' => 'profile',
    //         'sf'   => $fieldname,
    //         'op'   => 'isequalto',
    //         'v'    => $value,
    //     ];
    //     $tree = [
    //         'op'    => '&',
    //         'c'     => [ $child ],
    //         'showc' => [ true ],
    //     ];
    //     return json_encode($tree, JSON_UNESCAPED_SLASHES);
    // };

    // // --- Start from core moduleinfo (so update_moduleinfo runs all plugin logic) ---
    // $moduleinfo = (object)get_moduleinfo_data($cm, $course);

    // // Make sure moduleinfo has all required identity fields.
    // $moduleinfo->modulename = 'googlemeet';   // so mod/googlemeet/lib.php is used
    // $moduleinfo->instance   = $meet->id;      // instance id for update
    // $moduleinfo->id         = $meet->id;      // plugin_update_instance usually expects ->id

    // // Ensure visibility fields are not null (fix for dmlwriteexception).
    // $moduleinfo->visible             = isset($moduleinfo->visible) ? $moduleinfo->visible : $cm->visible;
    // $moduleinfo->visibleoncoursepage = isset($moduleinfo->visibleoncoursepage)
    //     ? $moduleinfo->visibleoncoursepage
    //     : ($cm->visibleoncoursepage ?? 1);
    // $moduleinfo->visibleold          = isset($moduleinfo->visibleold) ? $moduleinfo->visibleold : $cm->visible;

    // // Availability for the student.
    // $activityAvailability       = $profile_availability('email', $studentEmail);
    // $moduleinfo->availability   = $activityAvailability;

    // // Base name.
    // $baseMeetName               = $meet->name ?: ('1:1 ' . $studentFull . ' with Teacher ' . $teacherFirst);
    // $moduleinfo->name           = $baseMeetName;

    // $lessonType  = strtolower((string)($data['lessonType'] ?? 'single'));
    // $tzid        = null;
    // $updated     = 0;

    // // ================= SINGLE LESSON UPDATE =================
    // if ($lessonType === 'single') {

    //     $single  = $data['singleLesson'] ?? [];
    //     $dateLbl = (string)($single['date'] ?? '');
    //     $timeLbl = (string)($single['time'] ?? '');
    //     $durLbl  = (string)($single['duration'] ?? '60'); // duration in minutes

    //     if ($dateLbl === '' || $timeLbl === '') {
    //         throw new moodle_exception('missingparam', 'error', '', 'date/time required for single lesson');
    //     }

    //     [$Y, $n, $j] = $parse_date($dateLbl);
    //     [$H, $i]     = $parse_ampm($timeLbl);

    //     // Duration is already minutes from frontend
    //     $duration = (int)$durLbl;
    //     if ($duration <= 0) {
    //         $duration = 60;
    //     }

    //     $eventdate   = $make_ts($Y, $n, $j, 0, 0, $tzid);
    //     $starthour   = $H;
    //     $startminute = $i;

    //     // calculate end time based on duration in minutes
    //     $totalminutes = ($H * 60) + $i + $duration;
    //     $endhour      = intdiv($totalminutes, 60) % 24;
    //     $endminute    = $totalminutes % 60;

    //     // Recompute days array like create script (single day).
    //     $wIndex   = (int)date('w', $make_ts($Y, $n, $j, $H, $i, $tzid));
    //     $dayKey   = $index_to_daykey[$wIndex];
    //     $days     = ['Sun'=>"0",'Mon'=>"0",'Tue'=>"0",'Wed'=>"0",'Thu'=>"0",'Fri'=>"0",'Sat'=>"0"];
    //     $days[$dayKey] = "1";

    //     // Map into moduleinfo (same fields as create_module call).
    //     $moduleinfo->eventdate     = $eventdate;
    //     $moduleinfo->starthour     = $starthour;
    //     $moduleinfo->startminute   = $startminute;
    //     $moduleinfo->endhour       = $endhour;
    //     $moduleinfo->endminute     = $endminute;
    //     $moduleinfo->eventenddate  = $eventdate;
    //     $moduleinfo->period        = 1;     // Single.
    //     $moduleinfo->addmultiply   = "1";
    //     $moduleinfo->days          = $days;

    //     // Required by update_moduleinfo.
    //     if (empty($moduleinfo->introeditor)) {
    //         $moduleinfo->introeditor = [
    //             'text'   => $moduleinfo->intro ?? '',
    //             'format' => $moduleinfo->introformat ?? FORMAT_HTML,
    //             'itemid' => 0,
    //         ];
    //     }
    //     $moduleinfo->coursemodule = $cm->id;

    //     //list($cm, $moduleinfo) = update_moduleinfo($cm, $moduleinfo, $course, null);
    //     $updated = 1;
        

    // // ================= WEEKLY / RECURRING UPDATE =================
    // } else {
    //     $weekly = $data['weeklyLesson'] ?? [];
    //     $interval       = max(1, (int)($weekly['interval'] ?? 1));
    //     $period         = strtolower((string)($weekly['period'] ?? 'week'));
    //     $endOptionId    = (string)($weekly['endOption'] ?? 'wl_end_never');
    //     $endsOnLbl      = (string)($weekly['endsOn']   ?? '');
    //     $startDateUnix  = (int)($weekly['startDateUnix'] ?? 0);
    //     $startDateLbl   = (string)($weekly['startDate'] ?? '');
    //     $daysIn         = is_array($weekly['days'] ?? null) ? $weekly['days'] : [];

    //     if ($period !== 'week') {
    //         throw new moodle_exception('invaliddata', 'error', '', 'Only weekly recurrence supported here.');
    //     }
    //     if (empty($daysIn)) {
    //         throw new moodle_exception('missingparam', 'error', '', 'No days selected for weekly lesson');
    //     }

    //     // Normalize days + times (same logic as schedule_one2one).
    //     $normalized = [];
    //     foreach ($daysIn as $d) {
    //         $dayname  = (string)($d['day'] ?? '');

    //         // Map short day labels (e.g. "M") to full names if needed.
    //         $dayaliases = [
    //             'M'  => 'Mon',
    //             'T'  => 'Tue',
    //             'W'  => 'Wed',
    //             'Th' => 'Thu',
    //             'F'  => 'Fri',
    //             'Sa' => 'Sat',
    //             'Su' => 'Sun',
    //         ];
    //         if (isset($dayaliases[$dayname])) {
    //             $dayname = $dayaliases[$dayname];
    //         }

    //         if ($dayname === '' || !isset($dayname_to_index[$dayname])) {
    //             continue;
    //         }

    //         $key = $index_to_daykey[$dayname_to_index[$dayname]];

    //         // START time: prefer 24h -> then AM/PM -> default
    //         if (!empty($d['start24'])) {
    //             [$H, $i] = array_map('intval', explode(':', (string)$d['start24'], 2));
    //         } else {
    //             $startLbl = (string)($d['start'] ?? $d['startTime'] ?? '');
    //             if ($startLbl === '') {
    //                 $startLbl = '09:00 AM';
    //             }
    //             [$H, $i] = $parse_ampm($startLbl);
    //         }

    //         // END time: prefer 24h -> then AM/PM -> else +1 hour from start
    //         if (!empty($d['end24'])) {
    //             [$eH, $eI] = array_map('intval', explode(':', (string)$d['end24'], 2));
    //         } else {
    //             $endLbl = (string)($d['end'] ?? $d['endTime'] ?? '');
    //             if ($endLbl !== '') {
    //                 [$eH, $eI] = $parse_ampm($endLbl);
    //             } else {
    //                 $eH = $H + 1;
    //                 $eI = $i;
    //             }
    //         }

    //         $normalized[] = [
    //             'key' => $key,
    //             'H'   => $H,
    //             'i'   => $i,
    //             'eH'  => $eH,
    //             'eI'  => $eI
    //         ];
    //     }

    //     if (empty($normalized)) {
    //         throw new moodle_exception('invaliddata', 'error', '', 'Could not parse weekly days/times');
    //     }

    //     // Use the first time window as the base for this Meet.
    //     $first = $normalized[0];

    //     // === eventdate: use startDateUnix / startDate from frontend ===
    //     if ($startDateUnix > 0) {
    //         // Already a Unix timestamp (seconds).
    //         $eventdate = $startDateUnix;
    //     } elseif ($startDateLbl !== '') {
    //         [$SY, $Sn, $Sj] = $parse_date($startDateLbl);
    //         $eventdate = $make_ts($SY, $Sn, $Sj, 0, 0, $tzid);
    //     } else {
    //         // Fallback – should rarely happen.
    //         $today     = time();
    //         $eventdate = $make_ts((int)date('Y',$today), (int)date('n',$today), (int)date('j',$today), 0, 0, $tzid);
    //     }

    //     $endOptionId   = (string)($weekly['endOption'] ?? 'wl_end_never');
    //     $endOptionLbl  = strtolower((string)($weekly['endOptionLabel'] ?? ''));
    //     $endsOnLbl     = (string)($weekly['endsOn'] ?? '');

    //     // Treat all these as "end on"
    //     $hasEndOn = in_array($endOptionId, [
    //         'wl_end_on',
    //         'weeklyLessonEndOn',
    //         'weeklyLessonEndOnManage'
    //     ], true) || $endOptionLbl === 'on';

    //     if ($hasEndOn && $endsOnLbl !== '') {
    //         [$EY,$En,$Ej] = $parse_date($endsOnLbl);
    //         $eventenddate = $make_ts($EY,$En,$Ej, 0, 0, $tzid);
    //     } else {
    //         $eventenddate = $eventdate;
    //     }

    //     // Build days array.
    //     $days = ['Sun'=>"0",'Mon'=>"0",'Tue'=>"0",'Wed'=>"0",'Thu'=>"0",'Fri'=>"0",'Sat'=>"0"];
    //     foreach ($normalized as $t) {
    //         $days[$t['key']] = "1";
    //     }

    //     $moduleinfo->eventdate    = $eventdate;
    //     $moduleinfo->eventenddate = $eventenddate;
    //     $moduleinfo->starthour    = $first['H'];
    //     $moduleinfo->startminute  = $first['i'];
    //     $moduleinfo->endhour      = $first['eH'];
    //     $moduleinfo->endminute    = $first['eI'];
    //     $moduleinfo->period       = $interval;
    //     $moduleinfo->addmultiply  = "1";
    //     $moduleinfo->days         = $days;

    //     if (empty($moduleinfo->introeditor)) {
    //         $moduleinfo->introeditor = [
    //             'text'   => $moduleinfo->intro ?? '',
    //             'format' => $moduleinfo->introformat ?? FORMAT_HTML,
    //             'itemid' => 0,
    //         ];
    //     }
    //     $moduleinfo->coursemodule = $cm->id;

    //     //list($cm, $moduleinfo) = update_moduleinfo($cm, $moduleinfo, $course, null);
    //     $updated = 1;
    // }


// =====================================================
// PATCH: STORE 1:1 RESCHEDULE DETAILS (EVENT-BASED)
// =====================================================

// eventId MUST come from frontend (data-event-id)
$eventid = (int)($data['eventId'] ?? 0);
//$eventid = 31711;

// =====================================================
// PATCH: BUILD 1:1 PREVIOUS & CURRENT USING eventId
// =====================================================

if ($eventid <= 0) {
    throw new moodle_exception('missingparam', 'error', '', 'eventId required');
}

// -----------------------------------------------------
// 1) Try getting existing status row
// -----------------------------------------------------
$statusrow = $DB->get_record(
    'local_gm_event_status',
    ['eventid' => $eventid],
    '*',
    IGNORE_MISSING
);

$previousFinal = null;

// -----------------------------------------------------
// 2) Extract PREVIOUS from detailsjson if exists
// -----------------------------------------------------
if ($statusrow && !empty($statusrow->detailsjson)) {
    $oldDetails = json_decode($statusrow->detailsjson, true);

    if (!empty($oldDetails['current'])) {
        $previousFinal = $oldDetails['current'];
    } elseif (!empty($oldDetails['previous'])) {
        $previousFinal = $oldDetails['previous'];
    }
}

// -----------------------------------------------------
// 3) Fallback: build PREVIOUS from googlemeet_events
// -----------------------------------------------------
if (!$previousFinal) {

    $gmEvent = $DB->get_record(
        'googlemeet_events',
        ['id' => $eventid],
        '*',
        MUST_EXIST
    );


    // -----------------------------------------------------
// Find course module (cm) for this googlemeet instance
// -----------------------------------------------------
$cm = get_coursemodule_from_instance(
    'googlemeet',
    (int)$gmEvent->googlemeetid,
    0,
    false,
    MUST_EXIST
);

$courseid = (int)$cm->course;

     

    // Payload timing (frontend)
    $dayInfo = $data['weeklyLesson']['days'][0] ?? null;
    if (!$dayInfo || empty($dayInfo['start']) || empty($dayInfo['end'])) {
        throw new moodle_exception('invaliddata', 'error', '', 'days[start,end] required');
    }

    $eventDateTS = (int)$gmEvent->eventdate;
    $eventDate   = date('Y-m-d', $eventDateTS);

    $oldStartTS = strtotime($eventDate . ' ' . $dayInfo['start']);
    $oldEndTS   = strtotime($eventDate . ' ' . $dayInfo['end']);

    $previousFinal = [
        'eventid'      => $eventid,
        'googlemeetid' => (int)$gmEvent->googlemeetid,
        'date'         => $eventDate,
        'start'        => $dayInfo['start'],
        'end'          => $dayInfo['end'],
        'teacher'      => $teacherid,
        'start_ts'     => $oldStartTS,
        'end_ts'       => $oldEndTS,
        'time'         => time(),
        'action'       => 'reschedule_one2one'
    ];
}

// -----------------------------------------------------
// 4) Build CURRENT from payload
// -----------------------------------------------------
$payloadTs = strtotime($data['timestamp']);
$newDate   = date('Y-m-d', $payloadTs);
$newDay = $data['weeklyLesson']['days'][0];
$newStartTS = strtotime($newDate . ' ' . $newDay['start']);
$newEndTS   = strtotime($newDate . ' ' . $newDay['end']);

if (!$newStartTS || !$newEndTS) {
    throw new moodle_exception('invalidtime', 'error', '', 'Invalid date/time combination');
}

$dayInfo = $data['weeklyLesson']['days'][0] ?? null;

$currentFinal = [
    'eventid'      => $eventid,
    'googlemeetid' => $previousFinal['googlemeetid'],
    'start'        => $dayInfo['start'],
    'end'          => $dayInfo['end'],
    'date'     => $newDate,
    'start_ts'=> $newStartTS,
    'end_ts'  => $newEndTS,
    'teacher'      => (int)($data['newTeacherId'] ?? $teacherid),
    'start_ts'     => $newStartTS,
    'end_ts'       => $newEndTS,
    'time'         => time(),
    'action'       => 'reschedule_one2one'
];

// -----------------------------------------------------
// 5) Final detailsjson structure (READY TO SAVE)
// -----------------------------------------------------
$details = [
    'previous' => $previousFinal,
    'current'  => $currentFinal,
    'action'   => 'reschedule_one2one'
];



if ($statusrow) {

    $statusrow->statuscode   = 'reschedule_one2one';
    $statusrow->detailsjson  = json_encode($details); // ✅ STRING
    $statusrow->timemodified = time();
    $statusrow->createdby    = $USER->id;

    $DB->update_record('local_gm_event_status', $statusrow);

}else{
     $insert = new stdClass();
    $insert->eventid       = $eventid;
    $insert->googlemeetid  = $currentFinal['googlemeetid'];
    $insert->courseid      = $courseid ;
    $insert->cmid          = (int)$cm->id;
    $insert->statuscode    = 'reschedule_one2one';
    $insert->detailsjson   = json_encode($details); // ✅ STRING
    $insert->isactive      = 1;
    $insert->timecreated  = time();
    $insert->timemodified = time();
    $insert->createdby    = $USER->id;

    $DB->insert_record('local_gm_event_status', $insert);
}


// =====================================================
// END PATCH
// =====================================================



// =====================================================
// PATCH: APPLY RESCHEDULE TO ALL FUTURE EVENTS (1:1)
// =====================================================

if (!empty($data['newData']['allEvents'])) {

    // Get all FUTURE events of this googlemeet
    $futureEvents = $DB->get_records_select(
        'googlemeet_events',
        'googlemeetid = :gid AND eventdate >= :now',
        [
            'gid' => (int)$currentFinal['googlemeetid'],
            'now' => time()
        ],
        'eventdate ASC'
    );

    // Time info from payload
    $dayInfo = $data['weeklyLesson']['days'][0] ?? null;
    if (!$dayInfo || empty($dayInfo['start']) || empty($dayInfo['end'])) {
        throw new moodle_exception('invaliddata', 'error', '', 'days[start,end] required');
    }

    foreach ($futureEvents as $fev) {

        // Skip the current event (already processed)
        if ((int)$fev->id === $eventid) {
            continue;
        }

        $feventid = (int)$fev->id;

        // ---------------------------------------------
        // PREVIOUS (from existing status or event)
        // ---------------------------------------------
        $prev = null;

        $oldRow = $DB->get_record(
            'local_gm_event_status',
            ['eventid' => $feventid],
            '*',
            IGNORE_MISSING
        );

        if ($oldRow && !empty($oldRow->detailsjson)) {
            $oldDetails = json_decode($oldRow->detailsjson, true);
            if (!empty($oldDetails['current'])) {
                $prev = $oldDetails['current'];
            } elseif (!empty($oldDetails['previous'])) {
                $prev = $oldDetails['previous'];
            }
        }

        if (!$prev) {
            $oldDate   = date('Y-m-d', (int)$fev->eventdate);
            $oldStart  = strtotime($oldDate . ' ' . $dayInfo['start']);
            $oldEnd    = strtotime($oldDate . ' ' . $dayInfo['end']);

            $prev = [
                'eventid'      => $feventid,
                'googlemeetid' => (int)$fev->googlemeetid,
                'date'         => $oldDate,
                'start'        => $dayInfo['start'],
                'end'          => $dayInfo['end'],
                'teacher'      => $teacherid,
                'start_ts'     => $oldStart,
                'end_ts'       => $oldEnd,
                'time'         => time(),
                'action'       => 'reschedule_one2one'
            ];
        }

        // ---------------------------------------------
        // CURRENT (new timing)
        // ---------------------------------------------
        $newDate   = date('Y-m-d', (int)$fev->eventdate);
        $newStart  = strtotime($newDate . ' ' . $dayInfo['start']);
        $newEnd    = strtotime($newDate . ' ' . $dayInfo['end']);

        $cur = [
            'eventid'      => $feventid,
            'googlemeetid' => (int)$fev->googlemeetid,
            'date'         => $newDate,
            'start'        => $dayInfo['start'],
            'end'          => $dayInfo['end'],
            'teacher'      => (int)($data['newTeacherId'] ?? $teacherid),
            'start_ts'     => $newStart,
            'end_ts'       => $newEnd,
            'time'         => time(),
            'action'       => 'reschedule_one2one'
        ];

        $details = [
            'previous' => $prev,
            'current'  => $cur,
            'action'   => 'reschedule_one2one'
        ];

        // ---------------------------------------------
        // Update / Insert local_gm_event_status
        // ---------------------------------------------
        if ($oldRow) {
            $oldRow->statuscode   = 'reschedule_one2one';
            $oldRow->detailsjson  = json_encode($details);
            $oldRow->timemodified = time();
            $oldRow->createdby   = $USER->id;
            $DB->update_record('local_gm_event_status', $oldRow);
        } else {
            $ins = new stdClass();
            $ins->eventid       = $feventid;
            $ins->googlemeetid  = (int)$fev->googlemeetid;
            $ins->courseid      = $courseid;
            $ins->cmid          = $cm->id;
            $ins->statuscode    = 'reschedule_one2one';
            $ins->detailsjson   = json_encode($details);
            $ins->isactive      = 1;
            $ins->timecreated   = time();
            $ins->timemodified  = time();
            $ins->createdby     = $USER->id;
            $DB->insert_record('local_gm_event_status', $ins);
        }

        // ---------------------------------------------
        // Update googlemeet_events timing
        // ---------------------------------------------
        $fev->eventdate    = strtotime($newDate);
        $fev->duration     = max(1, (int)(($newEnd - $newStart) / 60));
        $fev->timemodified = time();
        $DB->update_record('googlemeet_events', $fev);
    }
}

// =====================================================
// END PATCH: ALL EVENTS
// =====================================================




    echo json_encode([
        'success' => true,
        'updated' => $updated,
        'item'    => [
            'cmid'     => (int)$cm->id,       // real course_modules id
            'instance' => (int)$meet->id,     // googlemeet.id
            'name'     => (string)$moduleinfo->name,
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
