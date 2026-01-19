<?php
// local/yourplugin/ajax/update_one_on_one_schedule.php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ . '/lib.php');
// require_login();

@header('Content-Type: application/json; charset=utf-8');

global $DB, $USER;

try {
    // -----------------------------
    // Read JSON payload
    // -----------------------------
    if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === false) {
        throw new moodle_exception('invalidrequest', 'error', '', 'JSON expected');
    }
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        throw new moodle_exception('invaliddata', 'error', '', 'Invalid JSON');
    }

    // -----------------------------
    // Validate basic inputs
    // -----------------------------
    $scope = strtoupper(trim($data['scope'] ?? ''));

        // -----------------------------
    // Scope handler
    // -----------------------------
    if ($scope === 'THIS_AND_FOLLOWING') {

        // 🔒 START TRANSACTION HERE
        $tx = $DB->start_delegated_transaction();

        try {

            $gmresult = gm_apply_week_popup_changes($data);

            // ✅ COMMIT HERE (ONLY HERE)
            $tx->allow_commit();

            echo json_encode([
                'ok' => true,
                'scope' => $scope,
                'result' => $gmresult
            ]);
            exit;

        } catch (Throwable $e) {

            // ❌ ROLLBACK ON ERROR
            $tx->rollback($e);

            http_response_code(400);
            echo json_encode([
                'ok'    => false,
                'error' => $e->getMessage(),
                'type'  => get_class($e)
            ]);
            exit;
        }
    }





    if (!in_array($scope, ['THIS_OCCURRENCE', 'THIS_AND_FOLLOWING', 'ALL_OCCURRENCES'], true)) {
        throw new moodle_exception('invaliddata', 'error', '', 'scope invalid');
    }

    $eventid      = (int)($data['eventId'] ?? 0);
    $googlemeetid = (int)($data['googlemeetid'] ?? 0);

    if ($eventid <= 0) {
        throw new moodle_exception('missingparam', 'error', '', 'eventId required');
    }
    if ($googlemeetid <= 0) {
        $ev = $DB->get_record('googlemeet_events', ['id' => $eventid], 'googlemeetid', MUST_EXIST);
        $googlemeetid = (int)$ev->googlemeetid;
    }

    $anchorDate = trim($data['anchorDate'] ?? '');
    if ($anchorDate === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $anchorDate)) {
        $ev = $DB->get_record('googlemeet_events', ['id' => $eventid], 'eventdate', MUST_EXIST);
        $anchorDate = date('Y-m-d', (int)$ev->eventdate);
    }

    $current = $data['current'] ?? [];



    if (!is_array($current)) {
        throw new moodle_exception('invaliddata', 'error', '', 'current must be object');
    }



    $apply = $data['apply'] ?? [];

    if (!is_array($apply)) {
        $apply = [];
    }

    // force associative defaults
    $apply_time    = !empty($apply['time']);
    $apply_teacher = !empty($apply['teacher']);
    $apply_date    = !empty($apply['date']);

    // ---------------------------------------------------------



    if (!is_array($apply)) $apply = [];

    // Backward-compatible defaults:
    // If apply not provided, old behavior = schedule update for THIS, schedule+days for others.
    if ($scope !== 'THIS_OCCURRENCE') {
    $apply_time   = !empty($apply['time']);
    $apply_days   = !empty($apply['days']);
    $apply_period = !empty($apply['period']);
    $apply_end    = !empty($apply['end']);
    }



    // ---------------------------------------------------------
    // 🔧 BACKWARD-COMPAT: allow top-level time object
    // ---------------------------------------------------------
    if (
        $apply_time &&
        empty($current['start']) &&
        isset($data['time']) &&
        is_array($data['time'])
    ) {
        if (empty($data['time']['start']) || empty($data['time']['end'])) {
            throw new moodle_exception(
                'invaliddata',
                'error',
                '',
                'time.start and time.end required'
            );
        }

        $current['start'] = $data['time']['start'];
        $current['end']   = $data['time']['end'];
    }


    $apply_teacher = array_key_exists('teacher', $apply) ? (bool)$apply['teacher'] : !empty($data['teacher']);
    $apply_status  = array_key_exists('status', $apply) ? (bool)$apply['status'] : !empty($data['status']);
    $apply_snapshot = array_key_exists('snapshotStudents', $apply) ? (bool)$apply['snapshotStudents'] : !empty($data['snapshotStudents']);

    // If cancel exists -> do not validate time/days here.
    if (empty($data['cancel'])) {

        // Only require time if time will be applied OR if you are changing schedule scope that needs time.
        // if ($apply_time) {
        //     if (empty($current['start']) || empty($current['end'])) {
        //         throw new moodle_exception('invaliddata', 'error', '', 'current.start and current.end required (apply.time=true)');
        //     }
        // }

        // Only require time if time is ACTUALLY being changed
        // if ($apply_time && !empty($apply['time'])) {
        //     if (empty($current['start']) || empty($current['end'])) {
        //         throw new moodle_exception(
        //             'invaliddata',
        //             'error',
        //             '',
        //             'current.start and current.end required (apply.time=true)'
        //         );
        //     }
        // }

        if (
            $apply_time && !empty($apply['time']) &&
            $scope !== 'THIS_AND_FOLLOWING' &&
            (empty($current['start']) || empty($current['end']))
        ) {
            throw new moodle_exception(
                'invaliddata',
                'error',
                '',
                'current.start and current.end required (apply.time=true)'
            );
        }



        // Only require days when days will be applied for scopes that need it.
        // if (($scope !== 'THIS_OCCURRENCE') && $apply_days) {
        //     if (empty($current['days']) || !is_array($current['days'])) {
        //         throw new moodle_exception('invaliddata', 'error', '', 'current.days required (apply.days=true)');
        //     }
        // }

        // Only require days if days are EXPLICITLY being changed
        if (
            ($scope !== 'THIS_OCCURRENCE') &&
            !empty($apply['days']) &&
            $apply_days
        ) {
            if (empty($current['days']) || !is_array($current['days'])) {
                throw new moodle_exception(
                    'invaliddata',
                    'error',
                    '',
                    'current.days required (apply.days=true)'
                );
            }
        }

    }

    // Optional inputs
    $teacherNew = (int)($data['teacher']['new'] ?? 0);   // assign teacher
    $teacherReason = trim((string)($data['teacher']['reason'] ?? 'Teacher reassigned'));

    $statusNew  = trim((string)($data['status'] ?? '')); // e.g. cancelled, completed, in_progress, rescheduled
    $statusReason = trim((string)($data['reason'] ?? ''));

    // Student snapshot (optional)
    $snapshot = (bool)$apply_snapshot;
    $students = $data['students'] ?? []; // optional list of userids if you want manual snapshot
    if (!is_array($students)) $students = [];

    // -----------------------------
    // Helper functions (status/teacher/snapshot)
    // -----------------------------
    $ensure_event_status = function(int $eid, int $gid) use ($DB, $USER) {
        if (!$DB->record_exists('local_gm_event_status', ['eventid' => $eid])) {
            $DB->insert_record('local_gm_event_status', (object)[
                'eventid'      => $eid,
                'googlemeetid' => $gid,
                'status'       => 'scheduled',
                'lastupdated'  => time(),
                'updatedby'    => $USER->id
            ]);
        }
    };


    $build_ts_from_date_time = function(string $date, string $time): int {
    [$h, $m] = array_map('intval', explode(':', $time));
    return strtotime($date . ' ' . sprintf('%02d:%02d', $h, $m));
};

    $set_event_status = function(int $eid, int $gid, string $newstatus, string $scope, ?string $reason) use ($DB, $USER, $ensure_event_status) {
        $ensure_event_status($eid, $gid);
        $cur = $DB->get_record('local_gm_event_status', ['eventid' => $eid], '*', MUST_EXIST);

        $DB->insert_record('local_gm_event_status_history', (object)[
            'eventid' => $eid,
            'googlemeetid' => $gid,
            'oldstatus' => (string)$cur->status,
            'newstatus' => $newstatus,
            'scope' => $scope,
            'reason' => $reason,
            'timecreated' => time(),
            'createdby' => $USER->id
        ]);

        $cur->status = $newstatus;
        $cur->reason = $reason;
        $cur->lastupdated = time();
        $cur->updatedby = $USER->id;
        $DB->update_record('local_gm_event_status', $cur);
    };

   $assign_teacher = function(int $eid, int $gid, array $teacher, string $scope) use ($DB, $USER) {

    $newteacherid = (int)($teacher['new'] ?? 0);
    if ($newteacherid <= 0) {
        throw new moodle_exception('invaliddata', 'error', '', 'New teacher required');
    }

    // Prefer frontend old teacher if sent
    $oldteacherid = isset($teacher['old']) ? (int)$teacher['old'] : null;

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

    // 🔒 Idempotent guard
    if ($oldteacherid === $newteacherid) {
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
        'createdby'    => $USER->id
    ]);

    // -------------------------
    // Upsert assignment
    // -------------------------
    if ($existing) {
        $existing->teacherid    = $newteacherid;
        $existing->timemodified = time();
        $existing->updatedby    = $USER->id;
        $DB->update_record('local_gm_teacher_assignment', $existing);
    } else {
        $DB->insert_record('local_gm_teacher_assignment', (object)[
            'eventid'      => $eid,
            'googlemeetid' => $gid,
            'teacherid'    => $newteacherid,
            'timecreated'  => time(),
            'timemodified' => time(),
            'createdby'    => $USER->id
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
        'createdby'    => $USER->id
    ]);
};



    $snapshot_students = function(int $eid, int $gid, array $userids, string $source = 'MANUAL') use ($DB) {
        $now = time();
        foreach ($userids as $uid) {
            $uid = (int)$uid;
            if ($uid <= 0) continue;
            if ($DB->record_exists('local_gm_student_snapshot', ['eventid' => $eid, 'userid' => $uid])) {
                continue;
            }
            $DB->insert_record('local_gm_student_snapshot', (object)[
                'eventid' => $eid,
                'googlemeetid' => $gid,
                'userid' => $uid,
                'source' => $source,
                'timecreated' => $now
            ]);
        }
    };

    // ----------------------------------------------------
    // CANCEL LESSON (single occurrence only)
    // ----------------------------------------------------
    if (!empty($data['cancel']) && is_array($data['cancel'])) {

        $reason  = trim((string)($data['cancel']['reason'] ?? ''));
        $message = trim((string)($data['cancel']['message'] ?? ''));

        if ($reason === '') {
            throw new moodle_exception('invaliddata', 'error', '', 'Cancel reason required');
        }

        $ensure_event_status($eventid, $googlemeetid);

        $set_event_status(
            $eventid,
            $googlemeetid,
            'cancelled',
            'THIS',
            $reason
        );

        if ($message !== '') {
            $DB->insert_record('local_gm_event_status_history', (object)[
                'eventid'      => $eventid,
                'googlemeetid' => $googlemeetid,
                'oldstatus'    => 'cancelled',
                'newstatus'    => 'cancelled',
                'scope'        => 'THIS',
                'reason'       => 'Message: ' . $message,
                'timecreated'  => time(),
                'createdby'    => $USER->id
            ]);
        }

        echo json_encode([
            'ok' => true,
            'action' => 'cancelled',
            'eventid' => $eventid
        ]);
        exit;
    }

    // -----------------------------
    // Existing helper logic
    // -----------------------------
    $parse_time = function(string $hhmm): array {
        if (!preg_match('/^\d{1,2}:\d{2}$/', $hhmm)) {
            throw new moodle_exception('invaliddata', 'error', '', 'Invalid time: ' . $hhmm);
        }
        [$h, $m] = array_map('intval', explode(':', $hhmm));
        if ($h < 0 || $h > 23 || $m < 0 || $m > 59) {
            throw new moodle_exception('invaliddata', 'error', '', 'Invalid time: ' . $hhmm);
        }
        return [$h, $m];
    };

    $normalize_weekday = function($d): int {
        if (is_int($d) || ctype_digit((string)$d)) {
            $n = (int)$d;
            if ($n >= 0 && $n <= 6) return $n;
        }
        $s = strtoupper(trim((string)$d));
        $map = [
            'MON' => 0, 'MONDAY' => 0,
            'TUE' => 1, 'TUESDAY' => 1,
            'WED' => 2, 'WEDNESDAY' => 2,
            'THU' => 3, 'THURSDAY' => 3,
            'FRI' => 4, 'FRIDAY' => 4,
            'SAT' => 5, 'SATURDAY' => 5,
            'SUN' => 6, 'SUNDAY' => 6,
        ];
        if (!isset($map[$s])) {
            throw new moodle_exception('invaliddata', 'error', '', 'Invalid weekday: ' . $d);
        }
        return $map[$s];
    };

    $days_to_googlemeet_days_field = function(array $days) use ($normalize_weekday): string {
        $daynames = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
        $out = [];
        foreach ($days as $d) {
            $idx = $normalize_weekday($d);
            $out[$daynames[$idx]] = "1";
        }
        return json_encode($out);
    };

    $compute_duration_minutes = function(string $start, string $end) use ($parse_time): int {
        [$sh,$sm] = $parse_time($start);
        [$eh,$em] = $parse_time($end);
        $startmin = $sh * 60 + $sm;
        $endmin   = $eh * 60 + $em;
        $dur = $endmin - $startmin;
        if ($dur <= 0) {
            throw new moodle_exception('invaliddata', 'error', '', 'End time must be after start time');
        }
        return $dur;
    };

    $to_midnight_ts = function(string $ymd): int {
        $ts = strtotime($ymd);
        if (!$ts) throw new moodle_exception('invaliddata', 'error', '', 'Invalid date: ' . $ymd);
        return $ts;
    };

    $get_end_ts = function(array $cur, int $startts): int {
        $end = $cur['end'] ?? ['type' => 'NEVER'];
        if (!is_array($end) || empty($end['type'])) {
            return $startts + 180 * DAYSECS;
        }
        $type = strtoupper($end['type']);
        if ($type === 'ON_DATE') {
            $v = trim((string)($end['value'] ?? ''));
            if ($v === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) {
                throw new moodle_exception('invaliddata', 'error', '', 'end.value must be YYYY-MM-DD');
            }
            return strtotime($v);
        }
        return $startts + 180 * DAYSECS;
    };

    $generate_occurrences = function(stdClass $gm, int $fromts, ?int $tots = null) use ($DB): int {
        $count = 0;

        $isrecurring = ((int)$gm->addmultiply === 1) || ((int)$gm->period > 1) || (!empty($gm->days));
        $period = max(1, (int)($gm->period ?? 1));

        $startmin = ((int)$gm->starthour * 60) + (int)$gm->startminute;
        $endmin   = ((int)$gm->endhour * 60) + (int)$gm->endminute;
        $duration = max(1, $endmin - $startmin);

        $seriesstart = (int)$gm->eventdate;
        if ($seriesstart <= 0) $seriesstart = time();

        $endts = $tots ?? (int)($gm->eventenddate ?? 0);
        if ($endts <= 0) $endts = $fromts + 180 * DAYSECS;

        $fromts = max($fromts, $seriesstart);
        $endts  = max($endts, $fromts);

        if (!$isrecurring) {
            $dts = strtotime(date('Y-m-d', $seriesstart));
            if ($dts >= $fromts && $dts <= $endts) {
                $existing = $DB->get_record('googlemeet_events',
                    ['googlemeetid' => $gm->id, 'eventdate' => $dts],
                    '*', IGNORE_MISSING
                );
                if ($existing) {
                    $existing->duration = $duration;
                    $existing->timemodified = time();
                    $DB->update_record('googlemeet_events', $existing);
                } else {
                    $DB->insert_record('googlemeet_events', (object)[
                        'googlemeetid' => $gm->id,
                        'eventdate' => $dts,
                        'duration' => $duration,
                        'timemodified' => time(),
                    ]);
                }
                $count++;
            }
            return $count;
        }

        $daysjson = [];
        if (!empty($gm->days)) {
            $decoded = json_decode($gm->days, true);
            if (is_array($decoded)) $daysjson = $decoded;
        }
        $daymap = ['Mon'=>0,'Tue'=>1,'Wed'=>2,'Thu'=>3,'Fri'=>4,'Sat'=>5,'Sun'=>6];
        $allowed = [];
        foreach ($daysjson as $k => $v) {
            if (!empty($v) && isset($daymap[$k])) $allowed[$daymap[$k]] = true;
        }
        if (empty($allowed)) $allowed[(int)date('N', $seriesstart) - 1] = true;

        $startday = strtotime(date('Y-m-d', $seriesstart));
        $curday   = strtotime(date('Y-m-d', $fromts));
        $endday   = strtotime(date('Y-m-d', $endts));

        for ($d = $curday; $d <= $endday; $d += DAYSECS) {
            $w = (int)date('N', $d) - 1;
            if (empty($allowed[$w])) continue;

            $weekIndex = (int)floor(($d - $startday) / (7 * DAYSECS));
            if ($weekIndex < 0) continue;
            if (($weekIndex % $period) !== 0) continue;

            $existing = $DB->get_record('googlemeet_events',
                ['googlemeetid' => $gm->id, 'eventdate' => $d],
                '*', IGNORE_MISSING
            );
            if ($existing) {
                $existing->duration = $duration;
                $existing->timemodified = time();
                $DB->update_record('googlemeet_events', $existing);
            } else {
                $DB->insert_record('googlemeet_events', (object)[
                    'googlemeetid' => $gm->id,
                    'eventdate' => $d,
                    'duration' => $duration,
                    'timemodified' => time(),
                ]);
            }
            $count++;
        }

        return $count;
    };

    // -----------------------------
    // Begin transaction
    // -----------------------------
    $tx = $DB->start_delegated_transaction();

    // Load master series
    $gm = $DB->get_record('googlemeet', ['id' => $googlemeetid], '*', MUST_EXIST);

  
    // Only compute duration if time is EXPLICITLY applied
    $duration = null;
    if (
        !empty($apply['time']) &&
        $apply_time &&
        !empty($current['start']) &&
        !empty($current['end'])
    ) {
        $duration = $compute_duration_minutes($current['start'], $current['end']);
    }


    $result = [
        'ok' => true,
        'scope' => $scope,
        'googlemeetid' => $googlemeetid,
        'eventId' => $eventid,
        'anchorDate' => $anchorDate,
        'apply' => [
            'time' => $apply_time,
            'days' => $apply_days,
            'period' => $apply_period,
            'end' => $apply_end,
            'teacher' => $apply_teacher,
            'status' => $apply_status,
            'snapshotStudents' => $snapshot,
        ],
        'created' => [],
        'updated' => [],
        'deleted' => [],
        'counts' => [],
        'statusAppliedTo' => [],
        'teacherAppliedTo' => [],
        'snapshotAppliedTo' => [],
    ];

    // Helper: apply teacher/status/snapshot to a set of event IDs
    $apply_extras = function(array $eventids, int $gid) use (
    &$result, $scope, $apply_teacher, $apply_status,
    $teacherNew, $teacherReason, $statusNew, $statusReason,
    $assign_teacher, $set_event_status,
    $snapshot, $students, $snapshot_students,
    $data   // ✅ REQUIRED
) {

        foreach ($eventids as $eid) {
            $eid = (int)$eid;
            if ($eid <= 0) continue;

            if ($apply_teacher && !empty($data['teacher'])) {

                $assign_teacher(
                    $eid,            // ✅ CORRECT EVENT ID
                    $gid,            // ✅ USE THE PASSED GOOGLEMEETID
                    $data['teacher'],
                    $scope
                );

                $result['teacherAppliedTo'][] = $eid;
            }


            if ($apply_status && $statusNew !== '') {
                $set_event_status($eid, $gid, $statusNew, $scope, $statusReason ?: null);
                $result['statusAppliedTo'][] = $eid;
            }

            if ($snapshot && !empty($students)) {
                $snapshot_students($eid, $gid, $students, 'MANUAL');
                $result['snapshotAppliedTo'][] = $eid;
            }
        }
    };

    // -----------------------------
    // Scope handlers
    // -----------------------------
   if ($scope === 'THIS_OCCURRENCE') {

    $ev = $DB->get_record('googlemeet_events', ['id' => $eventid], '*', MUST_EXIST);
    $oldstart = (int)$ev->eventdate;
    $oldend   = $oldstart + ((int)$ev->duration * 60);

        // 🔑 Initialize defaults (prevents undefined vars)
    $newstart = $oldstart;
    $newend   = $oldend;


    // -------------------------
    // DATE CHANGE
    // -------------------------
    if ($apply_date && !empty($data['date']['new'])) {

        $hour   = (int)date('H', $oldstart);
        $minute = (int)date('i', $oldstart);

        $newstart = strtotime(
            $data['date']['new'] . ' ' . sprintf('%02d:%02d', $hour, $minute)
        );

        if ($newstart && date('Y-m-d', $oldstart) !== date('Y-m-d', $newstart)) {

            $DB->insert_record('local_gm_event_date_history', (object)[
                'eventid'      => $eventid,
                'googlemeetid' => $googlemeetid,
                'olddate'      => date('Y-m-d', $oldstart),
                'newdate'      => date('Y-m-d', $newstart),
                'scope'        => 'THIS_OCCURRENCE',
                'timecreated'  => time(),
                'createdby'    => $USER->id
            ]);

            $oldstart = $newstart; // 🔑 carry forward
        }
    }

    // -------------------------
    // TIME CHANGE (existing)
    // -------------------------
    if ($apply_time) {

        $newstart = $build_ts_from_date_time(
            date('Y-m-d', $oldstart),
            $current['start']
        );
        $newend = $build_ts_from_date_time(
            date('Y-m-d', $oldstart),
            $current['end']
        );

        if ($oldstart !== $newstart || $oldend !== $newend) {

            $DB->insert_record('local_gm_event_time_history', (object)[
                'eventid'      => $eventid,
                'googlemeetid' => $googlemeetid,
                'oldstart'     => $oldstart,
                'oldend'       => $oldend,
                'newstart'     => $newstart,
                'newend'       => $newend,
                'scope'        => $scope,
                'timecreated'  => time(),
                'createdby'    => $USER->id
            ]);
        }

        $ev->duration = (int)(($newend - $newstart) / 60);
    }

    // -------------------------
    // FINAL UPDATE
    // -------------------------
    if ($apply_date || $apply_time) {
        $ev->eventdate    = $newstart ?? $oldstart;
        $ev->timemodified = time();
        $DB->update_record('googlemeet_events', $ev);

        if (!$apply_status) {
            $set_event_status(
                $eventid,
                $googlemeetid,
                'rescheduled',
                $scope,
                'Date/Time updated'
            );
        }
    }

    // -------------------------
    // TEACHER / STATUS / SNAPSHOT
    // -------------------------
    $apply_extras([$eventid], $googlemeetid);
} else if ($scope === 'ALL_OCCURRENCES') {

        // If you are NOT changing schedule at all, do NOT touch googlemeet/googlemeet_events.
        if (!$apply_time && !$apply_days && !$apply_period && !$apply_end) {

            // apply extras to all future events in same googlemeet series
            $now = time();
            $eventids = $DB->get_fieldset_sql(
                "SELECT id FROM {googlemeet_events}
                  WHERE googlemeetid = :gid AND eventdate >= :fromts
                  ORDER BY eventdate ASC",
                ['gid' => $gm->id, 'fromts' => $now]
            );
            $apply_extras($eventids, $gm->id);

        } else {

            // schedule update required
            $period = (int)($current['period'] ?? 1);
            $period = max(1, $period);

            $startDate = trim((string)($current['startDate'] ?? ''));
            if ($startDate === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate)) {
                $startDate = date('Y-m-d', (int)$gm->eventdate);
            }

            if ($apply_time) {
                [$sh,$sm] = $parse_time($current['start']);
                [$eh,$em] = $parse_time($current['end']);
                $gm->starthour = $sh;
                $gm->startminute = $sm;
                $gm->endhour = $eh;
                $gm->endminute = $em;
            }

            if ($apply_days) {
                $gm->days = $days_to_googlemeet_days_field($current['days']);
                $gm->addmultiply = 1;
            }

            if ($apply_period) {
                $gm->period = $period;
                $gm->addmultiply = 1;
            }

            $gm->eventdate = $to_midnight_ts($startDate);

            if ($apply_end) {
                $gm->eventenddate = $get_end_ts($current, (int)$gm->eventdate);
            } else if ((int)$gm->eventenddate <= 0) {
                $gm->eventenddate = (int)$gm->eventdate + 180 * DAYSECS;
            }

            $gm->timemodified = time();
            $DB->update_record('googlemeet', $gm);
            $result['updated'][] = ['table' => 'googlemeet', 'id' => $gm->id];

            // Delete FUTURE occurrences and regenerate
            $now = time();
            $DB->delete_records_select('googlemeet_events',
                'googlemeetid = :gid AND eventdate >= :fromts',
                ['gid' => $gm->id, 'fromts' => $now]
            );
            $result['deleted'][] = ['table' => 'googlemeet_events', 'where' => 'future>=now'];

            $cnt = $generate_occurrences($gm, $now, (int)$gm->eventenddate);
            $result['counts']['generated'] = $cnt;

            $eventids = $DB->get_fieldset_sql(
                "SELECT id FROM {googlemeet_events}
                  WHERE googlemeetid = :gid AND eventdate >= :fromts
                  ORDER BY eventdate ASC",
                ['gid' => $gm->id, 'fromts' => $now]
            );

            $apply_extras($eventids, $gm->id);

            if (!$apply_status) {
                foreach ($eventids as $eid) {
                    $set_event_status((int)$eid, $gm->id, 'rescheduled', $scope, 'Series updated');
                    $result['statusAppliedTo'][] = (int)$eid;
                }
            }
        }

    }  else {
        throw new moodle_exception('invaliddata', 'error', '', 'Unsupported scope: ' . $scope);
    }





    $tx->allow_commit();

    echo json_encode($result);
    exit;

} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'error' => $e->getMessage(),
        'type' => get_class($e),
    ]);
    exit;
}
