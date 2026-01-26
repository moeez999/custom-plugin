<?php
defined('MOODLE_INTERNAL') || die();






/**
 * --------------------------------------------------
 * SCENARIO 2
 * THIS_AND_FOLLOWING → TIME ONLY (SAME GOOGLEMEET)
 * --------------------------------------------------
 * ❌ No googlemeet_events update
 * ✅ Update googlemeet table
 * ✅ Insert googlemeet-level time history
 */
function gm_apply_time_this_and_following(array $data, $DB): array {
    global $USER, $CFG, $PAGE;

    require_once($CFG->dirroot . '/mod/googlemeet/lib.php');

    foreach ($data['googlemeets'] as $gmdata) {

        [$sh, $sm] = array_map('intval', explode(':', $gmdata['current']['start']));
        [$eh, $em] = array_map('intval', explode(':', $gmdata['current']['end']));

        try {
            $gm = $DB->get_record('googlemeet', ['id' => (int)$gmdata['googlemeetid']], '*', MUST_EXIST);

            // Idempotent guard
            if (
                (int)$gm->starthour === $sh &&
                (int)$gm->startminute === $sm &&
                (int)$gm->endhour === $eh &&
                (int)$gm->endminute === $em
            ) {
                continue;
            }

            // History
            $DB->insert_record('local_gm_googlemeet_time_history', (object)[
                'googlemeetid' => $gm->id,
                'oldstart'     => "{$gm->starthour}:{$gm->startminute}",
                'oldend'       => "{$gm->endhour}:{$gm->endminute}",
                'newstart'     => "{$sh}:{$sm}",
                'newend'       => "{$eh}:{$em}",
                'scope'        => 'THIS_AND_FOLLOWING',
                'timecreated'  => time(),
                'createdby'    => $USER->id ?? 0
            ]);

            $cm = get_coursemodule_from_instance(
                'googlemeet',
                $gm->id,
                $gm->course,
                false,
                MUST_EXIST
            );

            $context = context_module::instance($cm->id);
            $PAGE->set_context($context);

            require_once(__DIR__ . '/../../../config.php');

            global $USER;
            $USER = get_admin();

            // Permission REQUIRED for calendar update
            require_capability('moodle/calendar:manageentries', $context);

            // Apply time change
            $gm->starthour    = (int)$sh;
            $gm->startminute  = (int)$sm;
            $gm->endhour      = (int)$eh;
            $gm->endminute    = (int)$em;
            $gm->timemodified = time();

            // Mandatory fields for update_instance
            $gm->instance     = $gm->id;
            $gm->coursemodule = $cm->id;

            // -------------------------------------------------------
            // ✅ ADD #1: Update googlemeet master record (time fields)
            // -------------------------------------------------------
            $DB->update_record('googlemeet', $gm);

            // -------------------------------------------------------
            // ✅ ADD #2: Update FUTURE events duration (date unchanged)
            // duration = (end-start) minutes
            // -------------------------------------------------------
            $newduration = ((int)$eh * 60 + (int)$em) - ((int)$sh * 60 + (int)$sm);
            if ($newduration <= 0) {
                throw new moodle_exception('invaliddata', 'error', '', 'End time must be after start time');
            }

            // Use anchorDate from payload (same format you already validate in caller)
            $anchorDate = trim((string)($data['anchorDate'] ?? ''));
            if ($anchorDate === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $anchorDate)) {
                // fallback: update from "now" if anchorDate not provided
                $anchorTs = time();
            } else {
                $anchorTs = strtotime($anchorDate); // midnight
            }

            $DB->execute(
                "UPDATE {googlemeet_events}
                 SET duration = :duration,
                     timemodified = :tm
                 WHERE googlemeetid = :gid
                   AND eventdate >= :anch",
                [
                    'duration' => $newduration,
                    'tm'       => time(),
                    'gid'      => $gm->id,
                    'anch'     => $anchorTs
                ]
            );

            // This will now WORK
            //googlemeet_update_instance($gm, null);

        } catch (Throwable $e) {
            echo json_encode([
                'ok'    => false,
                'error' => $e->getMessage(),
                'type'  => get_class($e)
            ]);
            exit;
        }
    }

    return [
        'ok' => true,
        'message' => 'Time updated for this and following events'
    ];
}






/**
 * --------------------------------------------------
 * WEEK POPUP ENTRY (DIFF-DRIVEN)
 * --------------------------------------------------
 * ✅ No transaction here
 * ✅ No echo / exit
 * ✅ Throws moodle_exception on invalid payload
 */
