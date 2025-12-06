<?php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();
global $DB, $USER;

@header('Content-Type: application/json; charset=utf-8');

try {

    if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === false) {
        throw new moodle_exception('invalidrequest', 'error', '', 'JSON expected');
    }

    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);

    if (!is_array($json)) {
        throw new moodle_exception('invaliddata', 'error');
    }

    // ----------------------------------
    // Extract Payload
    // ----------------------------------
    $timeoffid = isset($json['timeoffId']) ? (int)$json['timeoffId'] : 0;
    $teacherid = isset($json['teacherId']) ? (int)$json['teacherId'] : 0;

    if ($timeoffid <= 0 || $teacherid <= 0) {
        throw new moodle_exception('missingparams', 'error', '', 'Missing timeoffId or teacherId');
    }

    // ----------------------------------
    // Validate record belongs to teacher
    // ----------------------------------
    $record = $DB->get_record('local_teacher_timeoff', [
        'id'        => $timeoffid,
        'teacherid' => $teacherid
    ], '*', IGNORE_MISSING);

    if (!$record) {
        throw new moodle_exception('notfound', 'error', '', 'Time-off entry not found.');
    }

    // ----------------------------------
    // Delete
    // ----------------------------------
    $DB->delete_records('local_teacher_timeoff', [
        'id' => $timeoffid,
        'teacherid' => $teacherid
    ]);

    echo json_encode([
        'status'  => 'success',
        'message' => 'Teacher time-off deleted successfully.',
        'deletedid' => $timeoffid
    ]);
    die();

} catch (Exception $e) {

    echo json_encode([
        'status' => 'error',
        'error'  => $e->getMessage()
    ]);
    die();
}
