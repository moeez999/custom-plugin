<?php
// /local/adminboard/ajax/get_cohort_template.php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();
require_sesskey();

$context = context_system::instance();
// Adjust to a more appropriate capability for your UI/role model if needed.
require_capability('moodle/site:config', $context);

$teacherid    = required_param('teacherid', PARAM_INT);

@header('Content-Type: application/json; charset=utf-8');

try {
    global $DB;

    // 1) Get cohorts for which this user is MAIN teacher (exclude id=163).
    $select = 'cohortmainteacher = :tid AND id <> 163';
    $params = ['tid' => $teacherid];

    $cohorts = $DB->get_records_select('cohort', $select, $params, 'name ASC',
        'id, name, shortname, idnumber, visible, startdate, enddate');

    if (!$cohorts) {
        // No cohorts -> choose a neutral default like TX1 (or CO1)
        $today = userdate(time(), '%d%m%Y'); // ddmmyyyy in user TZ
        $template = 'CO1-1-' . $today . '-001';
        echo json_encode(['success' => true, 'template' => $template, 'reason' => 'no_cohorts']);
        exit;
    }

    // 2) Find most frequent base name (first word of "name", alphabetic).
    // e.g., "Texas 12" -> "texas", "Ohio 3" -> "ohio".
    $basefreq = [];
    foreach ($cohorts as $c) {
        $base = '';
        if (!empty($c->name)) {
            // First word, strip non-letters
            if (preg_match('/^\s*([A-Za-z]+)/', $c->name, $m)) {
                $base = core_text::strtolower($m[1]);
            }
        }
        if ($base) {
            $basefreq[$base] = ($basefreq[$base] ?? 0) + 1;
        }
    }

    // If we somehow couldn’t parse any base, fallback to "co".
    if (empty($basefreq)) {
        $today = userdate(time(), '%d%m%Y');
        $template = 'CO1-1-' . $today . '-001';
        echo json_encode(['success' => true, 'template' => $template, 'reason' => 'no_base']);
        exit;
    }

    // Most frequent base:
    arsort($basefreq);
    $topbase = array_key_first($basefreq); // e.g., "texas"

    // 3) Within cohorts matching that base, infer the shortname prefix letters (e.g., TX from TX12).
    //    We’ll gather all shortnames that look like PREFIX + number.
    $prefix = null;
    $numbers = []; // numeric parts for the chosen prefix

    foreach ($cohorts as $c) {
        // Only consider rows whose NAME starts with that base (case-insensitive).
        $cname = core_text::strtolower((string)$c->name);
        if (strpos($cname, $topbase) !== 0) {
            continue;
        }
        // Shortname like "TX12" -> capture "TX" and "12"
        if (!empty($c->shortname) && preg_match('/^([A-Za-z]+)(\d+)$/', $c->shortname, $m)) {
            $pref = $m[1];
            $num  = (int)$m[2];
            // Prefer a consistent prefix; lock on the first seen.
            if ($prefix === null) {
                $prefix = $pref;
            }
            if ($pref === $prefix) {
                $numbers[] = $num;
            }
        }
    }

    if ($prefix === null) {
        // Couldn’t infer prefix from shortnames under the top base; fallback to two-letter from base.
        $prefix = core_text::strtoupper(core_text::substr($topbase, 0, 2)); // "te" -> "TE"
        $numbers = [0];
    }

    // 4) Determine the next group number for that prefix (max + 1).
    $maxnum = 0;
    foreach ($numbers as $n) {
        if ($n > $maxnum) $maxnum = $n;
    }
    $nextnum = $maxnum + 1; // e.g., 23 -> 24
    $nextshortname = $prefix . $nextnum; // e.g., TX24

    // 5) Repeat index: count invisible cohorts with shortname == nextshortname, then +1.
    //    (Closed = visible = 0)
    $invisiblecount = $DB->count_records('cohort', ['shortname' => $nextshortname, 'visible' => 0]);
    $repeatindex = $invisiblecount + 1; // if none invisible, becomes 1

    // 6) Date segment: ddmmyyyy (user timezone respected).
    $today = userdate(time(), '%d%m%Y');

    // 7) Serial: find existing idnumbers for SAME nextshortname and SAME repeatindex and SAME date,
    //    then increment the last 3+ digit chunk; else start at 001.
    //    Pattern: "{$nextshortname}-{$repeatindex}-{$today}-NNN"
    $serial = 1;
    // Pull potential matches (avoid DB REGEXP portability issues: fetch candidates and parse in PHP)
    $candidates = $DB->get_records('cohort', ['shortname' => $nextshortname], 'id ASC', 'id, idnumber, visible');

    foreach ($candidates as $cand) {
        $idnum = (string)($cand->idnumber ?? '');
        // Match strict pattern for our segments:
        $pat = '/^' . preg_quote($nextshortname, '/') . '-' . $repeatindex . '-' . preg_quote($today, '/') . '-(\d{3,})$/';
        if (preg_match($pat, $idnum, $mm)) {
            $s = (int)$mm[1];
            if ($s >= $serial) $serial = $s + 1;
        }
    }

    $serialstr = str_pad((string)$nextnum, 3, '0', STR_PAD_LEFT);



    // 8) Compose final template idnumber.
    $template = $nextshortname . '-' . $repeatindex . '-' . $today . '-' .   $serialstr;

    echo json_encode([
        'success'  => true,
        'template' => $template,
        'debug'    => [
            'topbase'        => $topbase,
            'prefix'         => $prefix,
            'prev_maxnum'    => $maxnum,
            'nextshortname'  => $nextshortname,
            'invisiblecount' => $invisiblecount,
            'repeatindex'    => $repeatindex,
            'date'           => $today,
            'serial'         => $serialstr
        ]
    ]);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
}