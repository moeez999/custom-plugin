<?php
// ajax/ajax_one2one_getclasses.php
// Returns activities (Google Meet) and their events for a given teacher+student under course 24.
// Uses plugin table {googlemeet_events} with schema: id, googlemeetid, eventdate, duration, timemodified.
// For recurring classes, returns only the NEXT 40 FUTURE occurrences (eventdate >= now).
//
// Inputs (GET/POST):
//   teacherid (int, required)
//   studentid (int, required)
//   classtype ('single'|'weekly', optional; default 'single')
//
// Output: JSON (read-only; no updates)

define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();

global $DB, $PAGE;

header('Content-Type: application/json');

$courseid  = 24;

$teacherid = required_param('teacherid', PARAM_INT);
$studentid = required_param('studentid', PARAM_INT);
$classtype = optional_param('classtype', 'single', PARAM_ALPHA); // 'single' | 'weekly'

if (!$teacherid || !$studentid) {
    echo json_encode(['ok' => false, 'error' => 'teacherid and studentid are required']);
    exit;
}

try {
    // Ensure user can at least view the course.
    $context = context_course::instance($courseid, MUST_EXIST);
    require_capability('moodle/course:view', $context);

    // --- Resolve teacher & student (lowercased emails) ---
    $teacher = $DB->get_record('user', ['id' => $teacherid, 'deleted' => 0, 'suspended' => 0],
        'id, firstname, lastname, email', IGNORE_MISSING);
    $student = $DB->get_record('user', ['id' => $studentid, 'deleted' => 0, 'suspended' => 0],
        'id, firstname, lastname, email', IGNORE_MISSING);

    if (!$teacher || empty($teacher->email)) {
        echo json_encode(['ok' => false, 'error' => 'Teacher not found or has no email']);
        exit;
    }
    if (!$student || empty($student->email)) {
        echo json_encode(['ok' => false, 'error' => 'Student not found or has no email']);
        exit;
    }

    $teacherEmailLower = core_text::strtolower(trim($teacher->email));
    $studentEmailLower = core_text::strtolower(trim($student->email));

    // --- Helpers ---
    $json_to_array = function (?string $json) {
        if (empty($json)) return null;
        $arr = json_decode($json, true);
        return is_array($arr) ? $arr : null;
    };

    $availability_has_exact_email = function (?string $json, string $targetLower) use ($json_to_array): bool {
        $tree = $json_to_array($json);
        if (!$tree) return false;

        $found = false;
        $walk = function($node) use (&$walk, &$found, $targetLower) {
            if ($found) return;
            if (is_object($node)) $node = (array)$node;
            if (!is_array($node)) return;

            if (($node['type'] ?? '') === 'profile') {
                $field = strtolower((string)($node['sf'] ?? $node['field'] ?? ''));
                if ($field === 'email') {
                    $val = strtolower(trim((string)($node['v'] ?? $node['value'] ?? '')));
                    $op  = strtolower((string)($node['op'] ?? 'isequalto'));
                    $equalsOps = ['isequalto','eq','==','='];
                    if ($val !== '' && in_array($op, $equalsOps, true) && $val === $targetLower) {
                        $found = true;
                        return;
                    }
                }
            }
            foreach (['c','showc','children','conditions'] as $k) {
                if (!empty($node[$k]) && is_array($node[$k])) {
                    foreach ($node[$k] as $child) {
                        $walk($child);
                        if ($found) return;
                    }
                }
            }
        };
        $walk($tree);
        return $found;
    };

    $collect_all_emails = function (?string $json) use ($json_to_array): array {
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
                    if ($val !== '') $out[] = strtolower($val);
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

    $fmt_iso = function(int $ts) { return gmdate('c', $ts); };
    $fmt_disp = function(int $ts) {
        return userdate($ts, '%a, %d %b %Y %I:%M %p');
    };

    // --- Find Google Meet module id ---
    $mod = $DB->get_record('modules', ['name' => 'googlemeet'], 'id', IGNORE_MISSING);
    if (!$mod) {
        echo json_encode(['ok' => false, 'error' => 'Google Meet module not found']);
        exit;
    }

    // --- 1) Teacher sections by section availability ---
    $sections = $DB->get_records('course_sections', ['course' => $courseid],
        'section ASC', 'id, section, name, availability');

    $teacherSectionIds = [];
    $teacherSectionsOut = [];

    foreach ($sections as $sec) {
        if ($availability_has_exact_email($sec->availability ?? null, $teacherEmailLower)) {
            $teacherSectionIds[] = (int)$sec->id;
            $teacherSectionsOut[$sec->id] = [
                'sectionid'   => (int)$sec->id,
                'sectionnum'  => (int)$sec->section,
                'sectionname' => (string)($sec->name ?? '')
            ];
        }
    }

    if (!$teacherSectionIds) {
        echo json_encode(['ok' => true,
            'teacher' => ['id' => (int)$teacher->id, 'email' => $teacher->email, 'fullname' => fullname($teacher)],
            'student' => ['id' => (int)$student->id, 'email' => $student->email, 'fullname' => fullname($student)],
            'classtype' => $classtype,
            'sections' => [],
            'activities' => []
        ]);
        exit;
    }

    // --- 2) Google Meet activities in those sections ---
    list($insecsql, $insecparams) = $DB->get_in_or_equal($teacherSectionIds, SQL_PARAMS_NAMED, 's');
    $cms = $DB->get_records_sql("
        SELECT cm.id AS cmid, cm.instance, cm.section, cm.availability, cm.visible
          FROM {course_modules} cm
         WHERE cm.course = :courseid
           AND cm.module = :moduleid
           AND cm.section $insecsql
           AND cm.deletioninprogress = 0
         ORDER BY cm.id ASC
    ", ['courseid' => $courseid, 'moduleid' => $mod->id] + $insecparams);

    if (!$cms) {
        echo json_encode(['ok' => true,
            'teacher' => ['id' => (int)$teacher->id, 'email' => $teacher->email, 'fullname' => fullname($teacher)],
            'student' => ['id' => (int)$student->id, 'email' => $student->email, 'fullname' => fullname($student)],
            'classtype' => $classtype,
            'sections' => array_values($teacherSectionsOut),
            'activities' => []
        ]);
        exit;
    }

    // --- 3) Filter activities by student's email in activity availability ---
    $matchingActivities = []; // keyed by cmid
    foreach ($cms as $cm) {
        $emails = $collect_all_emails($cm->availability ?? null);
        if (!$emails) continue;
        if (in_array($studentEmailLower, $emails, true)) {
            $matchingActivities[$cm->cmid] = $cm;
        }
    }

    if (!$matchingActivities) {
        echo json_encode(['ok' => true,
            'teacher' => ['id' => (int)$teacher->id, 'email' => $teacher->email, 'fullname' => fullname($teacher)],
            'student' => ['id' => (int)$student->id, 'email' => $student->email, 'fullname' => fullname($student)],
            'classtype' => $classtype,
            'sections' => array_values($teacherSectionsOut),
            'activities' => []
        ]);
        exit;
    }

    // --- 4) For each matching activity, include googlemeet details and events NESTED UNDER googlemeet ---
    $outActivities = [];

    // Classification buckets
    $singleClasses = [];
    $weeklyClasses = [];

    $instanceIds = array_map(fn($cm) => (int)$cm->instance, $matchingActivities);
    $gminstances = [];
    if ($instanceIds) {
        list($insql, $inparams) = $DB->get_in_or_equal($instanceIds, SQL_PARAMS_NAMED);
        $gminstances = $DB->get_records_select('googlemeet', "id $insql", $inparams);
    }

    $now = time();

    foreach ($matchingActivities as $cmid => $cm) {
        $gm = $gminstances[$cm->instance] ?? $DB->get_record('googlemeet', ['id' => $cm->instance], '*', IGNORE_MISSING);
        if (!$gm) continue;

        // FULL googlemeet record for "include all details"
        $gmfull = $gm; // stdClass, json_encode() is fine.

        // Meeting URL-like field (still provided at top-level convenience)
        $meetingurl = '';
        foreach (['meetingurl','meeting_url','meeturl','joinurl','join_url','url','link','meetinglink','meeting_link'] as $f) {
            if (isset($gm->$f) && !empty($gm->$f)) { $meetingurl = (string)$gm->$f; break; }
        }

        $viewurl = (new moodle_url('/mod/googlemeet/view.php', ['id' => $cmid]))->out(false);
        $name = (string)($gm->name ?? '');

        // Pull events from plugin table
        $allEvents = $DB->get_records('googlemeet_events',
            ['googlemeetid' => (int)$gm->id],
            'eventdate ASC',
            'id, googlemeetid, eventdate, duration, timemodified'
        );

        $isrecurring = false;
        $maineventid = 0;
        $eventsOut = [];

        if ($allEvents) {
            // Recurring if more than one row.
            $isrecurring = (count($allEvents) > 1);

            // Parent: the earliest id (stable)
            $ids = array_map(fn($e) => (int)$e->id, $allEvents);
            $maineventid = $ids ? min($ids) : 0;

            // For weekly (recurring) → future 40 only.
            $eventsForOutput = $allEvents;
            if ($isrecurring) {
                $future = array_filter($allEvents, fn($e) => (int)$e->eventdate >= $now);
                usort($future, function($a, $b) {
                    if ((int)$a->eventdate === (int)$b->eventdate) return (int)$a->id <=> (int)$b->id;
                    return (int)$a->eventdate <=> (int)$b->eventdate;
                });
                if ($classtype === 'weekly') {
                    $eventsForOutput = array_slice($future, 0, 40);
                } else {
                    $eventsForOutput = $future; // for single, keep all future (matches previous behavior)
                }
            }

            // Build enriched event objects
            $seq = 1;
            foreach ($eventsForOutput as $e) {
                $startTs = (int)$e->eventdate;
                // ASSUMPTION: duration stored in MINUTES.
                $endTs   = $startTs + ((int)$e->duration * 60);

                $eventsOut[] = [
                    'id'               => (int)$e->id,
                    'googlemeetid'     => (int)$e->googlemeetid,
                    'eventdate'        => (int)$e->eventdate,
                    'duration'         => (int)$e->duration,
                    'timemodified'     => (int)$e->timemodified,
                    'sequence'         => $seq++,
                    'is_parent'        => ((int)$e->id === (int)$maineventid),

                    'start_ts'         => $startTs,
                    'end_ts'           => $endTs,
                    'duration_minutes' => (int)$e->duration,
                    'start_iso'        => $fmt_iso($startTs),
                    'end_iso'          => $fmt_iso($endTs),
                    'start_display'    => $fmt_disp($startTs),
                    'end_display'      => $fmt_disp($endTs),
                ];
            }
        }

        // Decide class type from ALL occurrences:
        // - single: exactly one event row
        // - weekly: more than one event row
        $classType = 'single';
        if (!empty($allEvents) && count($allEvents) > 1) {
            $classType = 'weekly';
        }

        // IMPORTANT: filter by requested classtype so weekly doesn't leak into single.
        if ($classtype === 'single' && $classType !== 'single') {
            continue;
        }
        if ($classtype === 'weekly' && $classType !== 'weekly') {
            continue;
        }
        // Any other classtype value → no filter (keeps compatibility if you ever pass 'all').

        // Attach events under the googlemeet object itself (+ optional summary)
        $gmfull->events = $eventsOut;
        if (!empty($eventsOut)) {
            $first = $eventsOut[0];
            $last  = $eventsOut[count($eventsOut)-1];

            $gmfull->first_start_ts   = $first['start_ts'];
            $gmfull->first_start_iso  = $first['start_iso'];
            $gmfull->first_start_disp = $first['start_display'];

            $gmfull->last_end_ts      = $last['end_ts'];
            $gmfull->last_end_iso     = $last['end_iso'];
            $gmfull->last_end_disp    = $last['end_display'];
        }

        $sectionMeta = $teacherSectionsOut[$cm->section] ?? [
            'sectionid'   => (int)$cm->section,
            'sectionnum'  => null,
            'sectionname' => ''
        ];

        // Build the activity payload
        $activity = [
            'section'      => $sectionMeta,
            'teacher_matched_by_section_email'  => true,
            'student_matched_by_activity_email' => true,

            'cmid'        => (int)$cmid,
            'instanceid'  => (int)$cm->instance,
            'name'        => $name,
            'viewurl'     => $viewurl,
            'meetingurl'  => $meetingurl,
            'availability'=> (string)($cm->availability ?? ''),
            'visible'     => (int)$cm->visible,
            'is_recurring'=> (bool)$isrecurring,
            'main_event_id' => (int)$maineventid,

            'class_type'  => $classType,
            'googlemeet'  => $gmfull,
        ];

        $outActivities[] = $activity;

        if ($classType === 'single') {
            $singleClasses[] = $activity;
        } else {
            $weeklyClasses[] = $activity;
        }
    }

    echo json_encode([
        'ok'       => true,
        'teacher'  => [
            'id'       => (int)$teacher->id,
            'email'    => (string)$teacher->email,
            'fullname' => fullname($teacher),
        ],
        'student'  => [
            'id'       => (int)$student->id,
            'email'    => (string)$student->email,
            'fullname' => fullname($student),
        ],
        'classtype' => $classtype,
        'sections'  => array_values($teacherSectionsOut),
        'activities'=> $outActivities,
        'single_classes' => $singleClasses,
        'weekly_classes' => $weeklyClasses,
        'main_event_ids' => array_values(array_unique(array_filter(array_map(
            fn($a) => (int)$a['main_event_id'], $outActivities
        )))),
    ]);

} catch (required_capability_exception $e) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'Permission denied']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
