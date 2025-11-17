<?php
// ajax/calendar_admin_filters.php

define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();

header('Content-Type: application/json');

global $DB, $USER, $PAGE, $CFG;

// Security (adjust if you want more/less strict).
$systemcontext = context_system::instance();
if (!is_siteadmin($USER) && !has_capability('moodle/site:config', $systemcontext)) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'Access denied']);
    exit;
}

$action = required_param('action', PARAM_ALPHA); // teachers | cohorts | students | one1one

require_once($CFG->libdir . '/outputcomponents.php'); // for user_picture

// 1:1 google meet course id.
$courseid_one2one = 24;

/**
 * Build avatar URL using Moodle's user_picture (same style as your snippet).
 */
function caf_get_user_avatar_url(stdClass $user): string {
    global $PAGE;
    $pic = new user_picture($user);
    $pic->size = 50;
    $url = $pic->get_url($PAGE);
    return $url ? $url->out(false) : '';
}

/**
 * Safely parse comma-separated IDs.
 */
function caf_parse_ids(string $csv): array {
    $out = [];
    foreach (explode(',', $csv) as $p) {
        $id = (int) trim($p);
        if ($id > 0 && !in_array($id, $out, true)) {
            $out[] = $id;
        }
    }
    return $out;
}

/**
 * Extract all email values from an "availability" JSON tree.
 * (Same logic style as in your calendar_admin_get_events.php.)
 */
function caf_availability_collect_emails(?string $json): array {
    if (empty($json)) {
        return [];
    }
    $tree = json_decode($json, true);
    if (!is_array($tree)) {
        return [];
    }

    $out  = [];
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
}

