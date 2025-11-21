<?php
// local/customplugin/ajax/calendar_admin_get_events.php
//
// Unified calendar API for admin weekly view.
//
// Filters:
//  - start (Y-m-d or timestamp) [required]
//  - end   (Y-m-d or timestamp) [required]
//  - teacherid  (int, optional) [deprecated - use teacherids]
//  - teacherids (comma-separated int list, optional) [new: for multiple teachers]
//  - cohortid   (int, optional)
//  - studentid  (int, optional)
//  - one2one_gmid (int, optional)   // filter 1:1 events for a specific googlemeet id
//
//
// Returns concrete occurrences from {googlemeet_events} for:
//  - 1:1 classes   (courseid = 24)
//  - Group classes (courseid = 2)
//
// Each returned event includes:
//  - eventid        : id from {googlemeet_events} (or planificationclass.id for peertalk)
//  - main_event_id  : stable parent id per series
//  - is_parent      : bool
//  - sequence       : order within that series
//  - googlemeetid, cmid, courseid
//  - teacherids[],  teachernames[]
//  - studentids[],  studentnames[]
//  - cohortids[]
//  - class_type     :
//        * courseid 24 → 'one2one_single' | 'one2one_weekly'
//        * courseid  2 → 'main' | 'tutoring'
//        * peertalk  → 'peertalk'
//  - is_recurring   : bool
//  - start, end, start_ts, end_ts
//  - viewurl, meetingurl

define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();

global $DB, $USER;

header('Content-Type: application/json');

$courseid_one2one = 24;
$courseid_group   = 2;

// ---- INPUTS ----
$startraw      = required_param('start', PARAM_RAW_TRIMMED);
$endraw        = required_param('end', PARAM_RAW_TRIMMED);
$teacherid     = optional_param('teacherid', 0, PARAM_INT);              // legacy
$teacheridsraw = optional_param('teacherids', '', PARAM_RAW_TRIMMED);    // new: multi
$cohortid      = optional_param('cohortid', 0, PARAM_INT);
$studentid     = optional_param('studentid', 0, PARAM_INT);
// specific googlemeet id filter for 1:1
$one2onegmid   = optional_param('one2one_gmid', 0, PARAM_INT);

// Parse multiple teacher IDs if provided (comma-separated)
$teacherids = [];
if ($teacheridsraw) {
    $ids = array_map('intval', explode(',', $teacheridsraw));
    $teacherids = array_filter($ids);
} elseif ($teacherid) {
    // Fallback to single teacherid for backward compatibility
    $teacherids = [$teacherid];
}

// Parse dates → timestamps
$startts = is_numeric($startraw)
    ? (int)$startraw
    : strtotime($startraw . ' 00:00:00');
$endts = is_numeric($endraw)
    ? (int)$endraw
    : strtotime($endraw . ' 23:59:59');

if (!$startts || !$endts || $endts <= $startts) {
    echo json_encode(['ok' => false, 'error' => 'Invalid date range']);
    exit;
}

// Permission check (tune as needed)
$syscontext = context_system::instance();
if (!is_siteadmin($USER) && !has_capability('moodle/site:config', $syscontext)) {
    require_capability('moodle/course:view', $syscontext);
}

// ---- Helpers ----

$json_to_array = function (?string $json) {
    if (empty($json)) {
        return null;
    }
    $arr = json_decode($json, true);
    return is_array($arr) ? $arr : null;
};

$availability_collect_emails = function (?string $json) use ($json_to_array): array {
    $tree = $json_to_array($json);
    if (!$tree) {
        return [];
    }
    $out = [];
    $walk = function($node) use (&$walk, &$out) {
        if (is_object($node)) {
            $node = (array)$node;
        }
        if (!is_array($node)) {
            return;
        }

        if (($node['type'] ?? '') === 'profile') {
            $field = strtolower((string)($node['sf'] ?? $node['field'] ?? ''));
            if ($field === 'email') {
                $val = trim((string)($node['v'] ?? $node['value'] ?? ''));
                if ($val !== '') {
                    $out[] = core_text::strtolower($val);
                }
            }
        }
        foreach (['c', 'showc', 'children', 'conditions'] as $k) {
            if (!empty($node[$k]) && is_array($node[$k])) {
                foreach ($node[$k] as $child) {
                    $walk($child);
                }
            }
        }
    };
    $walk($tree);
    return array_values(array_unique($out));
};

$availability_collect_cohorts = function (?string $json) use ($json_to_array): array {
    $tree = $json_to_array($json);
    if (!$tree) {
        return [];
    }
    $ids = [];
    $walk = function($node) use (&$walk, &$ids) {
        if (is_object($node)) {
            $node = (array)$node;
        }
        if (!is_array($node)) {
            return;
        }

        if (($node['type'] ?? '') === 'cohort' && !empty($node['id'])) {
            $ids[] = (int)$node['id'];
        }
        foreach (['c', 'showc', 'children', 'conditions'] as $k) {
            if (!empty($node[$k]) && is_array($node[$k])) {
                foreach ($node[$k] as $child) {
                    $walk($child);
                }
            }
        }
    };
    $walk($tree);
    return array_values(array_unique($ids));
};

$fmt_iso = static function(int $ts) {
    // Produces "YYYY-MM-DDTHH:MM:SS+00:00"
    return gmdate('c', $ts);
};

