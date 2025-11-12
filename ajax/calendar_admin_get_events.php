<?php
// local/customplugin/ajax/calendar_admin_get_events.php
//
// Unified calendar API for admin weekly view.
//
// Filters:
//  - start (Y-m-d or timestamp) [required]
//  - end   (Y-m-d or timestamp) [required]
//  - teacherid (int, optional)
//  - cohortid  (int, optional)
//  - studentid (int, optional)
//
// Returns concrete occurrences from {googlemeet_events} for:
//  - 1:1 classes  (courseid = 24)
//  - Group classes (courseid = 2)
//
// Each returned event includes:
//  - eventid        : id from {googlemeet_events}
//  - main_event_id  : stable parent id per googlemeet
//  - is_parent      : bool
//  - sequence       : order within that meet
//  - googlemeetid, cmid, courseid
//  - teacherids[], studentids[], cohortids[]
//  - class_type     : 'single' | 'weekly'
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
$startraw   = required_param('start', PARAM_RAW_TRIMMED);
$endraw     = required_param('end', PARAM_RAW_TRIMMED);
$teacherid  = optional_param('teacherid', 0, PARAM_INT);
$cohortid   = optional_param('cohortid', 0, PARAM_INT);
$studentid  = optional_param('studentid', 0, PARAM_INT);

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
    if (empty($json)) return null;
    $arr = json_decode($json, true);
    return is_array($arr) ? $arr : null;
};

$availability_collect_emails = function (?string $json) use ($json_to_array): array {
    $tree = $json_to_array($json);
    if (!$tree) return [];
    $out = [];
    $walk = function($node) use (&$walk, &$out) {
        if (is_object($node)) $node = (array)$node;
        if (!is_array($node)) return;

        if (($node['type'] ?? '') === 'profile') {
            $field = strtolower((string)($node['sf'] ?? $node['field'] ?? ''));
            if ($field === 'email') {
                $val = trim((string)($node['v'] ?? $node['value'] ?? ''));
                if ($val !== '') {
                    $out[] = core_text::strtolower($val);
                }
            }
        }
        foreach (['c','showc','children','conditions'] as $k) {
            if (!empty($node[$k]) && is_array($node[$k])) {
                foreach ($node[$k] as $child) $walk($child);
            }
        }
    };
    $walk($tree);
    return array_values(array_unique($out));
};

$availability_collect_cohorts = function (?string $json) use ($json_to_array): array {
    $tree = $json_to_array($json);
    if (!$tree) return [];
    $ids = [];
    $walk = function($node) use (&$walk, &$ids) {
        if (is_object($node)) $node = (array)$node;
        if (!is_array($node)) return;

        if (($node['type'] ?? '') === 'cohort' && !empty($node['id'])) {
            $ids[] = (int)$node['id'];
        }
        foreach (['c','showc','children','conditions'] as $k) {
            if (!empty($node[$k]) && is_array($node[$k])) {
                foreach ($node[$k] as $child) $walk($child);
            }
        }
    };
    $walk($tree);
    return array_values(array_unique($ids));
};

$fmt_iso = static function(int $ts) { return gmdate('c', $ts); };

// ---- Relevant user/cohort lookups ----

$teacher = $teacherid ? $DB->get_record('user', ['id' => $teacherid, 'deleted' => 0], 'id,email', IGNORE_MISSING) : null;
$student = $studentid ? $DB->get_record('user', ['id' => $studentid, 'deleted' => 0], 'id,email', IGNORE_MISSING) : null;
$cohort  = $cohortid  ? $DB->get_record('cohort', ['id' => $cohortid], 'id', IGNORE_MISSING) : null;

$teacherEmailLower = $teacher && $teacher->email ? core_text::strtolower(trim($teacher->email)) : null;
$studentEmailLower = $student && $student->email ? core_text::strtolower(trim($student->email)) : null;

