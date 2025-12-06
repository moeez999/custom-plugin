<?php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();

@header('Content-Type: application/json; charset=utf-8');

try {
    global $DB;

    if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === false) {
        throw new moodle_exception('invalidrequest', 'error', '', 'JSON expected');
    }

    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);

    if (!is_array($json) || empty($json['id'])) {
        throw new moodle_exception('invaliddata', 'error', '', 'Missing teacher id');
    }

    $teacherid = (int)$json['id'];

    // Validate teacher exists
    $teacher = $DB->get_record('user', ['id' => $teacherid, 'deleted' => 0, 'suspended' => 0], '*', IGNORE_MISSING);
    if (!$teacher) {
        echo json_encode([
            'ok' => false,
            'error' => 'Teacher not found'
        ]);
        exit;
    }

    // Load all weekly availability for this teacher
    $records = $DB->get_records(
        'local_teacher_availability',
        ['teacherid' => $teacherid],
        'weekday ASC, starttime ASC'
    );

    $availability = [];

    foreach ($records as $r) {

        // Convert weekday to string
        $dayName = date('l', strtotime("Monday +{$r->weekday} days"));

        // Convert start date
        $startDate = $r->startdate ? date("Y-m-d", (int)$r->startdate) : null;

        $availability[] = [
            'id'        => (int)$r->id,
            'day'       => $dayName,
            'startTime' => $r->starttime,
            'endTime'   => $r->endtime,
            'startDate' => $startDate,
            'raw'       => $r->rawjson ? json_decode($r->rawjson, true) : null
        ];
    }

    echo json_encode([
        'ok' => true,
        'teacherid' => $teacherid,
        'availability' => $availability
    ]);
    exit;

} catch (Throwable $e) {
    echo json_encode([
        'ok' => false,
        'error' => $e->getMessage()
    ]);
    exit;
}
