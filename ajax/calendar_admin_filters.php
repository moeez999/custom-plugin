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

$action = required_param('action', PARAM_ALPHA); // teachers | cohorts | students

require_once($CFG->libdir . '/outputcomponents.php'); // for user_picture

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

try {
    // -------------------------------------------------
    // 1) TEACHERS
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
// 2) COHORTS
// -------------------------------------------------
if ($action === 'cohorts') {
    $teacheridsraw = optional_param('teacherids', '', PARAM_RAW_TRIMMED);
    $teacherids    = caf_parse_ids($teacheridsraw);

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
            'id, name, idnumber, cohortmainteacher, cohortguideteacher, visible'
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
            ];
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

        if ($cohortid > 0) {
            // Students in the selected cohort.
            $sql = "
                SELECT DISTINCT u.id, u.firstname, u.lastname, u.picture, u.imagealt,
                                u.firstnamephonetic, u.lastnamephonetic,
                                u.middlename, u.alternatename
                  FROM {cohort_members} cm
                  JOIN {user} u ON u.id = cm.userid
                 WHERE cm.cohortid = :cid
                   AND u.deleted = 0
                   AND u.suspended = 0
                 ORDER BY u.firstname ASC, u.lastname ASC
            ";
            $students = $DB->get_records_sql($sql, ['cid' => $cohortid]);
        } else {
            // All students across visible cohorts.
            $sql = "
                SELECT DISTINCT u.id, u.firstname, u.lastname, u.picture, u.imagealt,
                                u.firstnamephonetic, u.lastnamephonetic,
                                u.middlename, u.alternatename
                  FROM {cohort_members} cm
                  JOIN {cohort} c ON c.id = cm.cohortid
                  JOIN {user} u   ON u.id = cm.userid
                 WHERE c.visible = 1
                   AND u.deleted = 0
                   AND u.suspended = 0
                 ORDER BY u.firstname ASC, u.lastname ASC
            ";
            $students = $DB->get_records_sql($sql);
        }

        $data = [];
        foreach ($students as $s) {
            $data[] = [
                'id'     => (int)$s->id,
                'name'   => fullname($s, true),
                'avatar' => caf_get_user_avatar_url($s),
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
