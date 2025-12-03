<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Lists the course categories
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package course
 */

require_once("../../config.php");
require_once($CFG->dirroot. '/course/lib.php');

// -----------------------------
// Helper Functions
// -----------------------------

function is_only_student_role($userid) {
    global $DB;

    $studentroleid = 5;
    $totalRoles = $DB->count_records('role_assignments', ['userid' => $userid]);
    $studentRoles = $DB->count_records('role_assignments', [
        'userid' => $userid,
        'roleid' => $studentroleid
    ]);

    return ($studentRoles > 0 && $totalRoles == $studentRoles);
}

function is_cohort_teacher_exist_only($userid) {
    global $DB;

    $sql = "SELECT 1
            FROM {cohort}
            WHERE cohortmainteacher = :uid1
               OR cohortguideteacher = :uid2";

    return $DB->record_exists_sql($sql, [
        'uid1' => (int)$userid,
        'uid2' => (int)$userid
    ]);
}

// -----------------------------
// Detect USER Role
// -----------------------------

$role = 'student'; // default

if (is_siteadmin($USER)) {
    $role = 'admin';
} else {
    $context = context_system::instance();

    if (user_has_role_assignment($USER->id, 1, $context->id)) {
        $role = 'manager';
    } else if (is_cohort_teacher_exist_only($USER->id)) {
        $role = 'teacher';
    } else if (is_only_student_only($USER->id)) {
        $role = 'student';
    }
}

// Store in localStorage
$PAGE->requires->js_init_code("
    localStorage.setItem('role', '{$role}');
");

// Store in localStorage
$PAGE->requires->js_init_code("
    localStorage.setItem('teacherId', '{$USER->id}');
");

echo $OUTPUT->header();
?>

<?php require_once("calendar_admin_details.php");?>

<?php
echo $OUTPUT->footer();
?>