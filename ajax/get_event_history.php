<?php
// local/customplugin/ajax/get_event_history.php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ . '/get_event_history_core.php'); // ✅ CORE LOGIC

@header('Content-Type: application/json; charset=utf-8');

global $DB;

try {

    // -------------------------
    // Read JSON
    // -------------------------
    $raw  = file_get_contents('php://input');
    $data = json_decode($raw, true);

    if (!is_array($data)) {
        throw new moodle_exception('invaliddata', 'error', '', 'Invalid JSON');
    }

    // -------------------------
    // Validate eventId
    // -------------------------
    $eventid = (int)($data['eventId'] ?? 0);
    if ($eventid <= 0) {
        throw new moodle_exception('missingparam', 'error', '', 'eventId required');
    }

    // -------------------------
    // Call reusable core logic
    // -------------------------
    $response = get_single_event_history($eventid);

    echo json_encode($response);
    exit;

} catch (Throwable $e) {

    http_response_code(400);
    echo json_encode([
        'ok'    => false,
        'error' => $e->getMessage(),
        'type'  => get_class($e)
    ]);
    exit;
}
