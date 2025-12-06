<?php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();

@header('Content-Type: application/json; charset=utf-8');

try {

    global $DB, $USER;

    // Ensure JSON
    if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === false) {
        throw new moodle_exception('invalidrequest', 'error', '', 'JSON expected');
    }

    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);

    if (!is_array($json)) {
        throw new moodle_exception('invaliddata', 'error', '', 'Invalid JSON');
    }

    // ========================
    // Extract payload
    // ========================
    $teacherid = (int)($json['teacher']['id'] ?? 0);
    $action    = $json['action'] ?? '';
    $slots     = $json['slots'] ?? [];
    $startDate = $json['startDate'] ?? null;

    if ($teacherid <= 0 || empty($action) || empty($slots)) {
        throw new moodle_exception('invaliddata', 'error', '', 'Missing required fields');
    }

    // Convert first effective date (optional)
    $startDateTS = $startDate ? strtotime($startDate) : null;

    // Helper: Convert HH:MM → minutes
    $hhmm_to_min = function($t) {
        list($h, $m) = explode(':', $t);
        return ((int)$h * 60) + (int)$m;
    };

    // Helper: Day name → index
    $day_map = [
        'Monday'    => 0,
        'Tuesday'   => 1,
        'Wednesday' => 2,
        'Thursday'  => 3,
        'Friday'    => 4,
        'Saturday'  => 5,
        'Sunday'    => 6
    ];

    // If UI accidentally sends more than 1 slot → return error
if (count($slots) !== 1) {
    echo json_encode([
        'ok'    => false,
        'error' => 'Only one slot allowed for this operation'
    ]);
    exit;
}

    // Single-slot operations (UI sends only 1)
    $slot = $slots[0];

    $weekday    = $day_map[$slot['day']] ?? null;
    $startMin   = $hhmm_to_min($slot['startTime']);
    $endMin     = $hhmm_to_min($slot['endTime']);

    if ($weekday === null) {
        throw new moodle_exception('invaliddata', 'error', '', 'Invalid day name');
    }

    // ===========================
    // 1. CREATE NEW AVAILABILITY
    // ===========================
    if ($action === 'create') {

        // check if already exists
        $exists = $DB->record_exists('local_teacher_availability', [
            'teacherid' => $teacherid,
            'weekday'   => $weekday,
            'starttime' => $startMin
        ]);

        if ($exists) {
            throw new moodle_exception('duplicate', 'error', '', 'Slot already exists');
        }

        $rec = new stdClass();
        $rec->teacherid    = $teacherid;
        $rec->weekday      = $weekday;
        $rec->starttime    = $startMin;
        $rec->endtime      = $endMin;
        $rec->startdate    = $startDateTS;
        $rec->createdby    = $USER->id;
        $rec->timecreated  = time();
        $rec->timemodified = time();

        $DB->insert_record('local_teacher_availability', $rec);

        echo json_encode([
            'status'  => 'success',
            'action'  => 'create',
            'message' => 'Availability created successfully'
        ]);
        die();
    }

    // =====================
    // 2. RESIZE EXISTING
    // =====================
    if ($action === 'update') {

        // find existing slot based on teacher + weekday + startMin
        $row = $DB->get_record('local_teacher_availability', [
            'teacherid' => $teacherid,
            'weekday'   => $weekday,
            'starttime' => $startMin
        ], '*', IGNORE_MISSING);

        if (!$row) {
            throw new moodle_exception('notfound', 'error', '', 'Slot not found for resize');
        }

        $row->endtime      = $endMin;
        $row->timemodified = time();

        $DB->update_record('local_teacher_availability', $row);

        echo json_encode([
            'status'  => 'success',
            'action'  => 'resize',
            'message' => 'Availability resized successfully'
        ]);
        die();
    }

    // =====================
    // 3. SELECT (NO DB WRITE)
    // =====================
    if ($action === 'select') {

        $row = $DB->get_record('local_teacher_availability', [
            'teacherid' => $teacherid,
            'weekday'   => $weekday,
            'starttime' => $startMin
        ], '*', IGNORE_MISSING);

        echo json_encode([
            'status' => 'success',
            'action' => 'select',
            'data'   => $row ?: null
        ]);
        die();
    }

    // =====================
    // 4. DELETE
    // =====================
    if ($action === 'delete') {

        $row = $DB->get_record('local_teacher_availability', [
            'teacherid' => $teacherid,
            'weekday'   => $weekday,
            'starttime' => $startMin
        ], '*', IGNORE_MISSING);

        if (!$row) {
            throw new moodle_exception('notfound', 'error', '', 'Slot not found for delete');
        }

        $DB->delete_records('local_teacher_availability', [
            'id' => $row->id
        ]);

        echo json_encode([
            'status'  => 'success',
            'action'  => 'delete',
            'message' => 'Availability deleted successfully'
        ]);
        die();
    }

        // =====================
    // 2b. DRAG (FULL UPDATE BY ID)
    // =====================
    if ($action === 'drag') {

        $slotid = isset($slot['id']) ? (int)$slot['id'] : 0;
        if ($slotid <= 0) {
            throw new moodle_exception('invaliddata', 'error', '', 'Missing slot ID for drag update');
        }

        // Fetch record by ID
        $row = $DB->get_record('local_teacher_availability', ['id' => $slotid], '*', IGNORE_MISSING);

        if (!$row) {
            throw new moodle_exception('notfound', 'error', '', 'Slot not found for drag update');
        }

        // Update everything
        $row->weekday      = $weekday;
        $row->starttime    = $startMin;
        $row->endtime      = $endMin;
        $row->startdate    = $startDateTS;
        $row->timemodified = time();

        $DB->update_record('local_teacher_availability', $row);

        echo json_encode([
            'status'  => 'success',
            'action'  => 'drag',
            'message' => 'Availability updated via drag successfully'
        ]);
        die();
    }


    // Unknown action
    throw new moodle_exception('invaliddata', 'error', '', 'Unknown action: '.$action);

} catch (Exception $e) {

    echo json_encode([
        'status' => 'error',
        'error'  => $e->getMessage()
    ]);
    die();
}