/**
 * Helper: use googlemeet starthour/startminute/endhour/endminute + eventdate
 *         to build start/end timestamps.
 *
 * - Date  → from $eventdate_ts (googlemeet_events.eventdate)
 * - Time  → from googlemeet.starthour/startminute/endhour/endminute
 * - Returns → [start_ts, end_ts] or null to fallback (use eventdate + duration).
 */
$derive_times_from_gm = function($gm, int $eventdate_ts) {
    if (!isset($gm->starthour) || !isset($gm->endhour)) {
        return null;
    }

    $sh = (int)$gm->starthour;
    $sm = isset($gm->startminute) ? (int)$gm->startminute : 0;
    $eh = (int)$gm->endhour;
    $em = isset($gm->endminute) ? (int)$gm->endminute : 0;

    // Basic sanity
    if ($sh < 0 || $sh > 23 || $eh < 0 || $eh > 23 ||
        $sm < 0 || $sm > 59 || $em < 0 || $em > 59) {
        return null;
    }

    // Take EXACT calendar date from the eventdate (no time)
    $day = gmdate('Y-m-d', $eventdate_ts); // ALWAYS from googlemeet_events.eventdate

    // Build timestamps like "2025-01-03 20:00:00" using googlemeet time (UTC)
    $start_ts = strtotime(sprintf('%s %02d:%02d:00 UTC', $day, $sh, $sm));
    $end_ts   = strtotime(sprintf('%s %02d:%02d:00 UTC', $day, $eh, $em));

    if (!$start_ts || !$end_ts) {
        return null;
    }

    // If end <= start, assume crosses midnight → add one day
    if ($end_ts <= $start_ts) {
        $end_ts += 86400;
    }

    return [$start_ts, $end_ts];
};

// ---- Relevant user/cohort lookups ----

// Support multiple teachers
$teachers      = [];
$teacherEmails = [];
if (!empty($teacherids)) {
    list($tsql, $tparams) = $DB->get_in_or_equal($teacherids, SQL_PARAMS_NAMED);
    $teachers = $DB->get_records_select('user', "id $tsql AND deleted = 0", $tparams, '', 'id,email');
    foreach ($teachers as $t) {
        if (!empty($t->email)) {
            $teacherEmails[core_text::strtolower(trim($t->email))] = (int)$t->id;
        }
    }
}

// Keep legacy single-teacher support (if exactly one found)
$teacher = (count($teachers) === 1) ? reset($teachers) : null;
$student = $studentid ? $DB->get_record('user', ['id' => $studentid, 'deleted' => 0], 'id,email', IGNORE_MISSING) : null;
$cohort  = $cohortid  ? $DB->get_record('cohort', ['id' => $cohortid], 'id', IGNORE_MISSING) : null;

$teacherEmailLower = $teacher && $teacher->email ? core_text::strtolower(trim($teacher->email)) : null;
$studentEmailLower = $student && $student->email ? core_text::strtolower(trim($student->email)) : null;

$email_to_userid = function(array $emails) use ($DB): array {
    $emails = array_values(array_unique(array_filter($emails)));
    if (!$emails) {
        return [];
    }
    list($insql, $inparams) = $DB->get_in_or_equal($emails, SQL_PARAMS_NAMED);
    $records = $DB->get_records_select('user', "LOWER(email) $insql AND deleted = 0 AND suspended = 0", $inparams, '', 'id,email');
    $map = [];
    foreach ($records as $u) {
        $map[core_text::strtolower(trim($u->email))] = (int)$u->id;
    }
    return $map;
};

// ---- EVENT COLLECTION ----

$events = [];

/**
 * 1:1 events (course 24)
 */