function gm_apply_week_popup_changes(array $data): array {

    // Identify changes → normalized actions
    $actions = gm_identify_actions($data);

    $results = [];

    foreach ($actions as $action) {

        switch ($action['type']) {

            case 'UPDATE_SINGLE':
                gm_update_single_event(
                    $data,
                    (int)$action['googlemeetid'],
                    (array)$action['diff']
                );
                $results[] = ['action' => 'UPDATE_SINGLE', 'status' => 'ok', 'googlemeetid' => (int)$action['googlemeetid']];
                break;

            case 'UPDATE_RECURRING':
                gm_update_recurring_series(
                    $data,
                    (int)$action['googlemeetid'],
                    (array)$action['diff']
                );
                $results[] = ['action' => 'UPDATE_RECURRING', 'status' => 'ok', 'googlemeetid' => (int)$action['googlemeetid']];
                break;

            case 'CREATE_RECURRING':
                $newid = gm_create_recurring_series(
                    (array)$action['anchor'],
                    (array)$action['schedule']
                );
                $results[] = ['action' => 'CREATE_RECURRING', 'status' => 'ok', 'newgooglemeetid' => (int)$newid];
                break;
            case 'UPDATE_TEACHER_RECURRING':
                gm_update_teacher_this_and_following(
                    $data,
                    (int)$action['googlemeetid'],
                    (array)$action['diff']
                );
                $results[] = [
                    'action' => 'UPDATE_TEACHER_RECURRING',
                    'status' => 'ok',
                    'googlemeetid' => (int)$action['googlemeetid']
                ];
                break;

            case 'CANCEL':
                gm_cancel_googlemeet_events(
                    $data,
                    (int)$action['googlemeetid'],
                    (string)$action['scope'],
                    (array)$action['reason']
                );

                $results[] = [
                    'action'        => 'CANCEL',
                    'status'        => 'ok',
                    'googlemeetid'  => (int)$action['googlemeetid'],
                    'scope'         => $action['scope']
                ];
                break;


            default:
                throw new moodle_exception('invaliddata', 'error', '', 'Unknown action type: ' . ($action['type'] ?? ''));
        }
    }

    return [
        'ok'      => true,
        'actions' => $results
    ];
}


/**
 * --------------------------------------------------
 * Identify what actions are requested from week popup payload
 * --------------------------------------------------
 *
 * Expected payload:
 *  - scope: THIS_AND_FOLLOWING
 *  - anchorEvent: { eventId, eventDate, googlemeetid(optional) }
 *  - changes: [
 *      {
 *        action: UPDATE_EXISTING | CREATE_NEW
 *        type: single|recurring
 *        googlemeetid (required for UPDATE_EXISTING)
 *        diff (required for UPDATE_EXISTING)
 *        schedule (required for CREATE_NEW)
 *      }
 *    ]
 */
