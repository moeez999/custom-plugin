<?php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();

global $DB, $USER;

header('Content-Type: application/json');

try {

    if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === false) {
        throw new moodle_exception('invalidaccess', 'error', '', 'Expected application/json');
    }

    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
        throw new moodle_exception('invalidjson', 'error', '', 'JSON decode failed');
    }

    // Required fields
    $slotid = (int)($payload->slotid ?? 0);
    if ($slotid <= 0) {
        throw new moodle_exception('missingslot', 'error', '', 'Slot ID missing');
    }

    // Fetch slot
    $slot = $DB->get_record('local_teacher_extra_slots', ['id' => $slotid], '*', IGNORE_MISSING);
    if (!$slot) {
        throw new moodle_exception('slotnotfound', 'error', '', 'Slot not found');
    }

    // Security: allow delete only by creator OR same teacher
    if ((int)$slot->createdby !== (int)$USER->id && (int)$slot->teacherid !== (int)$USER->id) {
        throw new moodle_exception('nopermission', 'error', '', 'You are not allowed to delete this slot');
    }

    // Delete slot
    $DB->delete_records('local_teacher_extra_slots', ['id' => $slotid]);

    echo json_encode([
        'ok' => true,
        'id' => $slotid,
        'message' => 'Extra slot deleted successfully'
    ]);

} catch (Exception $e) {

    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'error' => $e->getMessage()
    ]);
}