$add_one2one_events = function() use (
    $DB,
    $courseid_one2one,
    $startts,
    $endts,
    $teacherids,
    $teacherEmails,
    $studentid,
    $one2onegmid,
    $cohortid,
    $teacherEmailLower,
    $studentEmailLower,
    $availability_collect_emails,
    $fmt_iso,
    $derive_times_from_gm,
    $email_to_userid,
    &$events
) {
    $mod = $DB->get_record('modules', ['name' => 'googlemeet'], 'id', IGNORE_MISSING);
    if (!$mod) {
        return;
    }

    $sections = $DB->get_records('course_sections', ['course' => $courseid_one2one], 'id ASC', 'id,availability');

    // Map section → teachers (when teacher filter present)
    $sectionTeachers = [];
    if (!empty($teacherEmails)) {
        foreach ($sections as $sec) {
            $emails = $availability_collect_emails($sec->availability ?? null);
            if ($emails) {
                foreach ($emails as $em) {
                    $emailLower = core_text::strtolower(trim($em));
                    if (isset($teacherEmails[$emailLower])) {
                        $sectionTeachers[$sec->id][] = $teacherEmails[$emailLower];
                    }
                }
            }
        }
    }

    $cms = $DB->get_records('course_modules', [
        'course'             => $courseid_one2one,
        'module'             => $mod->id,
        'deletioninprogress' => 0
    ], 'id ASC', 'id,instance,section,availability');

    if (!$cms) {
        return;
    }

    // Collect all emails for mapping
    $allEmails = [];
    foreach ($cms as $cm) {
        $allEmails = array_merge($allEmails, $availability_collect_emails($cm->availability ?? null));
    }
    if ($teacherEmailLower) {
        $allEmails[] = $teacherEmailLower;
    }
    if ($studentEmailLower) {
        $allEmails[] = $studentEmailLower;
    }
    $emailUserMap = $email_to_userid($allEmails);

    // Preload googlemeet instances
    $instanceIds = array_map(fn($cm) => (int)$cm->instance, $cms);
    $gminstances = [];
    if ($instanceIds) {
        list($insql, $inparams) = $DB->get_in_or_equal($instanceIds, SQL_PARAMS_NAMED);
        $gminstances = $DB->get_records_select('googlemeet', "id $insql", $inparams);
    }

    // Preload teacher fullnames for all filtered teacher IDs (used in 1:1)
    $teacherUserMap = [];
    if (!empty($teacherids)) {
        list($insqlT, $paramsT) = $DB->get_in_or_equal($teacherids, SQL_PARAMS_NAMED);
        $teacherUserMap = $DB->get_records_select(
            'user',
            "id $insqlT AND deleted = 0 AND suspended = 0",
            $paramsT,
            '',
            'id, firstname, lastname, firstnamephonetic, lastnamephonetic, middlename, alternatename'
        );
    }

    foreach ($cms as $cmid => $cm) {
        $gm = $gminstances[$cm->instance] ?? null;
        if (!$gm) {
            continue;
        }

        // if one2one_gmid is set, only keep this googlemeet
        if ($one2onegmid && (int)$gm->id !== $one2onegmid) {
            continue;
        }

        // Derive students from activity availability
        $availEmails = $availability_collect_emails($cm->availability ?? null);
        $studentIds = [];
        foreach ($availEmails as $em) {
            if (isset($emailUserMap[$em])) {
                $studentIds[] = $emailUserMap[$em];
            }
        }
        $studentIds = array_values(array_unique($studentIds));

        if ($studentid && !in_array($studentid, $studentIds, true)) {
            continue;
        }

        // Load full student user records for names (for this CM)
        $studentUserMap = [];
        if (!empty($studentIds)) {
            list($insqlS, $paramsS) = $DB->get_in_or_equal($studentIds, SQL_PARAMS_NAMED);
            $studentUserMap = $DB->get_records_select(
                'user',
                "id $insqlS AND deleted = 0 AND suspended = 0",
                $paramsS,
                '',
                'id, firstname, lastname, firstnamephonetic, lastnamephonetic, middlename, alternatename'
            );
        }

        // Derive teacher(s) from section (for filtered cases)
        $teacherIdsForEvent = [];
        if (!empty($teacherids)) {
            if (!empty($sectionTeachers[$cm->section])) {
                foreach ($sectionTeachers[$cm->section] as $tid) {
                    if (in_array($tid, $teacherids, true)) {
                        $teacherIdsForEvent[] = $tid;
                    }
                }
            }
            // If no matching teachers for this section, skip it
            if (empty($teacherIdsForEvent)) {
                continue;
            }
        }

        // Cohort filter: by design 1:1 not tied directly to a cohort → skip if cohortid is set
        if ($cohortid) {
            continue;
        }

        // Load occurrences inside window
        $allevents = $DB->get_records_select(
            'googlemeet_events',
            'googlemeetid = :gid
             AND eventdate <= :end
             AND (eventdate + (duration * 60)) >= :start',
            [
                'gid'   => (int)$gm->id,
                'start' => $startts,
                'end'   => $endts
            ],
            'eventdate ASC, id ASC',
            'id, googlemeetid, eventdate, duration'
        );
        if (!$allevents) {
            continue;
        }

        // Recurrence metadata
        $ids = [];
        foreach ($allevents as $ev) {
            $ids[] = (int)$ev->id;
        }
        $mainEventId = $ids ? min($ids) : 0;
        $isrecurring = (count($allevents) > 1);

        // ONE-TO-ONE class_type:
        //   - one2one_single  (only 1 event)
        //   - one2one_weekly  (>1 events)
        $classType = $isrecurring ? 'one2one_weekly' : 'one2one_single';

        // URLs
        $meetingurl = '';
        foreach (['meetingurl', 'meeting_url', 'meeturl', 'joinurl', 'join_url', 'url', 'link'] as $f) {
            if (!empty($gm->$f)) {
                $meetingurl = (string)$gm->$f;
                break;
            }
        }
        $viewurl = (new moodle_url('/mod/googlemeet/view.php', ['id' => $cm->id]))->out(false);

        // Precompute teacher/student fullnames for this CM
        $teacherNames = [];
        foreach ($teacherIdsForEvent as $tid) {
            if (isset($teacherUserMap[$tid])) {
                $teacherNames[] = fullname($teacherUserMap[$tid], true);
            }
        }

        $studentNames = [];
        foreach ($studentIds as $sid) {
            if (isset($studentUserMap[$sid])) {
                $studentNames[] = fullname($studentUserMap[$sid], true);
            }
        }

        // Build event entries
        $seq = 1;
        foreach ($allevents as $e) {
            // --- STEP 1: get the raw event date from googlemeet_events ---
            $eventdate_ts = (int)$e->eventdate;

            // --- STEP 2: combine that date + googlemeet time ---
            $gmTimes = $derive_times_from_gm($gm, $eventdate_ts);
            if ($gmTimes) {
                [$eventStart, $eventEnd] = $gmTimes;
            } else {
                // Fallback: old behaviour (eventdate + duration)
                $eventStart = $eventdate_ts;
                $eventEnd   = $eventStart + max(60, (int)$e->duration * 60);
            }

            $events[] = [
                'id'            => '1to1-' . $e->id,
                'eventid'       => (int)$e->id,
                'main_event_id' => (int)$mainEventId,
                'is_parent'     => ((int)$e->id === $mainEventId),
                'sequence'      => $seq++,

                'source'        => 'one2one',
                'courseid'      => $courseid_one2one,
                'cmid'          => (int)$cm->id,
                'googlemeetid'  => (int)$gm->id,
                'title'         => (string)$gm->name,

                'start_ts'      => $eventStart,
                'end_ts'        => $eventEnd,
                'start'         => $fmt_iso($eventStart),
                'end'           => $fmt_iso($eventEnd),

                'teacherids'    => $teacherIdsForEvent,
                'teachernames'  => $teacherNames,
                'studentids'    => $studentIds,
                'studentnames'  => $studentNames,
                'cohortids'     => [],

                'class_type'    => $classType,   // 'one2one_single' | 'one2one_weekly'
                'is_recurring'  => $isrecurring,

                'meetingurl'    => $meetingurl,
                'viewurl'       => $viewurl,
            ];
        }
    }
};

