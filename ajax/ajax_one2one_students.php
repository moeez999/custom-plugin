<?php
// ajax_one2one_students.php
// /local/adminboard/ajax/create_cohort.php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();

global $DB, $PAGE;

// Fixed course id
$courseid = 24;

// Get teacher id (required)
$teacherid = optional_param('teacherid', 0, PARAM_INT);
if (!$teacherid) {
    header('Content-Type: application/json');
    echo json_encode(['html' => '<div class="one2one-student-list-item" aria-disabled="true"><div class="one2one-student-list-meta"><div class="one2one-student-list-name">No teacher selected</div><div class="one2one-student-list-lessons">—</div></div><div class="one2one-student-list-status">—</div></div>']);
    die;
}

// Teacher record & email
$teacher = $DB->get_record('user', ['id' => $teacherid, 'deleted' => 0, 'suspended' => 0], '*', IGNORE_MISSING);
if (!$teacher || empty($teacher->email)) {
    header('Content-Type: application/json');
    echo json_encode(['html' => '<div class="one2one-student-list-item" aria-disabled="true"><div class="one2one-student-list-meta"><div class="one2one-student-list-name">Teacher not found</div><div class="one2one-student-list-lessons">—</div></div><div class="one2one-student-list-status">—</div></div>']);
    die;
}

$teacheremail = core_text::strtolower(trim($teacher->email));

// Find the “googlemeet” module id
$mod = $DB->get_record('modules', ['name' => 'googlemeet'], 'id', IGNORE_MISSING);
if (!$mod) {
    header('Content-Type: application/json');
    echo json_encode(['html' => '<div class="one2one-student-list-item" aria-disabled="true"><div class="one2one-student-list-meta"><div class="one2one-student-list-name">Google Meet module not found</div><div class="one2one-student-list-lessons">—</div></div><div class="one2one-student-list-status">—</div></div>']);
    die;
}