function gm_identify_actions(array $data): array {

    if (empty($data['changes']) || !is_array($data['changes'])) {
        throw new moodle_exception('invaliddata', 'error', '', 'changes array required');
    }

    if (empty($data['anchorEvent']) || !is_array($data['anchorEvent'])) {
        throw new moodle_exception('invaliddata', 'error', '', 'anchorEvent required');
    }

    if (empty($data['anchorEvent']['eventId'])) {
        throw new moodle_exception('invaliddata', 'error', '', 'anchorEvent.eventId required');
    }

    if (empty($data['anchorEvent']['eventDate']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', (string)$data['anchorEvent']['eventDate'])) {
        throw new moodle_exception('invaliddata', 'error', '', 'anchorEvent.eventDate must be YYYY-MM-DD');
    }

    $actions = [];

    foreach ($data['changes'] as $idx => $change) {

        if (!is_array($change)) {
            throw new moodle_exception('invaliddata', 'error', '', "changes[$idx] must be object");
        }

        $action = strtoupper(trim((string)($change['action'] ?? '')));

        if ($action === 'UPDATE_EXISTING') {

            if (empty($change['googlemeetid'])) {
                throw new moodle_exception('invaliddata', 'error', '', "googlemeetid required for UPDATE_EXISTING at changes[$idx]");
            }

            if (empty($change['diff']) || !is_array($change['diff'])) {
                throw new moodle_exception('invaliddata', 'error', '', "diff required for UPDATE_EXISTING at changes[$idx]");
            }

            // Must contain at least one diff entry.
            // Must contain at least one diff entry.
            $diff = $change['diff'];
            if (empty($diff['time']) && empty($diff['days']) && empty($diff['period']) && empty($diff['end'])) {
                throw new moodle_exception(
                    'invaliddata',
                    'error',
                    '',
                    "No actionable changes detected at changes[$idx]"
                );
            }

            $type = strtolower(trim((string)($change['type'] ?? 'single')));

            if ($type === 'single') {
                $actions[] = [
                    'type'         => 'UPDATE_SINGLE',
                    'googlemeetid' => (int)$change['googlemeetid'],
                    'diff'         => (array)$change['diff'],
                    'anchor'       => (array)$data['anchorEvent'],
                ];
            } else if ($type === 'recurring') {
                $actions[] = [
                    'type'         => 'UPDATE_RECURRING',
                    'googlemeetid' => (int)$change['googlemeetid'],
                    'diff'         => (array)$change['diff'],
                    'anchor'       => (array)$data['anchorEvent'],
                ];
            } else {
                throw new moodle_exception('invaliddata', 'error', '', "Invalid type for UPDATE_EXISTING at changes[$idx]");
            }

        } else if ($action === 'CREATE_NEW') {

            if (empty($change['schedule']) || !is_array($change['schedule'])) {
                throw new moodle_exception('invaliddata', 'error', '', "schedule required for CREATE_NEW at changes[$idx]");
            }

            $type = strtolower(trim((string)($change['type'] ?? 'recurring')));

            if ($type !== 'recurring') {
                throw new moodle_exception('invaliddata', 'error', '', "Only recurring CREATE_NEW supported at changes[$idx]");
            }

            $actions[] = [
                'type'     => 'CREATE_RECURRING',
                'schedule' => (array)$change['schedule'],
                'anchor'   => (array)$data['anchorEvent'],
            ];

        } else if ($action === 'UPDATE_TEACHER_RECURRING') {

        if (empty($change['googlemeetid'])) {
                throw new moodle_exception('invaliddata', 'error', '', "googlemeetid required for UPDATE_EXISTING at changes[$idx]");
            }

            if (empty($change['diff']) || !is_array($change['diff'])) {
                throw new moodle_exception('invaliddata', 'error', '', "diff required for UPDATE_EXISTING at changes[$idx]");
            }


         $type = strtolower(trim((string)($change['type'] ?? 'single')));

            if ($type === 'single') {
                $actions[] = [
                    'type'         => 'UPDATE_SINGLE',
                    'googlemeetid' => (int)$change['googlemeetid'],
                    'diff'         => (array)$change['diff'],
                    'anchor'       => (array)$data['anchorEvent'],
                ];
            } else if ($type === 'recurring') {
                $actions[] = [
                    'type'         => 'UPDATE_TEACHER_RECURRING',
                    'googlemeetid' => (int)$change['googlemeetid'],
                    'diff'         => (array)$change['diff'],
                    'anchor'       => (array)$data['anchorEvent'],
                ];
            } else {
                throw new moodle_exception('invaliddata', 'error', '', "Invalid type for UPDATE_EXISTING at changes[$idx]");
            }

        } else if ($action === 'CANCEL') {

            if (empty($change['googlemeetid'])) {
                throw new moodle_exception(
                    'invaliddata',
                    'error',
                    '',
                    "googlemeetid required for CANCEL at changes[$idx]"
                );
            }

            $scope = strtoupper(trim((string)($change['scope'] ?? $data['scope'] ?? '')));

            if (!in_array($scope, ['THIS_OCCURRENCE', 'THIS_AND_FOLLOWING'], true)) {
                throw new moodle_exception(
                    'invaliddata',
                    'error',
                    '',
                    "Invalid scope for CANCEL at changes[$idx]"
                );
            }

            $actions[] = [
                'type'         => 'CANCEL',
                'googlemeetid' => (int)$change['googlemeetid'],
                'scope'        => $scope,
                'anchor'       => (array)$data['anchorEvent'],
                'reason'       => (array)($change['reason'] ?? [])
            ];
        }
        else {
                    throw new moodle_exception('invaliddata', 'error', '', "Unknown action: $action at changes[$idx]");
                }
    }

    return $actions;
}


/**
 * --------------------------------------------------
 * 1️⃣ gm_update_single_event()
 * --------------------------------------------------
 * ✅ Updates only googlemeet_events row for anchorEvent.eventId
 * ✅ Uses diff['time']['to'] (and optionally diff['date']['to'] if you add later)
 * ✅ Inserts local_gm_event_time_history
 */
function gm_update_single_event(
    array $data,
    int $googlemeetid,
    array $diff
): void {
    global $DB, $USER;

    $anchor = $data['anchorEvent'] ?? null;
    if (!$anchor || empty($anchor['eventId'])) {
        throw new moodle_exception('invaliddata', 'error', '', 'anchorEvent.eventId required for UPDATE_SINGLE');
    }

    $eventid = (int)$anchor['eventId'];

    if (empty($diff['time']) || !is_array($diff['time']) || empty($diff['time']['to'])) {
        throw new moodle_exception('invaliddata', 'error', '', 'diff.time.to required for UPDATE_SINGLE');
    }

    $to = $diff['time']['to'];

    if (empty($to['start']) || empty($to['end'])) {
        throw new moodle_exception('invaliddata', 'error', '', 'diff.time.to.start and diff.time.to.end required');
    }

    if (!preg_match('/^\d{1,2}:\d{2}$/', (string)$to['start']) || !preg_match('/^\d{1,2}:\d{2}$/', (string)$to['end'])) {
        throw new moodle_exception('invaliddata', 'error', '', 'Invalid time format, expected HH:MM');
    }

    $ev = $DB->get_record('googlemeet_events', ['id' => $eventid], '*', MUST_EXIST);

    $eventDate = date('Y-m-d', (int)$ev->eventdate);

    [$sh, $sm] = array_map('intval', explode(':', $to['start']));
    [$eh, $em] = array_map('intval', explode(':', $to['end']));

    $newStart = strtotime($eventDate . ' ' . sprintf('%02d:%02d', $sh, $sm));
    $newEnd   = strtotime($eventDate . ' ' . sprintf('%02d:%02d', $eh, $em));

    if ($newEnd <= $newStart) {
        throw new moodle_exception('invaliddata', 'error', '', 'End must be after start');
    }

    $oldstart = (int)$ev->eventdate;
    $oldend   = $oldstart + ((int)$ev->duration * 60);

    // No-op guard.
    if ($oldstart === $newStart && $oldend === $newEnd) {
        return;
    }

    // History
    $DB->insert_record('local_gm_event_time_history', (object)[
        'eventid'      => $ev->id,
        'googlemeetid' => $googlemeetid,
        'oldstart'     => $oldstart,
        'oldend'       => $oldend,
        'newstart'     => $newStart,
        'newend'       => $newEnd,
        'scope'        => 'THIS_OCCURRENCE',
        'timecreated'  => time(),
        'createdby'    => $USER->id ?? 0
    ]);

    // Update
    $ev->eventdate     = $newStart;
    $ev->duration      = (int)(($newEnd - $newStart) / 60);
    $ev->timemodified  = time();

    $DB->update_record('googlemeet_events', $ev);
}


/**
 * --------------------------------------------------
 * 2️⃣ gm_update_recurring_series()
 * --------------------------------------------------
 * DIFF-driven:
 *  ✅ If only time diff => update googlemeet time + history + update duration for future events
 *  ✅ If days/period/end diff => split series from anchorDate and create new googlemeet
 *  ✅ If time + days diff => split and apply time on new series
 */
function gm_update_recurring_series(
    array $data,
    int $googlemeetid,
    array $diff
): void {
    global $DB, $USER;

    $anchor = $data['anchorEvent'] ?? null;
    if (!$anchor || empty($anchor['eventDate']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', (string)$anchor['eventDate'])) {
        throw new moodle_exception('invaliddata', 'error', '', 'anchorEvent.eventDate required for UPDATE_RECURRING');
    }

    $anchorDate = (string)$anchor['eventDate'];
    $anchorTs   = strtotime($anchorDate);

    $gm = $DB->get_record('googlemeet', ['id' => $googlemeetid], '*', MUST_EXIST);

    $hasTime   = !empty($diff['time']) && is_array($diff['time']);
    $hasDays   = !empty($diff['days']) && is_array($diff['days']);
    $hasPeriod = array_key_exists('period', $diff);
    $hasEnd    = !empty($diff['end']) && is_array($diff['end']);

        // ----------------------------
        // TIME ONLY => NO SPLIT
        // ----------------------------
        if ($hasTime && !$hasDays && !$hasPeriod && !$hasEnd) {

            if (empty($diff['time']['to']['start']) || empty($diff['time']['to']['end'])) {
                throw new moodle_exception(
                    'invaliddata',
                    'error',
                    '',
                    'diff.time.to.start and diff.time.to.end required'
                );
            }

            // Parse NEW time
            [$sh, $sm] = array_map('intval', explode(':', $diff['time']['to']['start']));
            [$eh, $em] = array_map('intval', explode(':', $diff['time']['to']['end']));

            // Idempotent guard
            if (
                (int)$gm->starthour   === $sh &&
                (int)$gm->startminute === $sm &&
                (int)$gm->endhour     === $eh &&
                (int)$gm->endminute   === $em
            ) {
                return;
            }

            // --------------------------------------------------
            // 1️⃣ HISTORY (googlemeet-level)
            // --------------------------------------------------
            $DB->insert_record('local_gm_googlemeet_time_history', (object)[
                'googlemeetid' => $gm->id,
                'oldstart'     => "{$gm->starthour}:{$gm->startminute}",
                'oldend'       => "{$gm->endhour}:{$gm->endminute}",
                'newstart'     => "{$sh}:{$sm}",
                'newend'       => "{$eh}:{$em}",
                'scope'        => 'THIS_AND_FOLLOWING',
                'timecreated'  => time(),
                'createdby'    => $USER->id ?? 0
            ]);

            // --------------------------------------------------
            // 2️⃣ UPDATE googlemeet MASTER (TIME ONLY)
            // --------------------------------------------------
            $gm->starthour    = $sh;
            $gm->startminute  = $sm;
            $gm->endhour      = $eh;
            $gm->endminute    = $em;
            $gm->timemodified = time();

            $DB->update_record('googlemeet', $gm);

            // --------------------------------------------------
            // 3️⃣ UPDATE googlemeet_events.duration (ONLY)
            // --------------------------------------------------
            $newduration = (($eh * 60 + $em) - ($sh * 60 + $sm));

            if ($newduration <= 0) {
                throw new moodle_exception(
                    'invaliddata',
                    'error',
                    '',
                    'End time must be after start time'
                );
            }

            // $DB->execute(
            //     "UPDATE {googlemeet_events}
            //         SET duration = :duration,
            //             timemodified = :tm
            //     WHERE googlemeetid = :gid",
            //     [
            //         'duration' => $newduration,
            //         'tm'       => time(),
            //         'gid'      => $gm->id
            //     ]
            // );

             // --------------------------------------------------
            // 3️⃣ EVENT-LEVEL HISTORY (ONLY FUTURE EVENTS)
            // --------------------------------------------------
            $events = $DB->get_records_select(
                'googlemeet_events',
                'googlemeetid = :gid AND eventdate >= :anch',
                ['gid' => $gm->id, 'anch' => $anchorTs],
                'eventdate ASC'
            );

            foreach ($events as $ev) {

            $oldstart = (int)$ev->eventdate;
            $oldend   = $oldstart + (int)$ev->duration;

            $eventDate = date('Y-m-d', $oldstart);

            $newstart = strtotime($eventDate . sprintf(' %02d:%02d', $sh, $sm));
            $newend   = strtotime($eventDate . sprintf(' %02d:%02d', $eh, $em));

            if ($newend <= $newstart) {
                $newend += DAYSECS;
            }

            $newduration = (int)($newend - $newstart); // seconds

            // --------------------------------------------------
            // TIME HISTORY
            // --------------------------------------------------
            $DB->insert_record('local_gm_event_time_history', (object)[
                'eventid'      => $ev->id,
                'googlemeetid' => $gm->id,
                'oldstart'     => $oldstart,
                'oldend'       => $oldend,
                'newstart'     => $newstart,
                'newend'       => $newend,
                'scope'        => 'THIS_AND_FOLLOWING',
                'timecreated'  => time(),
                'createdby'    => $USER->id ?? 0
            ]);

            // --------------------------------------------------
            // CURRENT STATUS (UPSERT)
            // --------------------------------------------------
            $statusrec = $DB->get_record(
                'local_gm_event_status',
                ['eventid' => $ev->id],
                '*',
                IGNORE_MISSING
            );

            $currentstatus = $statusrec->status ?? 'rescheduled';

            if ($statusrec) {
                $statusrec->timemodified = time();
                $DB->update_record('local_gm_event_status', $statusrec);
            } else {
                $DB->insert_record('local_gm_event_status', (object)[
                    'eventid'      => $ev->id,
                    'googlemeetid' => $gm->id,
                    'status'       => $currentstatus,
                    'scope'        => 'THIS_AND_FOLLOWING',
                    'timecreated'  => time(),
                    'createdby'    => $USER->id ?? 0
                ]);
            }

            // --------------------------------------------------
            // 🔥 STATUS HISTORY (ALWAYS INSERT)
            // --------------------------------------------------
             $DB->insert_record('local_gm_event_status_history', (object)[
                'eventid'      => $ev->id,
                'googlemeetid' => $gm->id,
                'oldstatus'    => $currentstatus,
                'newstatus'    => 'rescheduled',
                'scope'        => '',
                'reason'       => null,
                'timecreated'  => time(),
                'createdby'    => $USER->id ?? 0
            ]);

            // --------------------------------------------------
            // UPDATE EVENT ITSELF
            // --------------------------------------------------
            $ev->eventdate    = $newstart;
            $ev->duration     = $newduration;
            $ev->timemodified = time();

            $DB->update_record('googlemeet_events', $ev);
        }

        return; // 🔥 STOP HERE — NO SPLIT

        }


    // ----------------------------
    // SPLIT REQUIRED (days/period/end OR time+days etc)
    // ----------------------------
    // End old series the day before anchor
    $oldEnd = strtotime($anchorDate . ' -1 day');
    if ($oldEnd < (int)$gm->eventdate) {
        $oldEnd = (int)$gm->eventdate;
    }

    $gm->eventenddate = $oldEnd;
    $gm->timemodified = time();
    $DB->update_record('googlemeet', $gm);

    // Delete old future events from anchor onwards
    $DB->delete_records_select(
        'googlemeet_events',
        'googlemeetid = :gid AND eventdate >= :anch',
        ['gid' => $gm->id, 'anch' => $anchorTs]
    );

    // Clone googlemeet to new series
    $newgm = clone $gm;
    unset($newgm->id);

    // Apply DAYS diff (if present)
    if ($hasDays) {
        if (empty($diff['days']['to']) || !is_array($diff['days']['to'])) {
            throw new moodle_exception('invaliddata', 'error', '', 'diff.days.to must be array');
        }
        $toDays = $diff['days']['to']; // e.g. ["Mon","Wed"] OR ["MON","WED"]
        $daysMap = [];
        foreach ($toDays as $d) {
            $key = ucfirst(strtolower(trim((string)$d))); // "Mon"
            $daysMap[$key] = "1";
        }
        $newgm->days = json_encode($daysMap);
        $newgm->addmultiply = 1;
    }

    // Apply PERIOD diff (if present)
    if ($hasPeriod) {
        $p = (int)($diff['period']['to'] ?? $diff['period'] ?? 1);
        $p = max(1, $p);
        $newgm->period = $p;
        $newgm->addmultiply = 1;
    }

    // Apply TIME diff (if present)
    if ($hasTime) {
        if (empty($diff['time']['to']['start']) || empty($diff['time']['to']['end'])) {
            throw new moodle_exception('invaliddata', 'error', '', 'diff.time.to.start/end required');
        }
        [$sh, $sm] = array_map('intval', explode(':', $diff['time']['to']['start']));
        [$eh, $em] = array_map('intval', explode(':', $diff['time']['to']['end']));
        $newgm->starthour   = $sh;
        $newgm->startminute = $sm;
        $newgm->endhour     = $eh;
        $newgm->endminute   = $em;
    }

    // Anchor start
    $newgm->eventdate = $anchorTs;

    // Apply END diff (if present)
    if ($hasEnd) {
        // Keep your existing style: {type:"NEVER"} etc.
        $type = strtoupper(trim((string)($diff['end']['to']['type'] ?? $diff['end']['type'] ?? 'NEVER')));
        if ($type === 'ON_DATE') {
            $v = trim((string)($diff['end']['to']['value'] ?? $diff['end']['value'] ?? ''));
            if ($v === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) {
                throw new moodle_exception('invaliddata', 'error', '', 'end.value must be YYYY-MM-DD');
            }
            $newgm->eventenddate = strtotime($v);
        } else {
            // NEVER (or unknown) => 0
            $newgm->eventenddate = 0;
        }
    } else {
        $newgm->eventenddate = 0;
    }

    $newgm->lastsync = null;
    $newgm->eventid  = null;
    $newgm->timemodified = time();

    $newid = $DB->insert_record('googlemeet', $newgm);

    // Generate new occurrences (use your local generator if you already have one)
    // NOTE: this uses the core mod function name in your earlier file was generate_occurrences.
    // If your generator is named differently, keep yours. DO NOT change that function.
    $newgm->id = $newid;
    if (function_exists('generate_occurrences')) {
        generate_occurrences($newgm, $anchorTs, null);
    }
}


/**
 * --------------------------------------------------
 * 3️⃣ gm_create_recurring_series()
 * --------------------------------------------------
 * ✅ Creates a new googlemeet based on the anchor's googlemeet (copy)
 * ✅ Applies schedule block
 * ✅ Generates occurrences (if generator exists)
 * ✅ Returns new googlemeetid
 */
function gm_create_recurring_series(
    array $anchor,
    array $schedule
): int {
    global $DB, $CFG, $USER;

    require_once($CFG->dirroot . '/course/modlib.php');

    if (empty($anchor['googlemeetid'])) {
        throw new moodle_exception('invaliddata', 'error', '', 'anchorEvent.googlemeetid required');
    }

    // Load original googlemeet
    $origgm = $DB->get_record('googlemeet', ['id' => (int)$anchor['googlemeetid']], '*', MUST_EXIST);

    // Resolve teacher section (THIS is why it was going wrong before)
    $cm = get_coursemodule_from_instance(
        'googlemeet',
        $origgm->id,
        $origgm->course,
        false,
        MUST_EXIST
    );

    $sectionid = (int)$cm->section; // 🔥 teacher section id (542)

    $section = $DB->get_record(
    'course_sections',
    ['id' => $sectionid],
    'id, section, availability',
    MUST_EXIST
);

    $availabilityjson = $section->availability; // RAW JSON (string or null)

    $email = null;

    if (!empty($availabilityjson)) {
        $availability = json_decode($availabilityjson, true);

        if (!empty($availability['c']) && is_array($availability['c'])) {
            foreach ($availability['c'] as $condition) {
                if (
                    ($condition['type'] ?? '') === 'profile' &&
                    ($condition['sf'] ?? '') === 'email' &&
                    !empty($condition['v'])
                ) {
                    $email = $condition['v'];
                    break; // only one email expected
                }
            }
        }
    }

    $sectionnum = gm_get_section_by_email_availability((int)$cm->course, $email);

    // Validate schedule
    if (
        empty($schedule['start']) ||
        empty($schedule['end']) ||
        empty($schedule['days']) ||
        empty($schedule['startDate'])
    ) {
        throw new moodle_exception('invaliddata', 'error', '', 'Invalid schedule');
    }

    // Parse time
    if (!is_string($schedule['start']) || !is_string($schedule['end'])) {
        throw new moodle_exception('invaliddata', 'error', '', 'schedule.start/end must be strings');
    }

    [$sh, $sm] = array_map('intval', explode(':', $schedule['start']));
    [$eh, $em] = array_map('intval', explode(':', $schedule['end']));

    // Build days array
    $days = [];
    foreach ($schedule['days'] as $d) {
        $key = ucfirst(strtolower(trim($d))); // Mon Tue Wed Thu
        $days[$key] = '1';
    }

     // --------------------------------------------
    // Resolve student via availability
    // --------------------------------------------
    $availability = gm_get_availability_from_googlemeet((int)$origgm->id);

    // ----------------------------
    // BUILD MODULEINFO (CRITICAL)
    // ----------------------------
    $moduleinfo = new stdClass();

    // REQUIRED BY add_moduleinfo
    $moduleinfo->modulename = 'googlemeet';
    $moduleinfo->module     = 24;              // 🔥 FIXES YOUR ERROR
    $moduleinfo->course     = $origgm->course;
    //$moduleinfo->section    = $sectionid;
    $moduleinfo->section    = $sectionnum;
    $moduleinfo->visible    = 1;

    // GoogleMeet fields
    $moduleinfo->name          = $origgm->name;
    $moduleinfo->intro         = $origgm->intro ?? '';
    $moduleinfo->introformat   = $origgm->introformat ?? FORMAT_HTML;
    $moduleinfo->notify        = $origgm->notify ?? 1;
    $moduleinfo->minutesbefore = $origgm->minutesbefore ?? 5;

    $moduleinfo->eventdate   = strtotime($schedule['startDate']);
    $moduleinfo->starthour   = $sh;
    $moduleinfo->startminute = $sm;
    $moduleinfo->endhour     = $eh;
    $moduleinfo->endminute   = $em;

    // Recurrence
    $moduleinfo->addmultiply = 1;
    $moduleinfo->days        = $days;
    $moduleinfo->period      = max(1, (int)($schedule['period'] ?? 1));

    // End rule
   // --------------------------------------------
// Recurrence end rule (CRITICAL LOGIC)
// --------------------------------------------
    $moduleinfo->eventenddate = 0; // DEFAULT = NEVER

    if (!empty($schedule['endRule']) && is_array($schedule['endRule'])) {

        $type = $schedule['endRule']['type'] ?? 'NEVER';

        if ($type === 'ON_DATE') {
            if (empty($schedule['endRule']['value'])) {
                throw new moodle_exception(
                    'invaliddata',
                    'error',
                    '',
                    'endRule.value required for ON_DATE'
                );
            }

            $endts = strtotime($schedule['endRule']['value']);
            if ($endts === false) {
                throw new moodle_exception(
                    'invaliddata',
                    'error',
                    '',
                    'Invalid endRule date'
                );
            }

            $moduleinfo->eventenddate = $endts;
        }

        // type === NEVER → keep eventenddate = 0
    }

     
    $moduleinfo->availability = json_encode($availability);


    // ----------------------------
    // CREATE MODULE (CORE API)
    // ----------------------------
    $course = $DB->get_record('course', ['id' => $origgm->course], '*', MUST_EXIST);

    $coursecontext = context_course::instance($origgm->course);

   // --------------------------------------------------
    // TEMPORARILY EXECUTE AS ADMIN
    // --------------------------------------------------
    $admin = get_admin();
    $originaluser = $USER;

    \core\session\manager::set_user($admin);

    try {
    $newcm = add_moduleinfo($moduleinfo, $course);
} finally {
    // ALWAYS restore original user
    \core\session\manager::set_user($originaluser);
}

    if (empty($newcm->instance)) {
        throw new moodle_exception('error', 'error', '', 'GoogleMeet creation failed');
    }

    return (int)$newcm->instance;
}



/**
 * Resolve availability JSON from googlemeet (profile → email)
 */
function gm_get_availability_from_googlemeet(int $googlemeetid): array {
    global $DB;

    // Get course module
    $cm = $DB->get_record(
        'course_modules',
        ['instance' => $googlemeetid],
        '*',
        MUST_EXIST
    );

    if (empty($cm->availability)) {
        throw new moodle_exception(
            'invaliddata',
            'error',
            '',
            'No availability restriction found on googlemeet'
        );
    }

    $availability = json_decode($cm->availability, true);

    if (
        empty($availability['c']) ||
        !is_array($availability['c'])
    ) {
        throw new moodle_exception(
            'invaliddata',
            'error',
            '',
            'Invalid availability structure'
        );
    }

    // Validate profile → email exists
    foreach ($availability['c'] as $cond) {
        if (
            ($cond['type'] ?? '') === 'profile' &&
            ($cond['sf'] ?? '') === 'email' &&
            !empty($cond['v'])
        ) {
            return $availability; // ✅ FULL availability JSON
        }
    }

    throw new moodle_exception(
        'invaliddata',
        'error',
        '',
        'No profile email restriction found'
    );
}



function gm_get_section_by_email_availability(int $courseid, string $email): ?int {
    global $DB;

    $email = strtolower(trim($email));

    $sections = $DB->get_records(
        'course_sections',
        ['course' => $courseid],
        'section ASC',
        'id, section, availability'
    );

    foreach ($sections as $section) {

        if (empty($section->availability)) {
            continue;
        }

        $availability = json_decode($section->availability, true);
        if (!is_array($availability) || empty($availability['c'])) {
            continue;
        }

        foreach ($availability['c'] as $condition) {

            if (
                ($condition['type'] ?? '') === 'profile' &&
                ($condition['sf'] ?? '') === 'email' &&
                !empty($condition['v']) &&
                strtolower($condition['v']) === $email
            ) {
                // ✅ RETURN SECTION NUMBER (0,1,2,...)
                return (int)$section->section;
            }
        }
    }

    return null;
}




/**
 * --------------------------------------------------
 * UPDATE TEACHER → THIS AND FOLLOWING
 * --------------------------------------------------
 * ✅ Uses existing assign_teacher logic
 * ✅ Inserts history per event
 * ✅ No time / recurrence logic touched
 */
function gm_update_teacher_this_and_following(
    array $data,
    int $googlemeetid,
    array $diff
): void {
    global $DB;

    if (
        empty($diff['teacher']) ||
        empty($diff['teacher']['from']) ||
        empty($diff['teacher']['to'])
    ) {
        throw new moodle_exception(
            'invaliddata',
            'error',
            '',
            'diff.teacher.from and diff.teacher.to required'
        );
    }

    $fromTeacher = (int)$diff['teacher']['from'];
    $toTeacher   = (int)$diff['teacher']['to'];
    $reason      = trim((string)($diff['teacher']['reason'] ?? ''));

    $anchorDate = $data['anchorEvent']['eventDate'];
    $anchorTs   = strtotime($anchorDate);

    // --------------------------------------------------
    // Get all future events of this googlemeet
    // --------------------------------------------------
    $events = $DB->get_records_select(
        'googlemeet_events',
        'googlemeetid = :gid AND eventdate >= :anch',
        ['gid' => $googlemeetid, 'anch' => $anchorTs],
        'eventdate ASC',
        'id'
    );

    if (!$events) {
        return; // nothing to update
    }

    foreach ($events as $ev) {
        // -------------------------------
        // APPLY TEACHER (EXISTING HELPER)
        // -------------------------------
        assign_teacher(
            $ev->id,
            $googlemeetid,
            $toTeacher,
            'THIS_AND_FOLLOWING',
            $fromTeacher
        );
    }
}



   function assign_teacher(
    int $eid,
    int $gid,
    int $newteacherid,
    string $scope,
    ?int $oldteacherid = null
): void {
    global $DB, $USER;

    if ($newteacherid <= 0) {
        throw new moodle_exception('invaliddata', 'error', '', 'New teacher required');
    }

    // Load existing assignment if old not provided
    $existing = $DB->get_record(
        'local_gm_teacher_assignment',
        ['eventid' => $eid],
        '*',
        IGNORE_MISSING
    );

    if ($oldteacherid === null && $existing) {
        $oldteacherid = (int)$existing->teacherid;
    }

    // 🔒 Idempotent guard (VERY IMPORTANT)
    if ($oldteacherid !== null && $oldteacherid === $newteacherid) {
        return;
    }

    // -------------------------
    // Teacher history
    // -------------------------
    $DB->insert_record('local_gm_teacher_history', (object)[
        'eventid'      => $eid,
        'googlemeetid' => $gid,
        'oldteacherid' => $oldteacherid,
        'newteacherid' => $newteacherid,
        'scope'        => $scope,
        'timecreated'  => time(),
        'createdby'    => $USER->id ?? 0
    ]);

    // -------------------------
    // Upsert assignment
    // -------------------------
    if ($existing) {
        $existing->teacherid    = $newteacherid;
        $existing->timemodified = time();
        $existing->updatedby    = $USER->id ?? 0;
        $DB->update_record('local_gm_teacher_assignment', $existing);
    } else {
        $DB->insert_record('local_gm_teacher_assignment', (object)[
            'eventid'      => $eid,
            'googlemeetid' => $gid,
            'teacherid'    => $newteacherid,
            'timecreated'  => time(),
            'timemodified' => time(),
            'createdby'    => $USER->id ?? 0
        ]);
    }

    // -------------------------
    // Status marker
    // -------------------------
    $DB->insert_record('local_gm_event_status_history', (object)[
        'eventid'      => $eid,
        'googlemeetid' => $gid,
        'oldstatus'    => 'scheduled',
        'newstatus'    => 'teacher_changed',
        'scope'        => $scope,
        'reason'       => null,
        'timecreated'  => time(),
        'createdby'    => $USER->id ?? 0
    ]);
}


/**
 * --------------------------------------------------
 * CANCEL GOOGLE MEET EVENTS
 * --------------------------------------------------
 * ✅ Supports THIS_OCCURRENCE / THIS_AND_FOLLOWING
 * ✅ No deletes
 * ✅ History + status marker
 */
function gm_cancel_googlemeet_events(
    array $data,
    int $googlemeetid,
    string $scope,
    array $reason = []
): void {
    global $DB, $USER;

    $anchor = $data['anchorEvent'] ?? null;
    if (!$anchor || empty($anchor['eventDate'])) {
        throw new moodle_exception(
            'invaliddata',
            'error',
            '',
            'anchorEvent.eventDate required for CANCEL'
        );
    }

    $anchorTs = strtotime($anchor['eventDate']);

    if ($scope === 'THIS_OCCURRENCE') {

        if (empty($anchor['eventId'])) {
            throw new moodle_exception(
                'invaliddata',
                'error',
                '',
                'anchorEvent.eventId required for THIS_OCCURRENCE cancel'
            );
        }

        $events = [
            $DB->get_record(
                'googlemeet_events',
                ['id' => (int)$anchor['eventId']],
                '*',
                MUST_EXIST
            )
        ];

    } else { // THIS_AND_FOLLOWING

        $events = $DB->get_records_select(
            'googlemeet_events',
            'googlemeetid = :gid AND eventdate >= :anch',
            ['gid' => $googlemeetid, 'anch' => $anchorTs],
            'eventdate ASC',
            '*'
        );
    }

    if (!$events) {
        return;
    }

    foreach ($events as $ev) {

        // 🔒 Idempotent guard
        $already = $DB->record_exists(
            'local_gm_event_status_history',
            [
                'eventid'   => $ev->id,
                'newstatus' => 'cancelled'
            ]
        );

        if ($already) {
            continue;
        }

        // -------------------------
        // Status history
        // -------------------------
        $DB->insert_record('local_gm_event_status_history', (object)[
            'eventid'      => $ev->id,
            'googlemeetid' => $googlemeetid,
            'oldstatus'    => 'scheduled',
            'newstatus'    => 'cancelled',
            'scope'        => $scope,
            'reason'       => trim((string)($reason['message'] ?? null)),
            'timecreated'  => time(),
            'createdby'    => $USER->id ?? 0
        ]);
    }
}