/**
 * Group events (course 2)
 */
$add_group_events = function() use (
    $DB,
    $courseid_group,
    $startts,
    $endts,
    $teacherid,
    $cohortid,
    $studentid,
    $availability_collect_cohorts,
    $fmt_iso,
    $derive_times_from_gm,
    &$events
) {
    $mod = $DB->get_record('modules', ['name' => 'googlemeet'], 'id', IGNORE_MISSING);
    if (!$mod) {
        return;
    }

    // All cohorts map
    $cohortById = $DB->get_records('cohort', null, '', 'id, cohortmainteacher, cohortguideteacher');

    // Student cohorts (for filter)
    $studentCohorts = [];
    if ($studentid) {
        $rows = $DB->get_records('cohort_members', ['userid' => $studentid], '', 'id, cohortid');
        $studentCohorts = array_map(fn($r) => (int)$r->cohortid, $rows);
    }

    $sections = $DB->get_records('course_sections', ['course' => $courseid_group], 'id ASC', 'id, availability, section');

    $cms = $DB->get_records('course_modules', [
        'course'             => $courseid_group,
        'module'             => $mod->id,
        'deletioninprogress' => 0
    ], 'id ASC', 'id, instance, section');

    if (!$cms) {
        return;
    }

    // Preload googlemeet
    $instanceIds = array_map(fn($cm) => (int)$cm->instance, $cms);
    $gminstances = [];
    if ($instanceIds) {
        list($insql, $inparams) = $DB->get_in_or_equal($instanceIds, SQL_PARAMS_NAMED);
        $gminstances = $DB->get_records_select('googlemeet', "id $insql", $inparams);
    }

    foreach ($cms as $cmid => $cm) {
        $gm = $gminstances[$cm->instance] ?? null;
        if (!$gm) {
            continue;
        }

        $sec = $sections[$cm->section] ?? null;
        if (!$sec) {
            continue;
        }

        // Section cohorts
        $cohortIds = $availability_collect_cohorts($sec->availability ?? null);

        // Cohort filter
        if ($cohortid && $cohortIds && !in_array($cohortid, $cohortIds, true)) {
            continue;
        }

        // Teacher(s) from cohorts (for filtering only – may include both main & guide)
        $teacherIdsAll = [];
        foreach ($cohortIds as $cid) {
            if (!isset($cohortById[$cid])) {
                continue;
            }
            $c = $cohortById[$cid];
            if (!empty($c->cohortmainteacher)) {
                $teacherIdsAll[] = (int)$c->cohortmainteacher;
            }
            if (!empty($c->cohortguideteacher)) {
                $teacherIdsAll[] = (int)$c->cohortguideteacher;
            }
        }
        $teacherIdsAll = array_values(array_unique(array_filter($teacherIdsAll)));

        // Teacher filter (legacy single teacherid) based on all teachers tied to the cohorts
        if ($teacherid && $teacherIdsAll && !in_array($teacherid, $teacherIdsAll, true)) {
            continue;
        }
        if ($teacherid && !$cohortid && !$teacherIdsAll) {
            // For "only teacher" view: skip meets that don't relate to that teacher by cohort
            continue;
        }

        // Student filter: require membership in at least one cohort
        if ($studentid && $cohortIds) {
            if (!array_intersect($cohortIds, $studentCohorts)) {
                continue;
            }
        }

        // Load occurrences
        $allevents = $DB->get_records_select(
            'googlemeet_events',
            'googlemeetid = :gid
             AND eventdate <= :end
             AND (eventdate + (duration * 60)) >= :start',
            [
                'gid'   => (int)$gm->id,
                'start' => $startts,
                'end'   => $endts
            ],
            'eventdate ASC, id ASC',
            'id, googlemeetid, eventdate, duration'
        );
        if (!$allevents) {
            continue;
        }

        $ids = [];
        foreach ($allevents as $ev) {
            $ids[] = (int)$ev->id;
        }
        $mainEventId = $ids ? min($ids) : 0;
        $isrecurring = (count($allevents) > 1);

        // ---- CLASS TYPE (GROUP / COHORT) ----
        // Decide between 'main' and 'tutoring' based on googlemeet name/originalname.
        $rawname  = '';
        if (!empty($gm->originalname)) {
            $rawname = $gm->originalname;
        } else if (!empty($gm->name)) {
            $rawname = $gm->name;
        }

        $lname = core_text::strtolower($rawname);

        if (strpos($lname, 'main class') !== false || strpos($lname, 'main classes') !== false) {
            $classType = 'main';
        } else {
            // Anything else (Practice session, tutoring, etc.)
            $classType = 'tutoring';
        }

        // ---- PICK EXACT ONE TEACHER BASED ON CLASS TYPE ----
        $teacherIdDisplay = 0;
        if ($classType === 'main') {
            foreach ($cohortIds as $cid) {
                if (!empty($cohortById[$cid]) && !empty($cohortById[$cid]->cohortmainteacher)) {
                    $teacherIdDisplay = (int)$cohortById[$cid]->cohortmainteacher;
                    break;
                }
            }
        } else { // tutoring
            foreach ($cohortIds as $cid) {
                if (!empty($cohortById[$cid]) && !empty($cohortById[$cid]->cohortguideteacher)) {
                    $teacherIdDisplay = (int)$cohortById[$cid]->cohortguideteacher;
                    break;
                }
            }
        }

        $teacherIdsSingle = $teacherIdDisplay ? [$teacherIdDisplay] : [];

        // Preload that specific teacher for name
        $teacherNames = [];
        if ($teacherIdDisplay) {
            $tuser = $DB->get_record(
                'user',
                ['id' => $teacherIdDisplay, 'deleted' => 0, 'suspended' => 0],
                'id, firstname, lastname, firstnamephonetic, lastnamephonetic, middlename, alternatename',
                IGNORE_MISSING
            );
            if ($tuser) {
                $teacherNames[] = fullname($tuser, true);
            }
        }

        $meetingurl = '';
        foreach (['meetingurl', 'meeting_url', 'meeturl', 'joinurl', 'join_url', 'url', 'link'] as $f) {
            if (!empty($gm->$f)) {
                $meetingurl = (string)$gm->$f;
                break;
            }
        }
        $viewurl = (new moodle_url('/mod/googlemeet/view.php', ['id' => $cmid]))->out(false);

        $seq = 1;
        foreach ($allevents as $e) {
            // --- STEP 1: get the raw event date from googlemeet_events ---
            $eventdate_ts = (int)$e->eventdate;

            // --- STEP 2: combine that date + googlemeet time ---
            $gmTimes = $derive_times_from_gm($gm, $eventdate_ts);
            if ($gmTimes) {
                [$eventStart, $eventEnd] = $gmTimes;
            } else {
                // Fallback: old behaviour (eventdate + duration)
                $eventStart = $eventdate_ts;
                $eventEnd   = $eventStart + max(60, (int)$e->duration * 60);
            }

            $events[] = [
                'id'            => 'group-' . $e->id,
                'eventid'       => (int)$e->id,
                'main_event_id' => (int)$mainEventId,
                'is_parent'     => ((int)$e->id === $mainEventId),
                'sequence'      => $seq++,

                'source'        => 'group',
                'courseid'      => $courseid_group,
                'cmid'          => (int)$cmid,
                'googlemeetid'  => (int)$gm->id,
                'title'         => (string)$gm->name,

                'start_ts'      => $eventStart,
                'end_ts'        => $eventEnd,
                'start'         => $fmt_iso($eventStart),
                'end'           => $fmt_iso($eventEnd),

                // NOW: exactly one teacher (based on main/tutoring)
                'teacherids'    => $teacherIdsSingle,
                'teachernames'  => $teacherNames,
                'studentids'    => [],            // implicit via cohort
                'studentnames'  => [],            // no explicit list
                'cohortids'     => $cohortIds,

                'class_type'    => $classType,   // 'main' | 'tutoring'
                'is_recurring'  => $isrecurring,

                'meetingurl'    => $meetingurl,
                'viewurl'       => $viewurl,
            ];
        }
    }
};