// Helper to check availability JSON for “profile: email == value”
// Helper to check availability JSON for “profile: email == value” (robust)
$matches_profile_email = function(?string $availabilityjson, string $targetEmailLower) {
    if (empty($availabilityjson)) return false;

    $tree = json_decode($availabilityjson, true);
    if (!is_array($tree)) return false;

    $found = false;

    $walk = function($node) use (&$walk, &$found, $targetEmailLower) {
        if ($found) return;
        if (is_object($node)) $node = (array)$node;
        if (!is_array($node)) return;

        // Leaf condition?
        if (($node['type'] ?? '') === 'profile') {
            // Field name can be 'sf' or 'field'; value can be 'v' or 'value'; op can vary.
            $field = strtolower((string)($node['sf'] ?? $node['field'] ?? ''));
            if ($field === 'email') {
                $val = strtolower(trim((string)($node['v'] ?? $node['value'] ?? '')));
                $op  = strtolower((string)($node['op'] ?? 'isequalto'));
                // Accept common "equals" op spellings.
                $equalsOps = ['isequalto','eq','==','='];
                if ($val !== '' && in_array($op, $equalsOps, true) && $val === $targetEmailLower) {
                    $found = true;
                    return;
                }
            }
        }

        // Recurse into children arrays. Availability JSON commonly nests under 'c' or 'showc';
        // some plugins/tools may use 'children' or 'conditions'.
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

// 1) Find section(s) in course 24 restricted to this teacher by profile-email availability
$sections = $DB->get_records('course_sections', ['course' => $courseid], '', 'id, availability, section');

$teachersectionids = [];
foreach ($sections as $sec) {
    if (!empty($sec->availability) && $matches_profile_email($sec->availability, $teacheremail)) {
        $teachersectionids[] = (int)$sec->id; // course_sections.id
    }
}

if (!$teachersectionids) {
    header('Content-Type: application/json');
    echo json_encode(['html' => '<div class="one2one-student-list-item" aria-disabled="true"><div class="one2one-student-list-meta"><div class="one2one-student-list-name">No restricted section for this teacher</div><div class="one2one-student-list-lessons">—</div></div><div class="one2one-student-list-status">—</div></div>']);
    die;
}

// 2) In those sections, find googlemeet activities (course_modules)
list($insecsql, $insecparams) = $DB->get_in_or_equal($teachersectionids, SQL_PARAMS_NAMED, 's');
$params = $insecparams + ['course' => $courseid, 'module' => $mod->id];

$cms = $DB->get_records_select('course_modules',
    "course = :course AND module = :module AND section $insecsql AND deletioninprogress = 0",
    $params,
    'id ASC',
    'id, instance, section, availability'
);

// 3) For each activity, derive the student email(s) from availability (profile: email == X)
$studentemails = [];
foreach ($cms as $cm) {
    if (empty($cm->availability)) {
        continue;
    }

    $tree = json_decode($cm->availability, true);
    if (!is_array($tree)) {
        continue;
    }

    // Collect ALL profile(email) values in the availability tree
    $collect_emails = function($node, &$out) use (&$collect_emails) {
        if (is_object($node)) $node = (array)$node;
        if (!is_array($node)) return;

        if (($node['type'] ?? '') === 'profile') {
            // Field name can be 'sf' or 'field'; value can be 'v' or 'value'; op may vary.
            $field = strtolower((string)($node['sf'] ?? $node['field'] ?? ''));
            if ($field === 'email') {
                $val = trim((string)($node['v'] ?? $node['value'] ?? ''));
                $op  = strtolower((string)($node['op'] ?? 'isequalto'));
                // Accept common equality ops, but even if op differs we still treat
                // the email as part of this activity's audience.
                $equalsOps = ['isequalto','eq','==','='];
                if ($val !== '' && in_array($op, $equalsOps, true)) {
                    $out[] = core_text::strtolower($val);
                }
            }
        }

        // Recurse into possible children arrays
        foreach (['c','showc','children','conditions'] as $k) {
            if (!empty($node[$k]) && is_array($node[$k])) {
                foreach ($node[$k] as $child) {
                    $collect_emails($child, $out);
                }
            }
        }
    };

    $tmp = [];
    $collect_emails($tree, $tmp);
    if ($tmp) {
        $studentemails = array_merge($studentemails, $tmp);
    }
}

$studentemails = array_values(array_unique($studentemails));
$items_html = '';


if ($studentemails) {
    list($insql, $inparams) = $DB->get_in_or_equal($studentemails, SQL_PARAMS_NAMED, 'e');
    // Fetch users by email (active)
    $users = $DB->get_records_select('user',
        "deleted = 0 AND suspended = 0 AND LOWER(email) $insql",
        array_change_key_case($inparams, CASE_LOWER),
        'firstname ASC, lastname ASC',
        'id, firstname, lastname, picture, imagealt, firstnamephonetic, lastnamephonetic, middlename, alternatename'
    );

    $idx = 0;
    foreach ($users as $u) {
        $pic = new user_picture($u);
        $pic->size = 50;
        $imgurl = $pic->get_url($PAGE)->out(false);
        $name   = fullname($u, true);

        $classes = 'one2one-student-list-item';
        if ($idx === 0) $classes .= ' selected'; // default select first

        $items_html .=
            '<div class="'.$classes.'" data-userid="'.(int)$u->id.'" data-name="'.s($name).'">'.
                '<div class="one2one-student-list-avatar">'.
                    '<img src="'.s($imgurl).'" alt="'.s($name).'" style="width:24px;height:24px;border-radius:50%;object-fit:cover;" />'.
                '</div>'.
                '<div class="one2one-student-list-meta">'.
                    '<div class="one2one-student-list-name">'.format_string($name).'</div>'.
                    '<div class="one2one-student-list-lessons">0 Lessons</div>'.
                '</div>'.
                '<div class="one2one-student-list-status">Subscription</div>'.
            '</div>';
        $idx++;
    }
} 

if ($items_html === '') {
    $items_html =
        '<div class="one2one-student-list-item" aria-disabled="true">'.
            '<div class="one2one-student-list-meta">'.
                '<div class="one2one-student-list-name">No students found for this teacher</div>'.
                '<div class="one2one-student-list-lessons">—</div>'.
            '</div>'.
            '<div class="one2one-student-list-status">—</div>'.
        '</div>';
}

header('Content-Type: application/json');
echo json_encode(['html' => $items_html]);
