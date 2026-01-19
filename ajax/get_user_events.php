<?php
// local/customplugin/ajax/get_user_events.php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');

@header('Content-Type: application/json; charset=utf-8');

global $DB;

try {

    // --------------------------------------------------
    // Read JSON payload
    // --------------------------------------------------
    $raw  = file_get_contents('php://input');
    $data = json_decode($raw, true);

    if (!is_array($data)) {
        throw new moodle_exception('invaliddata', 'error', '', 'Invalid JSON');
    }

    // --------------------------------------------------
    // Date window (MANDATORY)
    // --------------------------------------------------
    if (empty($data['startDate']) || empty($data['endDate'])) {
        throw new moodle_exception('missingparam', 'error', '', 'startDate and endDate required');
    }

    $startts = strtotime($data['startDate'] . ' 00:00:00');
    $endts   = strtotime($data['endDate']   . ' 23:59:59');

    if (!$startts || !$endts || $startts > $endts) {
        throw new moodle_exception('invaliddata', 'error', '', 'Invalid date range');
    }

    // --------------------------------------------------
    // Resolve users
    // --------------------------------------------------
$teacherids = [];
$studentids = [];

// ----------------------------------------
// Normalize TEACHERS (SAFE)
// ----------------------------------------
if (!empty($data['teacherIds']) && is_array($data['teacherIds'])) {

    $teacherids = array_values(
        array_unique(array_map('intval', $data['teacherIds']))
    );

} elseif (!empty($data['teacherId'])) {

    if (is_array($data['teacherId'])) {
        // 🔥 FIX: teacherId accidentally sent as array
        $teacherids = array_values(
            array_unique(array_map('intval', $data['teacherId']))
        );
    } else {
        // Normal single value
        $teacherids = [(int)$data['teacherId']];
    }
}

// ----------------------------------------
// Normalize STUDENTS (SAFE)
// ----------------------------------------
if (!empty($data['studentIds']) && is_array($data['studentIds'])) {

    $studentids = array_values(
        array_unique(array_map('intval', $data['studentIds']))
    );

} elseif (!empty($data['studentId'])) {

    if (is_array($data['studentId'])) {
        $studentids = array_values(
            array_unique(array_map('intval', $data['studentId']))
        );
    } else {
        $studentids = [(int)$data['studentId']];
    }
}


    if (!empty($data['studentId'])) {
        $studentids[] = (int)$data['studentId'];
    }

    if (!empty($data['studentIds'])) {
        $studentids = array_map('intval', $data['studentIds']);
    }

    if (!$teacherids && !$studentids) {
        throw new moodle_exception('missingparam', 'error', '', 'teacherId or studentId required');
    }

    // --------------------------------------------------
    // Course 24 = 1:1
    // --------------------------------------------------
    $courseid = 24;

    // --------------------------------------------------
    // Load sections
    // --------------------------------------------------
    $sections = $DB->get_records('course_sections', ['course' => $courseid]);

    // --------------------------------------------------
    // Helper: extract emails from availability
    // --------------------------------------------------
    $extract_emails = function(?string $availability): array {
    if (empty($availability)) {
        return [];
    }

    $json = json_decode($availability, true);
    if (!$json || empty($json['c']) || !is_array($json['c'])) {
        return [];
    }

    $emails = [];

    foreach ($json['c'] as $cond) {

        // Moodle profile restriction
        if (
            ($cond['type'] ?? '') === 'profile' &&
            ($cond['sf'] ?? '') === 'email' &&
            !empty($cond['v'])
        ) {
            $emails[] = core_text::strtolower(trim($cond['v']));
        }
    }

    return $emails;
};


    // --------------------------------------------------
    // Resolve user emails
    // --------------------------------------------------
    $emails = [];

    if ($teacherids) {
        list($sql, $params) = $DB->get_in_or_equal($teacherids, SQL_PARAMS_NAMED);
        $users = $DB->get_records_select('user', "id $sql", $params, 'id,email');
        foreach ($users as $u) {
            $emails[] = core_text::strtolower($u->email);
        }
    }

    if ($studentids) {
        list($sql, $params) = $DB->get_in_or_equal($studentids, SQL_PARAMS_NAMED);
        $users = $DB->get_records_select('user', "id $sql", $params, 'id,email');
        foreach ($users as $u) {
            $emails[] = core_text::strtolower($u->email);
        }
    }

    // --------------------------------------------------
    // Filter allowed sections
    // --------------------------------------------------
    $allowedsectionids = [];

    foreach ($sections as $sec) {
        $availEmails = $extract_emails($sec->availability ?? null);
        if (array_intersect($emails, $availEmails)) {
            $allowedsectionids[] = (int)$sec->id;
        }
    }

    if (!$allowedsectionids) {
        echo json_encode(['ok' => true, 'events' => []]);
        exit;
    }

    // --------------------------------------------------
    // Course modules (googlemeet)
    // --------------------------------------------------
    list($insql, $inparams) = $DB->get_in_or_equal($allowedsectionids, SQL_PARAMS_NAMED);

    $cms = $DB->get_records_select(
        'course_modules',
        "course = :course AND section $insql",
        ['course' => $courseid] + $inparams,
        '',
        'id,instance'
    );

    if (!$cms) {
        echo json_encode(['ok' => true, 'events' => []]);
        exit;
    }

    $googlemeetids = array_unique(array_map(fn($c) => (int)$c->instance, $cms));

    // --------------------------------------------------
    // Filter events by DATE WINDOW
    // --------------------------------------------------
    list($gsql, $gparams) = $DB->get_in_or_equal($googlemeetids, SQL_PARAMS_NAMED);

    $events = $DB->get_records_select(
        'googlemeet_events',
        "googlemeetid $gsql
         AND eventdate BETWEEN :startts AND :endts",
        $gparams + [
            'startts' => $startts,
            'endts'   => $endts
        ],
        'eventdate ASC'
    );

    if (!$events) {
        echo json_encode(['ok' => true, 'events' => []]);
        exit;
    }


    // --------------------------------------------------
// ADDITIONAL: Reassigned teacher events
// --------------------------------------------------
$reassignedEvents = [];

if ($teacherids) {

    list($tsql, $tparams) = $DB->get_in_or_equal($teacherids, SQL_PARAMS_NAMED);

    // Get events currently assigned to these teachers
    $assigned = $DB->get_records_select(
        'local_gm_teacher_assignment',
        "teacherid $tsql",
        $tparams,
        '',
        'eventid'
    );

    if ($assigned) {

        $assignedEventIds = array_unique(
            array_map(fn($a) => (int)$a->eventid, $assigned)
        );

        list($esql, $eparams) = $DB->get_in_or_equal($assignedEventIds, SQL_PARAMS_NAMED);

        $reassignedEvents = $DB->get_records_select(
            'googlemeet_events',
            "id $esql
             AND eventdate BETWEEN :startts AND :endts",
            $eparams + [
                'startts' => $startts,
                'endts'   => $endts
            ],
            'eventdate ASC'
        );
    }
}


    // --------------------------------------------------
    // Reuse single-event logic
    // --------------------------------------------------
    require_once(__DIR__ . '/get_event_history_core.php');

    $teacherFallback = $teacherids[0] ?? null;

    // foreach ($events as $e) {
    //     $results[] = get_single_event_history(
    //         (int)$e->id,
    //         $teacherFallback
    //     );
    // }


    $allEvents = $events;

// Merge reassigned events
foreach ($reassignedEvents as $eid => $ev) {
    $allEvents[$eid] = $ev; // keyed merge avoids duplicates
}

foreach ($allEvents as $e) {
    $results[] = get_single_event_history(
        (int)$e->id,
        $teacherFallback
    );
}


    // --------------------------------------------------
    // Final response
    // --------------------------------------------------
    echo json_encode([
        'ok' => true,
        'window' => [
            'start' => date('Y-m-d', $startts),
            'end'   => date('Y-m-d', $endts)
        ],
        'filter' => [
            'teachers' => $teacherids,
            'students' => $studentids
        ],
        'events' => $results
    ]);
    exit;

} catch (Throwable $e) {

    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'error' => $e->getMessage(),
        'type' => get_class($e)
    ]);
    exit;
}
