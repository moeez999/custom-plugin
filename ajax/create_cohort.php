<?php
// /local/adminboard/ajax/create_cohort.php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();
@header('Content-Type: application/json; charset=utf-8');

try {
    // Resolve context (same as before)
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

    // NEW: support JSON body from frontend
    $isjson = isset($_SERVER['CONTENT_TYPE']) && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== false;
    $payload = null;
    if ($isjson) {
        $raw = file_get_contents('php://input');
        $j = json_decode($raw);
        if (json_last_error() === JSON_ERROR_NONE) {
            $payload = $j;
        }
    }

    // Validate sesskey (supports both JSON and form posts)
    // if ($payload && isset($payload->sesskey)) {
    //     require_sesskey(); // checks against logged-in user's sesskey automatically
    // } else {
    //     require_sesskey(); // form posts still fine
    // }

    // Build cohort object
    $cohort = new stdClass();
    $cohort->contextid = $context->id;

    if ($payload && isset($payload->cohort)) {
        // From JSON (your new structure)
        $c = $payload->cohort;

        // Basic fields
        $cohort->name        = clean_param($c->name        ?? ($c->shortname ?? 'New Cohort'), PARAM_TEXT);
        $cohort->shortname   = clean_param($c->shortname   ?? '', PARAM_TEXT);
        $cohort->idnumber    = clean_param($c->idnumber    ?? '', PARAM_TEXT);
        $cohort->description = clean_param($c->description ?? '', PARAM_RAW); // keep as RAW if you want HTML
        $cohort->descriptionformat = (int)($c->descriptionformat ?? 1);
        // $cohort->visible     = (int)($c->visible ?? 1);
        // $cohort->enabled     = (int)($c->enabled ?? 1);
        $cohort->visible     = 1;
        $cohort->enabled     = 1;

        // Dates
        $cohort->startdate   = !empty($c->startdate) ? (int)$c->startdate : 0;
        $cohort->enddate     = !empty($c->enddate)   ? (int)$c->enddate   : 0;

        // Colors / extras (only if you’ve added these DB columns)
        if (isset($c->cohortcolor)) $cohort->cohortcolor = clean_param($c->cohortcolor, PARAM_RAW_TRIMMED);

        // Main time
        $cohort->cohorthours   = isset($c->cohorthours)   ? (int)$c->cohorthours   : 0;
        $cohort->cohortminutes = isset($c->cohortminutes) ? (int)$c->cohortminutes : 0;

        // Tutor time
        $cohort->cohorttutorhours   = isset($c->cohorttutorhours)   ? (int)$c->cohorttutorhours   : 0;
        $cohort->cohorttutorminutes = isset($c->cohorttutorminutes) ? (int)$c->cohorttutorminutes : 0;

        // Weekday flags (if present)
        foreach ([
            'cohortmonday','cohorttuesday','cohortwednesday','cohortthursday','cohortfriday',
            'cohorttutormonday','cohorttutortuesday','cohorttutorwednesday','cohorttutorthursday','cohorttutorfriday'
        ] as $f) {
            if (isset($c->$f)) $cohort->$f = (int)$c->$f;
        }

        // Teachers (custom columns)
        if (isset($c->cohortmainteacher))  $cohort->cohortmainteacher  = (int)$c->cohortmainteacher;
        if (isset($c->cohortguideteacher)) $cohort->cohortguideteacher = (int)$c->cohortguideteacher;

        // Optional extras if you created columns for them:
        if (isset($c->cohortmaintz))         $cohort->cohortmaintz         = clean_param($c->cohortmaintz, PARAM_TEXT);
        if (isset($c->cohorttutortz))        $cohort->cohorttutortz        = clean_param($c->cohorttutortz, PARAM_TEXT);
        if (isset($c->cohortmainclassname))  $cohort->cohortmainclassname  = clean_param($c->cohortmainclassname, PARAM_TEXT);
        if (isset($c->cohorttutorclassname)) $cohort->cohorttutorclassname = clean_param($c->cohorttutorclassname, PARAM_TEXT);

    } else {
        // Fallback: original form-encoded route (kept as-is)
        $cohort->name      = optional_param('name', '', PARAM_TEXT) ?: 'Alaska 12';
        $cohort->shortname = optional_param('shortname', '', PARAM_TEXT) ?: 'AK12';
        $cohort->idnumber  = optional_param('idnumber', '', PARAM_TEXT) ?: 'AK12-08092025-012';

        $cohort->enabled   = "1";
        $cohort->visible   = "1";
        $cohort->descriptionformat = "1";
        $cohort->description = "";

        $cohort->cohortcolor = trim(optional_param('cohortcolor', 'blue', PARAM_RAW_TRIMMED));

        // Main weekdays + time
        $cohort->cohortmonday    = optional_param('cohortmonday', 0, PARAM_INT);
        $cohort->cohorttuesday   = optional_param('cohorttuesday', 0, PARAM_INT);
        $cohort->cohortwednesday = optional_param('cohortwednesday', 0, PARAM_INT);
        $cohort->cohortthursday  = optional_param('cohortthursday', 0, PARAM_INT);
        $cohort->cohortfriday    = optional_param('cohortfriday', 0, PARAM_INT);
        $cohort->cohorthours     = optional_param('cohorthours', 0, PARAM_INT);
        $cohort->cohortminutes   = optional_param('cohortminutes', 0, PARAM_INT);

        // Tutor weekdays + time
        $cohort->cohorttutormonday    = optional_param('cohorttutormonday', 0, PARAM_INT);
        $cohort->cohorttutortuesday   = optional_param('cohorttutortuesday', 0, PARAM_INT);
        $cohort->cohorttutorwednesday = optional_param('cohorttutorwednesday', 0, PARAM_INT);
        $cohort->cohorttutorthursday  = optional_param('cohorttutorthursday', 0, PARAM_INT);
        $cohort->cohorttutorfriday    = optional_param('cohorttutorfriday', 0, PARAM_INT);
        $cohort->cohorttutorhours     = optional_param('cohorttutorhours', 0, PARAM_INT);
        $cohort->cohorttutorminutes   = optional_param('cohorttutorminutes', 0, PARAM_INT);

        // Teachers
        $cohort->cohortmainteacher  = optional_param('cohortmainteacher', null, PARAM_INT);
        $cohort->cohortguideteacher = optional_param('cohortguideteacher', null, PARAM_INT);

        // Dates (defaults preserved)
        $startdate = optional_param('startdate', 0, PARAM_INT);
        $enddate   = optional_param('enddate', 0, PARAM_INT);
        $cohort->startdate = $startdate ?: 1757304000;
        $cohort->enddate   = $enddate   ?: 1788926400;
    }

    if (!empty($cohort->startdate) && !empty($cohort->enddate) && $cohort->enddate < $cohort->startdate) {
        throw new moodle_exception('invaliddata', 'error', '', 'enddate cannot be earlier than startdate');
    }



    //
    // --------------------------------------------------
    // 1️⃣ Split prefix and number
    // --------------------------------------------------
    if (!preg_match('/^([A-Za-z]+)(\d+)$/', $cohort->shortname, $matches)) {
        throw new moodle_exception('Invalid cohort shortname format');
    }

    $prefix = $matches[1];     // AK
    $currentNumber = (int)$matches[2]; // 4

    if ($currentNumber <= 1) {
        throw new moodle_exception('Cannot reduce cohort number below 1');
    }

    // --------------------------------------------------
    // 2️⃣ Reduce number by 1 → AK3
    // --------------------------------------------------
    $previousNumber = $currentNumber - 1;
    $previousShortname = $prefix . $previousNumber; // AK3

    // --------------------------------------------------
    // 3️⃣ Fetch cohort with shortname AK3
    // --------------------------------------------------
    $previousCohort = $DB->get_record('cohort', [
        'shortname' => $previousShortname
    ], '*', IGNORE_MISSING);

    if (!$previousCohort) {
        throw new moodle_exception('Previous cohort not found: ' . $previousShortname);
    }

    // --------------------------------------------------
    // 4️⃣ Generate NEW name for AK4 (same name, increment number)
    // --------------------------------------------------
    // Example:
    // AK3 → name = "Academic Batch 3"
    // AK4 → name = "Academic Batch 4"

    $baseName = $previousCohort->name;

    // Replace trailing number in name (if exists)
    if (preg_match('/^(.*?)(\d+)$/', $baseName, $nameMatch)) {
        $newName = trim($nameMatch[1]) . ' ' . $currentNumber;
    } else {
        // If name does not contain number, append it
        $newName = $baseName . ' ' . $currentNumber;
    }

    $cohort->name = $newName;
    //
    // Create
    require_once($CFG->dirroot . '/cohort/lib.php');
    $cohortid = cohort_add_cohort($cohort);

    // RESPONSE SHAPE to match your JS drop-in (expects ok + id)
    echo json_encode([
        'ok'  => true,
        'id'  => (int)$cohortid,
        'msg' => 'Cohort created successfully'
    ]);
    exit;

} catch (moodle_exception $ex) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => $ex->errorcode ?? 'moodle_exception', 'message' => $ex->getMessage()]);
    exit;

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'server_error', 'message' => $e->getMessage()]);
    exit;
}