try {
    // -------------------------------------------------
    // 1) TEACHERS  (existing behaviour – cohort main/guide)
    // -------------------------------------------------
    if ($action === 'teachers') {
        // Collect teacher IDs from cohorts (main + guide).
        $sql = "
            SELECT DISTINCT
                   CASE
                       WHEN c.cohortmainteacher IS NOT NULL THEN c.cohortmainteacher
                       ELSE c.cohortguideteacher
                   END AS uid
              FROM {cohort} c
             WHERE c.visible = 1
               AND (c.cohortmainteacher IS NOT NULL OR c.cohortguideteacher IS NOT NULL)
        ";
        $rows = $DB->get_records_sql($sql);

        $userids = [];
        foreach ($rows as $r) {
            $uid = (int)$r->uid;
            if ($uid > 0 && !in_array($uid, $userids, true)) {
                $userids[] = $uid;
            }
        }

        $teachers = [];
        if ($userids) {
            list($insql, $params) = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED);
            $fields = "id, firstname, lastname, picture, imagealt,
                       firstnamephonetic, lastnamephonetic, middlename, alternatename";
            $teachers = $DB->get_records_select(
                'user',
                "id $insql AND deleted = 0 AND suspended = 0",
                $params,
                'firstname ASC, lastname ASC',
                $fields
            );
        }

        $data = [];
        if ($teachers) {
            foreach ($teachers as $t) {
                $data[] = [
                    'id'     => (int)$t->id,
                    'name'   => fullname($t, true),
                    'avatar' => caf_get_user_avatar_url($t),
                ];
            }
        }

        echo json_encode(['ok' => true, 'data' => $data]);
        exit;
    }

    // -------------------------------------------------
    // 1.1) NEW – 1:1 TEACHERS (course id 24, section availability)
    // -------------------------------------------------
    if ($action === 'one1one') {
        // Grab all sections for the 1:1 course.
        $sections = $DB->get_records(
            'course_sections',
            ['course' => $courseid_one2one],
            'id ASC',
            'id, availability'
        );

        // Collect all emails from section availability.
        $emails = [];
        foreach ($sections as $sec) {
            $emails = array_merge(
                $emails,
                caf_availability_collect_emails($sec->availability ?? null)
            );
        }

        $emails = array_values(array_unique(array_filter($emails)));
        $teachers = [];

        if ($emails) {
            list($insql, $params) = $DB->get_in_or_equal($emails, SQL_PARAMS_NAMED);
            $fields = "id, firstname, lastname, picture, imagealt,
                       firstnamephonetic, lastnamephonetic, middlename, alternatename, email";
            $teachers = $DB->get_records_select(
                'user',
                "LOWER(email) $insql AND deleted = 0 AND suspended = 0",
                $params,
                'firstname ASC, lastname ASC',
                $fields
            );
        }

        $data = [];
        if ($teachers) {
            foreach ($teachers as $t) {
                $data[] = [
                    'id'     => (int)$t->id,
                    'name'   => fullname($t, true),
                    'avatar' => caf_get_user_avatar_url($t),
                ];
            }
        }

        echo json_encode(['ok' => true, 'data' => $data]);
        exit;
    }

    // -------------------------------------------------
    // 2) COHORTS  (+ 1:1 pseudo-cohorts)
    // -------------------------------------------------
    if ($action === 'cohorts') {
        $teacheridsraw = optional_param('teacherids', '', PARAM_RAW_TRIMMED);
        $teacherids    = caf_parse_ids($teacheridsraw);

        // --- normal group cohorts (existing logic) ---
        if (!empty($teacherids)) {
            // Build two separate IN clauses with distinct param prefixes
            list($inmain,  $paramsMain)  = $DB->get_in_or_equal($teacherids, SQL_PARAMS_NAMED, 'mt');
            list($inguide, $paramsGuide) = $DB->get_in_or_equal($teacherids, SQL_PARAMS_NAMED, 'gt');
            $params = $paramsMain + $paramsGuide;

            $sql = "
                SELECT DISTINCT c.id,
                                c.name,
                                c.idnumber,
                                c.shortname,
                                c.cohortmainteacher,
                                c.cohortguideteacher,
                                c.visible
                  FROM {cohort} c
                 WHERE (c.cohortmainteacher $inmain
                        OR c.cohortguideteacher $inguide)
                   AND c.visible = 1
                 ORDER BY c.name ASC
            ";

            $cohorts = $DB->get_records_sql($sql, $params);

        } else {
            // No teacher filter → all visible cohorts
            $cohorts = $DB->get_records(
                'cohort',
                ['visible' => 1],
                'name ASC',
                'id, name, idnumber, shortname, cohortmainteacher, cohortguideteacher, visible'
            );
        }

        $data = [];
        if ($cohorts) {
            foreach ($cohorts as $c) {
                // Use idnumber as label if present, else name
                $label = trim((string)$c->idnumber) !== '' ? $c->shortname : $c->name;

                // Skip hidden just in case
                if (isset($c->visible) && (int)$c->visible === 0) {
                    continue;
                }

                $data[] = [
                    'id'           => (int)$c->id,
                    'name'         => $label,
                    'mainteacher'  => (int)$c->cohortmainteacher,
                    'guideteacher' => (int)$c->cohortguideteacher,
                    // NEW flag to identify this is a real cohort/group
                    'cohorttype'   => 'group',
                ];
            }
        }

        // --- add 1:1 "cohort" entries (actually googlemeet activities) when teacher filter is present ---
        if (!empty($teacherids)) {
            // 1) Fetch teacher records for email + display name.
            list($insqlT, $paramsT) = $DB->get_in_or_equal($teacherids, SQL_PARAMS_NAMED, 't');
            $trecords = $DB->get_records_select(
                'user',
                "id $insqlT AND deleted = 0 AND suspended = 0",
                $paramsT,
                '',
                'id, email, firstname, lastname, picture, imagealt,
                 firstnamephonetic, lastnamephonetic, middlename, alternatename'
            );

            // Map email -> teacher id for selected teachers.
            $emailToTeacher = [];
            foreach ($trecords as $t) {
                if (!empty($t->email)) {
                    $emailToTeacher[core_text::strtolower(trim($t->email))] = (int)$t->id;
                }
            }

            // 2) Get all sections of the 1:1 course.
            $sections11 = $DB->get_records(
                'course_sections',
                ['course' => $courseid_one2one],
                'id ASC',
                'id, availability'
            );

            if ($sections11 && $emailToTeacher) {
                // 3) Load all googlemeet CMs in that course.
                $gmModule = $DB->get_record('modules', ['name' => 'googlemeet'], 'id', IGNORE_MISSING);
                if ($gmModule) {
                    $cms11 = $DB->get_records('course_modules', [
                        'course'             => $courseid_one2one,
                        'module'             => $gmModule->id,
                        'deletioninprogress' => 0
                    ], 'id ASC', 'id, instance, section, module');

                    if ($cms11) {
                        // Collect googlemeet instance IDs
                        $gmids = [];
                        foreach ($cms11 as $cm) {
                            $gmids[] = (int)$cm->instance;
                        }
                        $gmids = array_values(array_unique($gmids));

                        $gminstances = [];
                        if ($gmids) {
                            list($insqlGM, $paramsGM) = $DB->get_in_or_equal($gmids, SQL_PARAMS_NAMED, 'gm');
                            $gminstances = $DB->get_records_select(
                                'googlemeet',
                                "id $insqlGM",
                                $paramsGM
                            );
                        }

                        // Build a mapping section -> CMs in that section
                        $cmsBySection = [];
                        foreach ($cms11 as $cm) {
                            $secid = (int)$cm->section;
                            if (!isset($cmsBySection[$secid])) {
                                $cmsBySection[$secid] = [];
                            }
                            $cmsBySection[$secid][] = $cm;
                        }

                        // Avoid duplicates per (teacher, googlemeet).
                        $seen = [];

                        // 4) For each section, check which of the selected teachers are in that section
                        //    via availability (email). Then for that (teacher, section), add ALL googlemeet
                        //    activities under that section as separate "one1one" entries.
                        foreach ($sections11 as $sec) {
                            $secid = (int)$sec->id;
                            if (empty($cmsBySection[$secid])) {
                                continue;
                            }

                            $emails = caf_availability_collect_emails($sec->availability ?? null);
                            if (!$emails) {
                                continue;
                            }

                            // Which teachers (from our selected set) are associated with this section?
                            $teacherIdsForSection = [];
                            foreach ($emails as $em) {
                                if (isset($emailToTeacher[$em])) {
                                    $tid = $emailToTeacher[$em];
                                    // Only consider teachers that were passed in teacherids filter
                                    if (in_array($tid, $teacherids, true) && !in_array($tid, $teacherIdsForSection, true)) {
                                        $teacherIdsForSection[] = $tid;
                                    }
                                }
                            }

                            if (!$teacherIdsForSection) {
                                continue;
                            }

                            // Now for each teacher found in this section, attach all googlemeet instances here.
                            foreach ($teacherIdsForSection as $tid) {
                                foreach ($cmsBySection[$secid] as $cm) {
                                    $gm = $gminstances[$cm->instance] ?? null;
                                    if (!$gm) {
                                        continue;
                                    }

                                    $key = $tid . ':' . (int)$gm->id;
                                    if (isset($seen[$key])) {
                                        continue;
                                    }
                                    $seen[$key] = true;

                                    // Label = googlemeet name (fallback to originalname)
                                    $label = '';
                                    if (!empty($gm->name)) {
                                        $label = (string)$gm->name;
                                    } else if (!empty($gm->originalname)) {
                                        $label = (string)$gm->originalname;
                                    } else {
                                        $label = 'Google Meet #' . $gm->id;
                                    }

                                    $data[] = [
                                        // id is the googlemeet id here (used later for filtering one2one)
                                        'id'           => (int)$gm->id,
                                        'name'         => $label,
                                        'mainteacher'  => (int)$tid,
                                        'guideteacher' => 0,
                                        'cohorttype'   => 'one1one', // NEW type marker for 1:1 classes
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }

        echo json_encode(['ok' => true, 'data' => $data]);
        exit;
    }

    // -------------------------------------------------
    // 3) STUDENTS
    // -------------------------------------------------
    if ($action === 'students') {
        $cohortid = optional_param('cohortid', 0, PARAM_INT);
        $cohortids_csv = optional_param('cohortids', '', PARAM_RAW);

        // Support multiple cohort IDs
        if (!empty($cohortids_csv)) {
            $cohort_ids = caf_parse_ids($cohortids_csv);
            if (count($cohort_ids) > 0) {
                list($in_sql, $params) = $DB->get_in_or_equal($cohort_ids, SQL_PARAMS_NAMED);
                $sql = "
                    SELECT u.id, u.firstname, u.lastname, u.picture, u.imagealt,
                           u.firstnamephonetic, u.lastnamephonetic,
                           u.middlename, u.alternatename,
                           cm.cohortid,
                           c.name as cohort_name,
                           c.idnumber as cohort_idnumber,
                           c.shortname as cohort_shortname
                      FROM {cohort_members} cm
                      JOIN {user} u ON u.id = cm.userid
                      JOIN {cohort} c ON c.id = cm.cohortid
                     WHERE cm.cohortid $in_sql
                       AND u.deleted = 0
                       AND u.suspended = 0
                     ORDER BY c.name ASC, u.firstname ASC, u.lastname ASC
                ";
                $students = $DB->get_records_sql($sql, $params);
            } else {
                $students = [];
            }
        } elseif ($cohortid > 0) {
            // Students in the selected cohort.
            $sql = "
                SELECT u.id, u.firstname, u.lastname, u.picture, u.imagealt,
                       u.firstnamephonetic, u.lastnamephonetic,
                       u.middlename, u.alternatename,
                       cm.cohortid,
                       c.name as cohort_name,
                       c.idnumber as cohort_idnumber,
                       c.shortname as cohort_shortname
                  FROM {cohort_members} cm
                  JOIN {user} u ON u.id = cm.userid
                  JOIN {cohort} c ON c.id = cm.cohortid
                 WHERE cm.cohortid = :cid
                   AND u.deleted = 0
                   AND u.suspended = 0
                 ORDER BY c.name ASC, u.firstname ASC, u.lastname ASC
            ";
            $students = $DB->get_records_sql($sql, ['cid' => $cohortid]);
        } else {
            // All students across visible cohorts.
            $sql = "
                SELECT u.id, u.firstname, u.lastname, u.picture, u.imagealt,
                       u.firstnamephonetic, u.lastnamephonetic,
                       u.middlename, u.alternatename,
                       cm.cohortid,
                       c.name as cohort_name,
                       c.idnumber as cohort_idnumber,
                       c.shortname as cohort_shortname
                  FROM {cohort_members} cm
                  JOIN {cohort} c ON c.id = cm.cohortid
                  JOIN {user} u   ON u.id = cm.userid
                 WHERE c.visible = 1
                   AND u.deleted = 0
                   AND u.suspended = 0
                 ORDER BY c.name ASC, u.firstname ASC, u.lastname ASC
            ";
            $students = $DB->get_records_sql($sql);
        }

        $data = [];
        foreach ($students as $s) {
            $cohort_label = trim((string)$s->cohort_idnumber) !== '' ? $s->cohort_shortname : $s->cohort_name;
            $data[] = [
                'id'           => (int)$s->id,
                'name'         => fullname($s, true),
                'avatar'       => caf_get_user_avatar_url($s),
                'cohortid'     => (int)$s->cohortid,
                'cohortname'   => $cohort_label,
            ];
        }

        echo json_encode(['ok' => true, 'data' => $data]);
        exit;
    }

    // -------------------------------------------------
    // Invalid action
    // -------------------------------------------------
    echo json_encode(['ok' => false, 'error' => 'Invalid action']);
    exit;

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'ok'    => false,
        'error' => $e->getMessage()
    ]);
    exit;
}