$email_to_userid = function(array $emails) use ($DB): array {
    $emails = array_values(array_unique(array_filter($emails)));
    if (!$emails) return [];
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
    $teacherid,
    $studentid,
    $cohortid,
    $teacherEmailLower,
    $studentEmailLower,
    $availability_collect_emails,
    $fmt_iso,
    $email_to_userid,
    &$events
) {
    $mod = $DB->get_record('modules', ['name' => 'googlemeet'], 'id', IGNORE_MISSING);
    if (!$mod) return;

    $sections = $DB->get_records('course_sections', ['course' => $courseid_one2one], 'id ASC', 'id,availability');

    // Map section → teacher (when teacher filter present)
    $sectionTeachers = [];
    if ($teacherid && $teacherEmailLower) {
        foreach ($sections as $sec) {
            $emails = $availability_collect_emails($sec->availability ?? null);
            if ($emails && in_array($teacherEmailLower, $emails, true)) {
                $sectionTeachers[$sec->id][] = $teacherid;
            }
        }
    }

    $cms = $DB->get_records('course_modules', [
        'course' => $courseid_one2one,
        'module' => $mod->id,
        'deletioninprogress' => 0
    ], 'id ASC', 'id,instance,section,availability');

    if (!$cms) return;

    // Collect all emails for mapping
    $allEmails = [];
    foreach ($cms as $cm) {
        $allEmails = array_merge($allEmails, $availability_collect_emails($cm->availability ?? null));
    }
    if ($teacherEmailLower) $allEmails[] = $teacherEmailLower;
    if ($studentEmailLower) $allEmails[] = $studentEmailLower;
    $emailUserMap = $email_to_userid($allEmails);

    // Preload googlemeet instances
    $instanceIds = array_map(fn($cm) => (int)$cm->instance, $cms);
    $gminstances = [];
    if ($instanceIds) {
        list($insql, $inparams) = $DB->get_in_or_equal($instanceIds, SQL_PARAMS_NAMED);
        $gminstances = $DB->get_records_select('googlemeet', "id $insql", $inparams);
    }

    foreach ($cms as $cmid => $cm) {
        $gm = $gminstances[$cm->instance] ?? null;
        if (!$gm) continue;

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

        // Derive teacher from section (for filtered cases)
        $teacherIds = [];
        if ($teacherid) {
            if (!empty($sectionTeachers[$cm->section]) && in_array($teacherid, $sectionTeachers[$cm->section], true)) {
                $teacherIds[] = $teacherid;
            } else {
                continue;
            }
        }

        // Cohort filter: by design 1:1 not tied direct to a cohort → skip if cohortid is set
        if ($cohortid) {
            continue;
        }

        // Load occurrences inside window
        $allevents = $DB->get_records_select(
            'googlemeet_events',
            'googlemeetid = :gid
             AND eventdate <= :end
             AND (eventdate + (duration*60)) >= :start',
            [
                'gid'   => (int)$gm->id,
                'start' => $startts,
                'end'   => $endts
            ],
            'eventdate ASC, id ASC',
            'id,googlemeetid,eventdate,duration'
        );
        if (!$allevents) continue;

        // Recurrence metadata
        $ids = [];
        foreach ($allevents as $ev) { $ids[] = (int)$ev->id; }
        $mainEventId = $ids ? min($ids) : 0;
        $isrecurring = (count($allevents) > 1);
        $classType   = $isrecurring ? 'weekly' : 'single';

        // URLs
        $meetingurl = '';
        foreach (['meetingurl','meeting_url','meeturl','joinurl','join_url','url','link'] as $f) {
            if (!empty($gm->$f)) { $meetingurl = (string)$gm->$f; break; }
        }
        $viewurl = (new moodle_url('/mod/googlemeet/view.php', ['id' => $cm->id]))->out(false);

        // Build event entries
        $seq = 1;
        foreach ($allevents as $e) {
            $start = (int)$e->eventdate;
            $end   = $start + max(60, (int)$e->duration * 60);

            $events[] = [
                'id'            => '1to1-' . $e->id,
                'eventid'       => (int)$e->id,           // <--- googlemeet_events.id
                'main_event_id' => (int)$mainEventId,
                'is_parent'     => ((int)$e->id === $mainEventId),
                'sequence'      => $seq++,

                'source'        => 'one2one',
                'courseid'      => $courseid_one2one,
                'cmid'          => (int)$cm->id,
                'googlemeetid'  => (int)$gm->id,
                'title'         => (string)$gm->name,

                'start_ts'      => $start,
                'end_ts'        => $end,
                'start'         => $fmt_iso($start),
                'end'           => $fmt_iso($end),

                'teacherids'    => $teacherIds,
                'studentids'    => $studentIds,
                'cohortids'     => [],

                'class_type'    => $classType,
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
    &$events
) {
    $mod = $DB->get_record('modules', ['name' => 'googlemeet'], 'id', IGNORE_MISSING);
    if (!$mod) return;

    // All cohorts map
    $cohortById = $DB->get_records('cohort', null, '', 'id,cohortmainteacher,cohortguideteacher');

    // Student cohorts (for filter)
    $studentCohorts = [];
    if ($studentid) {
        $rows = $DB->get_records('cohort_members', ['userid' => $studentid], '', 'id,cohortid');
        $studentCohorts = array_map(fn($r) => (int)$r->cohortid, $rows);
    }

    $sections = $DB->get_records('course_sections', ['course' => $courseid_group], 'id ASC', 'id,availability,section');

    $cms = $DB->get_records('course_modules', [
        'course' => $courseid_group,
        'module' => $mod->id,
        'deletioninprogress' => 0
    ], 'id ASC', 'id,instance,section');

    if (!$cms) return;

    // Preload googlemeet
    $instanceIds = array_map(fn($cm) => (int)$cm->instance, $cms);
    $gminstances = [];
    if ($instanceIds) {
        list($insql, $inparams) = $DB->get_in_or_equal($instanceIds, SQL_PARAMS_NAMED);
        $gminstances = $DB->get_records_select('googlemeet', "id $insql", $inparams);
    }

    foreach ($cms as $cmid => $cm) {
        $gm = $gminstances[$cm->instance] ?? null;
        if (!$gm) continue;

        $sec = $sections[$cm->section] ?? null;
        if (!$sec) continue;

        // Section cohorts
        $cohortIds = $availability_collect_cohorts($sec->availability ?? null);

        // Cohort filter
        if ($cohortid && $cohortIds && !in_array($cohortid, $cohortIds, true)) {
            continue;
        }

        // Teacher from cohorts
        $teacherIds = [];
        foreach ($cohortIds as $cid) {
            if (!isset($cohortById[$cid])) continue;
            $c = $cohortById[$cid];
            if (!empty($c->cohortmainteacher)) {
                $teacherIds[] = (int)$c->cohortmainteacher;
            }
            if (!empty($c->cohortguideteacher)) {
                $teacherIds[] = (int)$c->cohortguideteacher;
            }
        }
        $teacherIds = array_values(array_unique(array_filter($teacherIds)));

        // Teacher filter
        if ($teacherid && $teacherIds && !in_array($teacherid, $teacherIds, true)) {
            continue;
        }
        if ($teacherid && !$cohortid && !$teacherIds) {
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
             AND (eventdate + (duration*60)) >= :start',
            [
                'gid'   => (int)$gm->id,
                'start' => $startts,
                'end'   => $endts
            ],
            'eventdate ASC, id ASC',
            'id,googlemeetid,eventdate,duration'
        );
        if (!$allevents) continue;

        $ids = [];
        foreach ($allevents as $ev) { $ids[] = (int)$ev->id; }
        $mainEventId = $ids ? min($ids) : 0;
        $isrecurring = (count($allevents) > 1);
        $classType   = $isrecurring ? 'weekly' : 'single';

        $meetingurl = '';
        foreach (['meetingurl','meeting_url','meeturl','joinurl','join_url','url','link'] as $f) {
            if (!empty($gm->$f)) { $meetingurl = (string)$gm->$f; break; }
        }
        $viewurl = (new moodle_url('/mod/googlemeet/view.php', ['id' => $cmid]))->out(false);

        $seq = 1;
        foreach ($allevents as $e) {
            $start = (int)$e->eventdate;
            $end   = $start + max(60, (int)$e->duration * 60);

            $events[] = [
                'id'            => 'group-' . $e->id,
                'eventid'       => (int)$e->id,          // <--- googlemeet_events.id
                'main_event_id' => (int)$mainEventId,
                'is_parent'     => ((int)$e->id === $mainEventId),
                'sequence'      => $seq++,

                'source'        => 'group',
                'courseid'      => $courseid_group,
                'cmid'          => (int)$cmid,
                'googlemeetid'  => (int)$gm->id,
                'title'         => (string)$gm->name,

                'start_ts'      => $start,
                'end_ts'        => $end,
                'start'         => $fmt_iso($start),
                'end'           => $fmt_iso($end),

                'teacherids'    => $teacherIds,
                'studentids'    => [], // implicit via cohort
                'cohortids'     => $cohortIds,

                'class_type'    => $classType,
                'is_recurring'  => $isrecurring,

                'meetingurl'    => $meetingurl,
                'viewurl'       => $viewurl,
            ];
        }
    }
};

// ---- COLLECT ----

try {
    $add_group_events();
    $add_one2one_events();

    // Final strict filter pass (intersection safety net)
    $filtered = [];
    foreach ($events as $ev) {
        if ($teacherid && !in_array($teacherid, $ev['teacherids'], true)) {
            continue;
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

            if (!$ok) continue;
        }

        $filtered[] = $ev;
    }

    usort($filtered, fn($a, $b) => $a['start_ts'] <=> $b['start_ts']);

    echo json_encode([
        'ok'      => true,
        'filters' => [
            'start'     => $startts,
            'end'       => $endts,
            'teacherid' => $teacherid,
            'cohortid'  => $cohortid,
            'studentid' => $studentid,
        ],
        'events'  => array_values($filtered),
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
