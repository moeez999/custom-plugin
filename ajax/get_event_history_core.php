<?php
defined('MOODLE_INTERNAL') || die();

function get_single_event_history(
    int $eventid,
    ?int $fallbackTeacherId = null
): array {

    global $DB, $PAGE;

    // --------------------------------------------------
    // Load base event
    // --------------------------------------------------
    $event = $DB->get_record('googlemeet_events', ['id' => $eventid], '*', MUST_EXIST);
    $googlemeet = $DB->get_record('googlemeet', ['id' => $event->googlemeetid], '*', MUST_EXIST);

    // --------------------------------------------------
    // Determine class type
    // --------------------------------------------------
    $eventcount = $DB->count_records('googlemeet_events', ['googlemeetid' => $googlemeet->id]);
    $classType  = ($eventcount <= 1) ? 'single' : 'weekly';

    // --------------------------------------------------
    // Resolve CM + student
    // --------------------------------------------------
    $cm = $DB->get_record(
        'course_modules',
        ['instance' => $googlemeet->id, 'course' => $googlemeet->course],
        '*',
        IGNORE_MISSING
    );

    $student = null;
    if ($cm && !empty($cm->availability)) {
        $avail = json_decode($cm->availability, true);
        if (!empty($avail['c'])) {
            foreach ($avail['c'] as $cond) {
                if (
                    ($cond['type'] ?? '') === 'profile' &&
                    ($cond['sf'] ?? '') === 'email' &&
                    !empty($cond['v'])
                ) {
                    $stu = $DB->get_record('user', ['email' => trim($cond['v'])], '*', IGNORE_MISSING);
                    if ($stu) {
                        $PAGE->set_context(context_system::instance());
                        $pic = new user_picture($stu);
                        $pic->size = 50;
                        $student = [
                            'id'     => $stu->id,
                            'name'   => fullname($stu),
                            'avatar' => $pic->get_url($PAGE)->out(false)
                        ];
                    }
                    break;
                }
            }
        }
    }

    // --------------------------------------------------
    // Current status / teacher
    // --------------------------------------------------
    $currentstatus  = $DB->get_record('local_gm_event_status', ['eventid' => $eventid], '*', IGNORE_MISSING);
    $currentteacher = $DB->get_record('local_gm_teacher_assignment', ['eventid' => $eventid], '*', IGNORE_MISSING);

    $resolvedTeacherId = $currentteacher->teacherid ?? $fallbackTeacherId;

    $PAGE->set_context(context_system::instance());

    $build_teacher_info = function(?int $teacherid) use ($DB, $PAGE) {
        if (!$teacherid) return null;
        $u = $DB->get_record('user', ['id' => $teacherid], '*', MUST_EXIST);
        $pic = new user_picture($u);
        $pic->size = 50;
        return [
            'id'     => $u->id,
            'name'   => fullname($u),
            'avatar' => $pic->get_url($PAGE)->out(false)
        ];
    };

    // --------------------------------------------------
    // Load histories
    // --------------------------------------------------
    $statushistory  = $DB->get_records('local_gm_event_status_history', ['eventid' => $eventid], 'timecreated ASC');
    $teacherhistory = $DB->get_records('local_gm_teacher_history', ['eventid' => $eventid], 'timecreated ASC');
    $timehistory    = $DB->get_records('local_gm_event_time_history', ['eventid' => $eventid], 'timecreated ASC');
    $datehistory    = $DB->get_records('local_gm_event_date_history', ['eventid' => $eventid], 'timecreated ASC');

    // --------------------------------------------------
    // Resolve CURRENT STATUS from history (AUTHORITATIVE)
    // --------------------------------------------------
    $currentStatusValue = 'scheduled';

    if (!empty($statushistory)) {
        $lastStatus = end($statushistory);
        $currentStatusValue = $lastStatus->newstatus ?? 'scheduled';
    }


    $gmTimeHistory = $DB->get_records(
        'local_gm_googlemeet_time_history',
        ['googlemeetid' => $googlemeet->id],
        'timecreated ASC'
    );

    // --------------------------------------------------
    // Normalize histories
    // --------------------------------------------------
    $teacherBySecond = [];
    foreach ($teacherhistory as $th) {
        $teacherBySecond[(int)$th->timecreated] = [
            'from' => $th->oldteacherid,
            'to'   => $th->newteacherid,
            'scope'=> $th->scope
        ];
    }

    $timeBySecond = [];
    foreach ($timehistory as $t) {
        $timeBySecond[(int)$t->timecreated] = [
            'from' => date('H:i', $t->oldstart) . ' - ' . date('H:i', $t->oldend),
            'to'   => date('H:i', $t->newstart) . ' - ' . date('H:i', $t->newend),
            'scope'=> $t->scope
        ];
    }

    $dateBySecond = [];
    foreach ($datehistory as $d) {
        $dateBySecond[(int)$d->timecreated] = [
            'from' => $d->olddate,
            'to'   => $d->newdate,
            'scope'=> $d->scope
        ];
    }

    $gmTimeBySecond = [];
    // foreach ($gmTimeHistory as $gth) {
    //     $gmTimeBySecond[(int)$gth->timecreated] = [
    //         'from' => date('H:i', $gth->oldstart) . ' - ' . date('H:i', $gth->oldend),
    //         'to'   => date('H:i', $gth->newstart) . ' - ' . date('H:i', $gth->newend),
    //         'scope'=> 'THIS_AND_FOLLOWING'
    //     ];
    // }


    $normalize = function($t) {
    if ($t === null || $t === '') {
        return '';
    }
    [$h, $m] = array_map('intval', explode(':', (string)$t));
    return sprintf('%02d:%02d', $h, $m);
};

foreach ($gmTimeHistory as $gth) {

    $gmTimeBySecond[(int)$gth->timecreated] = [
        'from'  => $normalize($gth->oldstart) . ' - ' . $normalize($gth->oldend),
        'to'    => $normalize($gth->newstart) . ' - ' . $normalize($gth->newend),
        'scope' => $gth->scope
    ];
}


    

    // --------------------------------------------------
    // Build timeline
    // --------------------------------------------------
    $timelineSeconds = array_unique(array_merge(
        array_keys($teacherBySecond),
        array_keys($timeBySecond),
        array_keys($dateBySecond),
        array_keys($gmTimeBySecond), // ✅ ADD THIS
        array_map(fn($s) => (int)$s->timecreated, $statushistory)
    ));
    sort($timelineSeconds);

    $timeline = [];

    foreach ($timelineSeconds as $ts) {

        $s = null;
        foreach ($statushistory as $sh) {
            if ((int)$sh->timecreated === $ts) {
                $s = $sh;
                break;
            }
        }

        if (
            !$s &&
            empty($teacherBySecond[$ts]) &&
            empty($timeBySecond[$ts]) &&
            empty($dateBySecond[$ts]) &&
            empty($gmTimeBySecond[$ts])   
        ) {
            continue;
        }

        $entry = [
            'type'        => $s ? $s->newstatus : 'updated',
            'scope'       => $s->scope ?? 'THIS_OCCURRENCE',
            'changedAt'   => date('Y-m-d H:i', $ts),
            'changedAtTs'=> $ts,
            'changedBy'   => $s->createdby ?? null,
            'status'      => $s ? ['from' => $s->oldstatus, 'to' => $s->newstatus] : null
        ];

        if (!empty($teacherBySecond[$ts])) $entry['teacher'] = $teacherBySecond[$ts];
        if (!empty($timeBySecond[$ts]))    $entry['time']    = $timeBySecond[$ts];
        if (!empty($dateBySecond[$ts]))    $entry['date']    = $dateBySecond[$ts];

        // if (
        //     $s &&
        //     $s->newstatus === 'rescheduled' &&
        //     empty($entry['time']) &&
        //     !empty($gmTimeBySecond[$ts])
        // ) {
        //     $entry['time'] = $gmTimeBySecond[$ts];
        // }

        if (
    empty($entry['time']) &&
    !empty($gmTimeBySecond[$ts])
) {
    $entry['time'] = $gmTimeBySecond[$ts];
}


        $timeline[] = $entry;
    }

    // --------------------------------------------------
    // CURRENT TIME RESOLUTION (FIXED LOGIC)
    // --------------------------------------------------
    $eventdateymd = date('Y-m-d', (int)$event->eventdate);

    $gmStart = sprintf('%02d:%02d', $googlemeet->starthour, $googlemeet->startminute);
    $gmEnd   = sprintf('%02d:%02d', $googlemeet->endhour,   $googlemeet->endminute);

    $latestEventTime = null;
    if (!empty($timehistory)) {
        $last = end($timehistory);
        $latestEventTime = [
            'start' => date('H:i', $last->newstart),
            'end'   => date('H:i', $last->newend)
        ];
    }


    $normalize = function(string $t): string {
    [$h, $m] = array_map('intval', explode(':', $t));
    return sprintf('%02d:%02d', $h, $m);
};

$latestGmTime = null;
if (!empty($gmTimeHistory)) {
    $last = end($gmTimeHistory);
    $latestGmTime = [
        'start' => $normalize($last->newstart),
        'end'   => $normalize($last->newend)
    ];
}


    if ($latestEventTime) {
        $currentStart = $latestEventTime['start'];
        $currentEnd   = $latestEventTime['end'];
    } elseif ($latestGmTime) {
        $currentStart = $latestGmTime['start'];
        $currentEnd   = $latestGmTime['end'];
    } else {
        $currentStart = $gmStart;
        $currentEnd   = $gmEnd;
    }

    $currentStartTs = strtotime("$eventdateymd $currentStart");
    $currentEndTs   = strtotime("$eventdateymd $currentEnd");
    if ($currentEndTs <= $currentStartTs) {
        $currentEndTs += DAYSECS;
    }

    $durationMinutes = (int)(($currentEndTs - $currentStartTs) / 60);

    $current = [
        'status'     => $currentStatusValue,
        'start_time' => $currentStart,
        'end_time'   => $currentEnd,
        'teacher'    => $build_teacher_info($resolvedTeacherId)
    ];

    // --------------------------------------------------
    // PREVIOUS STATE
    // --------------------------------------------------
    $previous = null;

    for ($i = count($timeline) - 1; $i >= 0; $i--) {
        $t = $timeline[$i];
        //if (!empty($t['time']['from']) || !empty($t['teacher']['from']) || !empty($t['status']['from'])) {
            if (
    !empty($t['time']['from']) ||
    !empty($t['teacher']['from']) ||
    !empty($t['status']['from'])
) {


            $prevStart = null;
            $prevEnd   = null;

            if (!empty($t['time']['from'])) {
                [$prevStart, $prevEnd] = array_map('trim', explode(' - ', $t['time']['from']));
            }

            $previous = [
                'status'     => $t['status']['from'] ?? $current['status'],
                'start_time' => $prevStart ?? $currentStart,
                'end_time'   => $prevEnd   ?? $currentEnd,
                'teacher'    => $build_teacher_info(
                    !empty($t['teacher']['from']) ? (int)$t['teacher']['from'] : $resolvedTeacherId
                )
            ];
            break;
        }
    }

    return [
        'ok' => true,
        'event' => [
            'eventid'          => $eventid,
            'googlemeetid'     => $event->googlemeetid,
            'eventdate'        => $eventdateymd,
            'start_time'       => $currentStart,
            'end_time'         => $currentEnd,
            'duration_minutes' => $durationMinutes,
            'student'          => $student,
            'classType'        => $classType
        ],
        'summary' => [
            'current'  => $current,
            'previous' => $previous
        ],
        'history' => [
            'timeline' => $timeline
        ]
    ];
}
