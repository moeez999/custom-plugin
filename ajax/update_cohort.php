<?php
// /local/adminboard/ajax/update_cohort.php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();
// If your JS sends sesskey and you want to enforce it, uncomment the next line:
// require_sesskey();

@header('Content-Type: application/json; charset=utf-8');

try {
    global $DB, $CFG;

    // ------------------------------
    // 1) Accept JSON single-object payloads
    // ------------------------------
    $jsoninput = null;
    if (!empty($_SERVER['CONTENT_TYPE']) && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
        $raw  = file_get_contents('php://input');
        $json = $raw ? json_decode($raw, true) : null;
        if (is_array($json)) {
            // Prefer "cohort" wrapper if present
            $jsoninput = (isset($json['cohort']) && is_array($json['cohort'])) ? $json['cohort'] : $json;
            // Bubble up helpers for Moodle plumbing if they exist
            foreach (['sesskey','contextid','returnurl'] as $k) {
                if (isset($json[$k])) {
                    $_POST[$k] = $json[$k];
                }
            }
        }
    }

    // ------------------------------
    // 2) Resolve context & permission
    // ------------------------------
    $contextid = optional_param('contextid', 0, PARAM_INT);
    if (!$contextid) {
        $returnurl = optional_param('returnurl', '', PARAM_URL);
        if (!empty($returnurl)) {
            $parts = parse_url($returnurl);
            if (!empty($parts['query'])) {
                parse_str($parts['query'], $q);
                if (!empty($q['contextid'])) {
                    $contextid = (int)$q['contextid'];
                }
            }
        }
    }
    $context = $contextid ? context::instance_by_id($contextid, MUST_EXIST) : context_system::instance();

    require_capability('moodle/cohort:manage', $context);

    // ------------------------------
    // 3) Identify the cohort to update (by id or idnumber)
    // ------------------------------
    $id       = 0;
    $idnumber = '';

    if ($jsoninput) {
        $id       = isset($jsoninput['id']) ? (int)$jsoninput['id'] : 0;
        $idnumber = isset($jsoninput['idnumber']) ? trim((string)$jsoninput['idnumber']) : '';
    } else {
        $id       = optional_param('id', 0, PARAM_INT);
        $idnumber = optional_param('idnumber', '', PARAM_RAW_TRIMMED);
    }

    if (!$id) {
        if ($idnumber === '') {
            throw new moodle_exception('invaliddata', 'error', '', 'Missing id or idnumber for update');
        }
        $id = (int)$DB->get_field('cohort', 'id', ['idnumber' => $idnumber], IGNORE_MISSING);
        if (!$id) {
            throw new moodle_exception('invalidrecord', 'error', '', 'Cohort not found by idnumber');
        }
    }

    $existing = $DB->get_record('cohort', ['id' => $id], '*', MUST_EXIST);

    // ------------------------------
    // 4) Build the update object (prefer JSON; fall back to existing)
    // ------------------------------
    require_once($CFG->dirroot . '/cohort/lib.php');

    $cohort            = new stdClass();
    $cohort->id        = $existing->id;        // REQUIRED for update
    $cohort->contextid = $existing->contextid; // Keep context

    // Small helper to read from JSON or fallback
    $J = function(string $key, $default = null) use ($jsoninput) {
        return ($jsoninput !== null && array_key_exists($key, $jsoninput)) ? $jsoninput[$key] : $default;
    };

    // Core fields
    $cohort->name        = (string)($J('name',       $existing->name));
    $cohort->shortname   = (string)($J('shortname',  $existing->shortname));
    // Allow idnumber change; if you want to lock it, use $existing->idnumber instead.
    $cohort->idnumber    = (string)($J('idnumber',   $existing->idnumber));

    $cohort->visible     = (int)($J('visible',       (int)($existing->visible ?? 1)));
    $cohort->enabled     = (int)($J('enabled',       (int)($existing->enabled ?? 1)));

    $cohort->description       = (string)($J('description',       (string)($existing->description ?? '')));
    $cohort->descriptionformat = (int)   ($J('descriptionformat', (int)   ($existing->descriptionformat ?? 1)));

    // Optional/custom look & feel
    $cohort->theme       = (string)($J('theme',       (string)($existing->theme ?? '')));
    $cohort->cohortcolor = (string)($J('cohortcolor', (string)($existing->cohortcolor ?? '')));

    // Dates (UNIX)
    $cohort->startdate = (int)$J('startdate', (int)($existing->startdate ?? 0));
    $cohort->enddate   = (int)$J('enddate',   (int)($existing->enddate   ?? 0));
    if (!empty($cohort->startdate) && !empty($cohort->enddate) && $cohort->enddate < $cohort->startdate) {
        throw new moodle_exception('invaliddata', 'error', '', 'enddate cannot be earlier than startdate');
    }

    // Main weekdays + time
    $cohort->cohortmonday    = (int)$J('cohortmonday',    (int)($existing->cohortmonday    ?? 0));
    $cohort->cohorttuesday   = (int)$J('cohorttuesday',   (int)($existing->cohorttuesday   ?? 0));
    $cohort->cohortwednesday = (int)$J('cohortwednesday', (int)($existing->cohortwednesday ?? 0));
    $cohort->cohortthursday  = (int)$J('cohortthursday',  (int)($existing->cohortthursday  ?? 0));
    $cohort->cohortfriday    = (int)$J('cohortfriday',    (int)($existing->cohortfriday    ?? 0));
    $cohort->cohorthours     = (int)$J('cohorthours',     (int)($existing->cohorthours     ?? 0));
    $cohort->cohortminutes   = (int)$J('cohortminutes',   (int)($existing->cohortminutes   ?? 0));

    // Tutor weekdays + time
    $cohort->cohorttutormonday    = (int)$J('cohorttutormonday',    (int)($existing->cohorttutormonday    ?? 0));
    $cohort->cohorttutortuesday   = (int)$J('cohorttutortuesday',   (int)($existing->cohorttutortuesday   ?? 0));
    $cohort->cohorttutorwednesday = (int)$J('cohorttutorwednesday', (int)($existing->cohorttutorwednesday ?? 0));
    $cohort->cohorttutorthursday  = (int)$J('cohorttutorthursday',  (int)($existing->cohorttutorthursday  ?? 0));
    $cohort->cohorttutorfriday    = (int)$J('cohorttutorfriday',    (int)($existing->cohorttutorfriday    ?? 0));
    $cohort->cohorttutorhours     = (int)$J('cohorttutorhours',     (int)($existing->cohorttutorhours     ?? 0));
    $cohort->cohorttutorminutes   = (int)$J('cohorttutorminutes',   (int)($existing->cohorttutorminutes   ?? 0));

    // Teacher IDs (custom)
    $cohort->cohortmainteacher  = (int)$J('cohortmainteacher',  (int)($existing->cohortmainteacher  ?? 0));
    $cohort->cohortguideteacher = (int)$J('cohortguideteacher', (int)($existing->cohortguideteacher ?? 0));

    // Optional custom timezone/classname fields (only if they exist in DB)
    $manager = $DB->get_manager();
    if ($manager->field_exists('cohort', 'cohortmaintz')) {
        $cohort->cohortmaintz = (string)$J('cohortmaintz', (string)($existing->cohortmaintz ?? ''));
    }
    if ($manager->field_exists('cohort', 'cohorttutortz')) {
        $cohort->cohorttutortz = (string)$J('cohorttutortz', (string)($existing->cohorttutortz ?? ''));
    }
    if ($manager->field_exists('cohort', 'cohortmainclassname')) {
        $cohort->cohortmainclassname = (string)$J('cohortmainclassname', (string)($existing->cohortmainclassname ?? ''));
    }
    if ($manager->field_exists('cohort', 'cohorttutorclassname')) {
        $cohort->cohorttutorclassname = (string)$J('cohorttutorclassname', (string)($existing->cohorttutorclassname ?? ''));
    }

    // ------------------------------
    // 5) Update
    // ------------------------------
    cohort_update_cohort($cohort);

    $redirect = optional_param('returnurl', '', PARAM_URL);

    echo json_encode([
        'success'  => true,
        'cohortid' => (int)$cohort->id,
        'message'  => 'Cohort updated successfully.',
        'redirect' => $redirect ?: null
    ]);
    exit;

} catch (moodle_exception $ex) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => $ex->errorcode ?? 'moodle_exception',
        'message' => $ex->getMessage()
    ]);
    exit;

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'server_error',
        'message' => $e->getMessage()
    ]);
    exit;
}