// ---- COLLECT ----

try {
    // If a specific 1:1 googlemeet is selected, ONLY load that 1:1 meet's events.
    if ($one2onegmid) {
        $add_one2one_events();
    } else {
        // Normal behaviour: load both group + 1:1 events.
        $add_group_events();
        $add_one2one_events();
    }

    // Final strict filter pass (intersection safety net)
    $filtered = [];
    foreach ($events as $ev) {
        // Filter by teachers (support multiple teacherids)
        if (!empty($teacherids)) {
            $hasTeacher = false;
            foreach ($teacherids as $tid) {
                if (in_array($tid, $ev['teacherids'], true)) {
                    $hasTeacher = true;
                    break;
                }
            }
            if (!$hasTeacher) {
                continue;
            }
        }

        if ($cohortid && !in_array($cohortid, $ev['cohortids'], true)) {
            continue;
        }

        if ($studentid) {
            $ok = false;

            if (in_array($studentid, $ev['studentids'], true)) {
                $ok = true;
            } elseif (!empty($ev['cohortids'])) {
                list($insql, $params) = $DB->get_in_or_equal($ev['cohortids'], SQL_PARAMS_NAMED);
                $params['uid'] = $studentid;
                $ok = $DB->record_exists_sql(
                    "SELECT 1 FROM {cohort_members}
                      WHERE userid = :uid AND cohortid $insql",
                    $params
                );
            }

            if (!$ok) {
                continue;
            }
        }

        $filtered[] = $ev;
    }

    // ------- attach statuses from {local_gm_event_status} -------
    $eventids = [];
    foreach ($filtered as $ev) {
        if (!empty($ev['eventid'])) {
            $eventids[] = (int)$ev['eventid'];
        }
    }
    $eventids = array_values(array_unique($eventids));

    $statusesByEvent = [];
    if (!empty($eventids)) {
        list($insql, $params) = $DB->get_in_or_equal($eventids, SQL_PARAMS_NAMED);
        $statusrecs = $DB->get_records_select(
            'local_gm_event_status',
            "eventid $insql",
            $params,
            'timecreated ASC'
        );

        foreach ($statusrecs as $s) {
            $eid = (int)$s->eventid;
            if (!isset($statusesByEvent[$eid])) {
                $statusesByEvent[$eid] = [];
            }
            $statusesByEvent[$eid][] = [
                'code'     => $s->statuscode,
                'isactive' => (bool)$s->isactive,
                'details'  => $s->detailsjson ? json_decode($s->detailsjson, true) : null,
                'time'     => (int)$s->timecreated,
            ];
        }
    }

    foreach ($filtered as &$ev) {
        $eid = !empty($ev['eventid']) ? (int)$ev['eventid'] : 0;
        $ev['statuses'] = $eid && isset($statusesByEvent[$eid])
            ? $statusesByEvent[$eid]
            : [];
    }
    unset($ev);
    // ------- END STATUS BLOCK -------

    usort($filtered, fn($a, $b) => $a['start_ts'] <=> $b['start_ts']);

    // ----------------------------------------------------------
    // Peer Talk / Videocalling classes as EVENT OBJECTS
    // ----------------------------------------------------------
    $peertalkEvents = [];

    try {
        $rangeStart = $startts;
        $rangeEnd   = $endts;

        // Which teacher(s) to consider for Peer Talk:
        //  - if teacher filter present → those IDs
        //  - else → current user (for own dashboard)
        $peertalkTeacherIds = !empty($teacherids) ? $teacherids : [$USER->id];

        // Teacher record for display (first teacher in list or current user)
        $displayTeacherId = $peertalkTeacherIds[0];
        $displayTeacher = $DB->get_record(
            'user',
            ['id' => $displayTeacherId, 'deleted' => 0, 'suspended' => 0],
            'id, firstname, lastname, firstnamephonetic, lastnamephonetic, middlename, alternatename',
            IGNORE_MISSING
        );
        $displayTeacherName = $displayTeacher ? fullname($displayTeacher, true) : '';

        // 1) Build cohortids based on teacher / student / cohort filters.
        $cohortids = [];

        // a) From teacher filter (cohortmainteacher / cohortguideteacher).
        if (!empty($teacherids)) {
            list($tin, $tparams) = $DB->get_in_or_equal($peertalkTeacherIds, SQL_PARAMS_NAMED);

            // cohorts where one of these teachers is main
            $mainCohorts = $DB->get_records_select(
                'cohort',
                "visible = 1 AND cohortmainteacher $tin",
                $tparams,
                '',
                'id'
            );
            // cohorts where one of these teachers is guide
            $guideCohorts = $DB->get_records_select(
                'cohort',
                "visible = 1 AND cohortguideteacher $tin",
                $tparams,
                '',
                'id'
            );

            foreach ($mainCohorts as $c) {
                $cohortids[] = (int)$c->id;
            }
            foreach ($guideCohorts as $c) {
                $cohortids[] = (int)$c->id;
            }
        } elseif (!$teacherids && !$studentid && !$cohortid) {
            // No explicit filter → fallback: cohorts where current user is main/guide teacher.
            $cohorts = $DB->get_records_sql(
                "SELECT id
                   FROM {cohort}
                  WHERE visible = 1
                    AND (cohortmainteacher = :uid OR cohortguideteacher = :uid)",
                ['uid' => $USER->id]
            );
            foreach ($cohorts as $c) {
                $cohortids[] = (int)$c->id;
            }
        }

        $cohortids = array_values(array_unique($cohortids));

        // b) Apply explicit cohort filter, if provided.
        if ($cohortid) {
            if (!empty($cohortids)) {
                $cohortids = array_values(array_intersect($cohortids, [$cohortid]));
            } else {
                $cohortids = [$cohortid];
            }
        }

        // c) Apply student filter: cohorts where this student is a member.
        if ($studentid) {
            if (!empty($cohortids)) {
                list($insql, $params) = $DB->get_in_or_equal($cohortids, SQL_PARAMS_NAMED);
                $params['uid'] = $studentid;
                $rows = $DB->get_records_sql(
                    "SELECT DISTINCT cohortid
                       FROM {cohort_members}
                      WHERE userid = :uid
                        AND cohortid $insql",
                    $params
                );
            } else {
                $rows = $DB->get_records(
                    'cohort_members',
                    ['userid' => $studentid],
                    '',
                    'cohortid'
                );
            }

            $cohortids = [];
            foreach ($rows as $r) {
                $cohortids[] = (int)$r->cohortid;
            }
            $cohortids = array_values(array_unique($cohortids));
        }

        // 2) From those cohortids, collect idplanificaction via assignamentcohortforclass.
        $idplanificactions = [];

        if (!empty($cohortids)) {
            list($in, $params) = $DB->get_in_or_equal($cohortids, SQL_PARAMS_NAMED);

            $sql = "SELECT DISTINCT idplanificaction
                      FROM {assignamentcohortforclass}
                     WHERE idcohort $in
                       AND idplanificaction IS NOT NULL";

            $idplanificactions = $DB->get_fieldset_sql($sql, $params);
        }

        // 3) Also add any planifications where filtered teacher(s) are directly assigned.
        if (!empty($peertalkTeacherIds)) {
            list($tin2, $tparams2) = $DB->get_in_or_equal($peertalkTeacherIds, SQL_PARAMS_NAMED);

            $sqlT = "SELECT DISTINCT idplanificaction
                       FROM {assignamentteachearforclass}
                      WHERE iduserteacher $tin2";

            $teacherPlanifs = $DB->get_fieldset_sql($sqlT, $tparams2);

            foreach ($teacherPlanifs as $pid) {
                if (!in_array($pid, $idplanificactions)) {
                    $idplanificactions[] = $pid;
                }
            }
        }

        // 4) Get full records from planificationclass for those ids.
        $planificationrecords = [];
        if (!empty($idplanificactions)) {
            list($in2, $params2) = $DB->get_in_or_equal($idplanificactions, SQL_PARAMS_NAMED);

            $sql2 = "SELECT *
                       FROM {planificationclass}
                      WHERE id $in2";

            $planificationrecords = $DB->get_records_sql($sql2, $params2);
        }

        // 5) Build Peer Talk events only inside [$rangeStart, $rangeEnd].
        foreach ($planificationrecords as $record) {
            $recurrence = $DB->get_record('optionsrepeat', ['idplanificaction' => $record->id]);

            $seriesId = (int)$record->id; // correct event id from DB
            $seq      = 1;

            // time-of-day parts
            $startTimeStr  = date('H:i', $record->startdate);
            $finishTimeStr = date('H:i', $record->finishdate);

            if ($recurrence) {

                // ---------- WEEKLY ----------
                if ($recurrence->type == 'week') {
                    $repeatevery = (int)($recurrence->repeatevery ?? 1);
                    if ($repeatevery < 1) {
                        $repeatevery = 1;
                    }

                    $repeatUntil = $recurrence->repeaton ? (int)$recurrence->repeaton : PHP_INT_MAX;
                    $repeatUntil = min($repeatUntil, $rangeEnd);

                    $weekdayMap = [
                        'sunday' => 0, 'monday' => 1, 'tuesday' => 2,
                        'wednesday' => 3, 'thursday' => 4,
                        'friday' => 5, 'saturday' => 6
                    ];

                    $recurrenceDays = [];
                    foreach ($weekdayMap as $day => $num) {
                        if (!empty($recurrence->$day)) {
                            $recurrenceDays[$num] = $day;
                        }
                    }
                    if (empty($recurrenceDays)) {
                        continue;
                    }

                    // Anchor: Sunday midnight of week containing first startdate
                    $anchorDayTs  = strtotime(date('Y-m-d 00:00:00', $record->startdate));
                    $anchorDow    = (int)date('w', $record->startdate);
                    $anchorWeekTs = $anchorDayTs - ($anchorDow * 86400);

                    $weekSpan = 7 * 86400 * $repeatevery;

                    for ($weekStart = $anchorWeekTs; $weekStart <= $repeatUntil; $weekStart += $weekSpan) {
                        foreach ($recurrenceDays as $weekday => $dayname) {
                            $dayTs = $weekStart + ($weekday * 86400);

                            if ($dayTs < $rangeStart || $dayTs > $repeatUntil) {
                                continue;
                            }

                            // Do not create sessions before original schedule start
                            if ($dayTs < $record->startdate) {
                                continue;
                            }

                            $sessionStart = strtotime(date('Y-m-d', $dayTs) . ' ' . $startTimeStr);
                            $sessionEnd   = strtotime(date('Y-m-d', $dayTs) . ' ' . $finishTimeStr);

                            if ($sessionEnd < $rangeStart || $sessionStart > $rangeEnd) {
                                continue;
                            }

                            $eventid = $seriesId;

                            $peertalkEvents[] = [
                                'id'            => 'peertalk-' . $eventid,
                                'eventid'       => $eventid,
                                'main_event_id' => $seriesId,
                                'is_parent'     => ($seq === 1),
                                'sequence'      => $seq++,

                                'source'        => 'peertalk',
                                'courseid'      => 0,
                                'cmid'          => 0,
                                'googlemeetid'  => 0,
                                'title'         => 'Quick Talk',

                                'start_ts'      => $sessionStart,
                                'end_ts'        => $sessionEnd,
                                'start'         => $fmt_iso($sessionStart),
                                'end'           => $fmt_iso($sessionEnd),

                                'teacherids'    => [$displayTeacherId],
                                'teachernames'  => [$displayTeacherName],
                                'studentids'    => [],
                                'studentnames'  => [],
                                'cohortids'     => $cohortids,

                                'class_type'    => 'peertalk',
                                'is_recurring'  => true,

                                'meetingurl'    => 'https://courses.latingles.com/local/videocalling',
                                'viewurl'       => 'https://courses.latingles.com/local/videocalling',
                            ];
                        }
                    }
                }

                // ---------- DAILY ----------
                if ($recurrence->type == 'day') {
                    $repeatevery = (int)($recurrence->repeatevery ?? 1);
                    if ($repeatevery < 1) {
                        $repeatevery = 1;
                    }

                    $repeatUntil = $recurrence->repeaton ? (int)$recurrence->repeaton : PHP_INT_MAX;
                    $repeatUntil = min($repeatUntil, $rangeEnd);

                    $anchorDay = strtotime(date('Y-m-d 00:00:00', $record->startdate));

                    $loopStart = max($anchorDay, strtotime(date('Y-m-d 00:00:00', $rangeStart)));

                    $diffDays = (int)floor(($loopStart - $anchorDay) / 86400);
                    $mod      = $diffDays % $repeatevery;
                    if ($mod !== 0) {
                        $loopStart += ($repeatevery - $mod) * 86400;
                    }

                    for ($dayTs = $loopStart; $dayTs <= $repeatUntil; $dayTs += $repeatevery * 86400) {
                        $sessionStart = strtotime(date('Y-m-d', $dayTs) . ' ' . $startTimeStr);
                        $sessionEnd   = strtotime(date('Y-m-d', $dayTs) . ' ' . $finishTimeStr);

                        if ($sessionEnd < $rangeStart || $sessionStart > $rangeEnd) {
                            continue;
                        }

                        $eventid = $seriesId;

                        $peertalkEvents[] = [
                            'id'            => 'peertalk-' . $eventid,
                            'eventid'       => $eventid,
                            'main_event_id' => $seriesId,
                            'is_parent'     => ($seq === 1),
                            'sequence'      => $seq++,

                            'source'        => 'peertalk',
                            'courseid'      => 0,
                            'cmid'          => 0,
                            'googlemeetid'  => 0,
                            'title'         => 'Quick Talk',

                            'start_ts'      => $sessionStart,
                            'end_ts'        => $sessionEnd,
                            'start'         => $fmt_iso($sessionStart),
                            'end'           => $fmt_iso($sessionEnd),

                            'teacherids'    => [$displayTeacherId],
                            'teachernames'  => [$displayTeacherName],
                            'studentids'    => [],
                            'studentnames'  => [],
                            'cohortids'     => $cohortids,

                            'class_type'    => 'peertalk',
                            'is_recurring'  => true,

                            'meetingurl'    => 'https://courses.latingles.com/local/videocalling',
                            'viewurl'       => 'https://courses.latingles.com/local/videocalling',
                        ];
                    }
                }

            } else {
                // ---------- ONE-TIME ----------
                $sessionStart = (int)$record->startdate;
                $sessionEnd   = (int)$record->finishdate;

                if ($sessionEnd < $rangeStart || $sessionStart > $rangeEnd) {
                    continue;
                }

                $eventid = $seriesId;

                $peertalkEvents[] = [
                    'id'            => 'peertalk-' . $eventid,
                    'eventid'       => $eventid,
                    'main_event_id' => $seriesId,
                    'is_parent'     => true,
                    'sequence'      => $seq++,

                    'source'        => 'peertalk',
                    'courseid'      => 0,
                    'cmid'          => 0,
                    'googlemeetid'  => 0,
                    'title'         => 'Quick Talk',

                    'start_ts'      => $sessionStart,
                    'end_ts'        => $sessionEnd,
                    'start'         => $fmt_iso($sessionStart),
                    'end'           => $fmt_iso($sessionEnd),

                    'teacherids'    => [$displayTeacherId],
                    'teachernames'  => [$displayTeacherName],
                    'studentids'    => [],
                    'studentnames'  => [],
                    'cohortids'     => $cohortids,

                    'class_type'    => 'peertalk',
                    'is_recurring'  => false,

                    'meetingurl'    => 'https://courses.latingles.com/local/videocalling',
                    'viewurl'       => 'https://courses.latingles.com/local/videocalling',
                ];
            }
        }

        usort($peertalkEvents, function ($a, $b) {
            return $a['start_ts'] <=> $b['start_ts'];
        });

        $peertalkEvents = array_slice($peertalkEvents, 0, 40);

    } catch (\Throwable $ignored) {
        $peertalkEvents = [];
    }

     // --- PATCH: shift Peer Talk events back by 1 day per series ---
    if (!empty($peertalkEvents)) {
        // Count how many entries per eventid (series).
        $peertalkCounts = [];
        foreach ($peertalkEvents as $ev) {
            if (!empty($ev['eventid'])) {
                $eid = (int)$ev['eventid'];
                if (!isset($peertalkCounts[$eid])) {
                    $peertalkCounts[$eid] = 0;
                }
                $peertalkCounts[$eid]++;
            }
        }

        // For any series where eventid is repeated (same eventid for multiple rows),
        // shift all its Peer Talk occurrences back by 1 day (86400 seconds).
        foreach ($peertalkEvents as &$ev) {
            if (!empty($ev['eventid'])) {
                $eid = (int)$ev['eventid'];
                if (!empty($peertalkCounts[$eid]) && $peertalkCounts[$eid] > 1) {
                    $ev['start_ts'] -= 86400;
                    $ev['end_ts']   -= 86400;

                    // Rebuild ISO strings after shifting.
                    $ev['start'] = $fmt_iso($ev['start_ts']);
                    $ev['end']   = $fmt_iso($ev['end_ts']);
                }
            }
        }
        unset($ev);
    }

     // --- Ensure Peer Talk ISO start/end are always derived from start_ts/end_ts ---
    // if (!empty($peertalkEvents)) {
    //     foreach ($peertalkEvents as &$pev) {
    //         if (isset($pev['start_ts'])) {
    //             $pev['start'] = $fmt_iso($pev['start_ts']);
    //         }
    //         if (isset($pev['end_ts'])) {
    //             $pev['end'] = $fmt_iso($pev['end_ts']);
    //         }
    //     }
    //     unset($pev);
    // }
    // ----------------------------------------------------------
    // END Peer Talk section
    // ----------------------------------------------------------

    echo json_encode([
        'ok'      => true,
        'filters' => [
            'start'        => $startts,
            'end'          => $endts,
            'teacherid'    => $teacherid,
            'teacherids'   => $teacherids,
            'cohortid'     => $cohortid,
            'studentid'    => $studentid,
            'one2one_gmid' => $one2onegmid,
        ],
        'events'   => array_values($filtered),
        'peertalk' => array_values($peertalkEvents),
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
