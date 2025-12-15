<?php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();

@header('Content-Type: application/json; charset=utf-8');

try {
    global $DB, $USER;

    if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === false) {
        throw new moodle_exception('invalidrequest', 'error', '', 'JSON expected');
    }

    $raw  = file_get_contents('php://input');
    $json = json_decode($raw, true);

    if (!is_array($json)) {
        throw new moodle_exception('invaliddata', 'error');
    }

    // -------------------------------------------------
    // Payload
    // -------------------------------------------------
    $eventid   = (int)($json['eventId'] ?? 0);
    $reason    = trim($json['reason'] ?? '');
    $message   = trim($json['message'] ?? '');
    $ack       = (bool)($json['acknowledged'] ?? false);
    $teacherId = (int)($json['teacherId'] ?? 0);

    if (!$eventid) {
        throw new moodle_exception('missingeventid', 'error');
    }

    // -------------------------------------------------
    // Fetch status row
    // -------------------------------------------------
    $statusrow = $DB->get_record(
        'local_gm_event_status',
        ['eventid' => $eventid],
        '*',
        IGNORE_MISSING
    );

    // -------------------------------------------------
    // Fetch googlemeet_event (needed for fallback)
    // -------------------------------------------------
    $event = $DB->get_record(
        'googlemeet_events',
        ['id' => $eventid],
        '*',
        MUST_EXIST
    );

    // -------------------------------------------------
    // Decode old details
    // -------------------------------------------------
    $oldDetails = $statusrow && $statusrow->detailsjson
        ? json_decode($statusrow->detailsjson, true)
        : null;

    // -------------------------------------------------
    // Resolve PREVIOUS block
    // -------------------------------------------------
    if (is_array($oldDetails) && !empty($oldDetails['current'])) {
        $previous = $oldDetails['current'];
    } else {
        // First-time cancel → derive from googlemeet_events
        $previous = [
            'date'    => date('Y-m-d', $event->eventdate),
            'start'   => null,
            'end'     => null,
            'teacher' => $teacherId,
            'eventid' => $eventid,
            'time'    => time(),
            'action'  => 'cancel'
        ];
    }

    // -------------------------------------------------
    // Build CURRENT cancel block
    // -------------------------------------------------
    $current = [
        'date'         => $previous['date'] ?? null,
        'start'        => $previous['start'] ?? null,
        'end'          => $previous['end'] ?? null,
        'teacher'      => $teacherId,
        'reason'       => $reason,
        'message'      => $message,
        'acknowledged' => $ack,
        'time'         => time(),
        'action'       => 'cancel'
    ];

    // -------------------------------------------------
    // Final details JSON
    // -------------------------------------------------
    $details = [
        'previous' => $previous,
        'current'  => $current,
        'action'   => 'cancel'
    ];

    // -------------------------------------------------
    // Update / Insert status row
    // -------------------------------------------------
    if ($statusrow) {
        $update = new stdClass();
        $update->id           = $statusrow->id;
        $update->statuscode   = 'cancel';
        $update->detailsjson  = json_encode($details);
        $update->timemodified = time();
        $update->createdby   = $USER->id;

        $DB->update_record('local_gm_event_status', $update);
    } else {
        $insert = new stdClass();
        $insert->eventid      = $eventid;
        $insert->googlemeetid = $event->googlemeetid;
        $insert->statuscode   = 'cancel';
        $insert->isactive     = 1;
        $insert->detailsjson  = json_encode($details);
        $insert->timecreated  = time();
        $insert->timemodified = time();
        $insert->createdby    = $USER->id;

        $DB->insert_record('local_gm_event_status', $insert);
    }

    // -------------------------------------------------
    // Soft-cancel googlemeet_events
    // -------------------------------------------------
    $event->duration     = 0;
    $event->timemodified = time();
    $DB->update_record('googlemeet_events', $event);

    // -------------------------------------------------
    // Response
    // -------------------------------------------------
    echo json_encode([
        'status'  => 'success',
        'message' => '1:1 session cancelled successfully',
        'eventid' => $eventid
    ]);
    exit;

} catch (Throwable $e) {
    echo json_encode([
        'status' => 'error',
        'error'  => $e->getMessage()
    ]);
    exit;
}
