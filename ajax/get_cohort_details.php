<?php
// local/customplugin/ajax/get_cohort_details.php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();
require_sesskey();

@header('Content-Type: application/json; charset=utf-8');

$PAGE->set_context(context_system::instance());

$idnumber = required_param('idnumber', PARAM_RAW_TRIMMED);

global $DB, $CFG;

$cohort = $DB->get_record('cohort', ['idnumber' => $idnumber], '*', IGNORE_MISSING);
if (!$cohort) {
    echo json_encode(['ok' => false, 'error' => 'Cohort not found'], JSON_UNESCAPED_UNICODE);
    exit;
}

// --- Helpers (prefixed to avoid collisions with Moodle core) ---
function cc_full_name_safe(?stdClass $u): ?string {
    if (!$u) return null;
    $first = trim((string)($u->firstname ?? ''));
    $last  = trim((string)($u->lastname ?? ''));
    $name  = trim($first . ' ' . $last);
    return $name !== '' ? $name : ($u->username ?? null);
}

/** Given hour/minute, return "h:mm am/pm" (e.g., 9:30 am). Returns null if nulls. */
function cc_fmt_time(?int $h, ?int $m): ?string {
    if ($h === null || $m === null) return null;
    $ts = mktime($h, $m, 0, 1, 1, 2000);
    return strtolower(date('g:i a', $ts));
}

/** Add minutes to (h,m) and format back. */
function cc_fmt_time_plus(?int $h, ?int $m, int $addmins = 60): ?string {
    if ($h === null || $m === null) return null;
    $ts = mktime($h, $m + $addmins, 0, 1, 1, 2000);
    return strtolower(date('g:i a', $ts));
}

/** Build user picture URL (simple, no token). */
function cc_user_pic_url(int $userid): string {
    global $CFG;
    return $CFG->wwwroot . '/user/pix.php/' . $userid . '/f2';
}

// --- Teachers (optional fields, so IGNORE_MISSING) ---
$teacher1 = !empty($cohort->cohortmainteacher)
    ? $DB->get_record('user', ['id' => $cohort->cohortmainteacher], 'id,firstname,lastname,username', IGNORE_MISSING)
    : null;

$teacher2 = !empty($cohort->cohortguideteacher)
    ? $DB->get_record('user', ['id' => $cohort->cohortguideteacher], 'id,firstname,lastname,username', IGNORE_MISSING)
    : null;

// --- Days (make sure to use the correct column names; fix any typos) ---
$daysMain = [];
if (!empty($cohort->cohortmonday))    $daysMain[] = 'Mon';
if (!empty($cohort->cohorttuesday))   $daysMain[] = 'Tue';
if (!empty($cohort->cohortwednesday)) $daysMain[] = 'Wed';
if (!empty($cohort->cohortthursday))  $daysMain[] = 'Thu';
if (!empty($cohort->cohortfriday))    $daysMain[] = 'Fri';

$daysTutor = [];
if (!empty($cohort->cohorttutormonday))    $daysTutor[] = 'Mon';
if (!empty($cohort->cohorttutortuesday))   $daysTutor[] = 'Tue';
if (!empty($cohort->cohorttutorwednesday)) $daysTutor[] = 'Wed';
if (!empty($cohort->cohorttutorthursday))  $daysTutor[] = 'Thu'; // NOTE: ensure your DB column is *cohorttutorthursday*
if (!empty($cohort->cohorttutorfriday))    $daysTutor[] = 'Fri';

// --- Times ---
$mainStart = cc_fmt_time($cohort->cohorthours ?? null, $cohort->cohortminutes ?? null);
$mainEnd   = cc_fmt_time_plus($cohort->cohorthours ?? null, $cohort->cohortminutes ?? null, 60);

$tutorStart = cc_fmt_time($cohort->cohorttutorhours ?? null, $cohort->cohorttutorminutes ?? null);
$tutorEnd   = cc_fmt_time_plus($cohort->cohorttutorhours ?? null, $cohort->cohorttutorminutes ?? null, 60);

// --- Output ---
$out = [
    'ok' => true,
    'cohort' => [
        'id'        => (int)$cohort->id,
        'name'      => $cohort->name,
        'shortname' => $cohort->shortname,
        'idnumber'  => $cohort->idnumber,
        'enabled'   => (int)($cohort->enabled ?? 0),
        'visible'   => (int)($cohort->visible ?? 0),
        'color'     => $cohort->cohortcolor ?? null,
        'startdate' => !empty($cohort->startdate) ? (int)$cohort->startdate : null,
        'enddate'   => !empty($cohort->enddate)   ? (int)$cohort->enddate   : null,

        'main' => [
            'days'    => $daysMain,
            'start'   => $mainStart,
            'end'     => $mainEnd,
            'teacher' => $teacher1 ? [
                'id'     => (int)$teacher1->id,
                'name'   => cc_full_name_safe($teacher1),
                'avatar' => cc_user_pic_url($teacher1->id),
            ] : null,
            // 'timezone' => $cohort->cohortmaintz ?? null, // if you store it
            // 'classname'=> 'Main Class',                  // if you want to override
        ],

        'tutor' => [
            'days'    => $daysTutor,
            'start'   => $tutorStart,
            'end'     => $tutorEnd,
            'teacher' => $teacher2 ? [
                'id'     => (int)$teacher2->id,
                'name'   => cc_full_name_safe($teacher2),
                'avatar' => cc_user_pic_url($teacher2->id),
            ] : null,
            // 'timezone' => $cohort->cohorttutortz ?? null,
            // 'classname'=> 'Tutoring Class',
        ],
    ],
];

echo json_encode($out, JSON_UNESCAPED_UNICODE);
