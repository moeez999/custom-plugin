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

$PAGE->requires->css(new moodle_url('./style.css?v=' . time()), true);
$PAGE->requires->css(new moodle_url('./course.css?v=' . time()), true);

$user = $USER;
$urlCourse = new moodle_url($CFG->wwwroot .'/course/view.php?id');

$categoryid = optional_param('categoryid', 0, PARAM_INT); // Category id
$site = get_site();

if ($CFG->forcelogin) {
    require_login();
}


$heading = $site->fullname;


if ($categoryid) {
    $category = core_course_category::get($categoryid); // This will validate access.
    $PAGE->set_category_by_id($categoryid);
    $PAGE->set_url(new moodle_url('/course/index.php', array('categoryid' => $categoryid)));
    $PAGE->set_pagetype('course-index-category');
    $heading = $category->get_formatted_name();
} else if ($category = core_course_category::user_top()) {
    // Check if there is only one top-level category, if so use that.
    $categoryid = $category->id;
    $PAGE->set_url('/course/index.php');
    if ($category->is_uservisible() && $categoryid) {
        $PAGE->set_category_by_id($categoryid);
        $PAGE->set_context($category->get_context());
        if (!core_course_category::is_simple_site()) {
            $PAGE->set_url(new moodle_url('/course/index.php', array('categoryid' => $categoryid)));
            $heading = $category->get_formatted_name();
        }
    } else {
        $PAGE->set_context(context_system::instance());
    }
    $PAGE->set_pagetype('course-index-category');
} else {
    // throw new moodle_exception('cannotviewcategory');
}

$PAGE->set_pagelayout('coursecategory');
$PAGE->set_primary_active_tab('home');
$PAGE->add_body_class('limitedwidth');
$courserenderer = $PAGE->get_renderer('core', 'course');

$PAGE->set_heading($heading);
$content = $courserenderer->course_category($categoryid);

$PAGE->set_secondary_active_tab('categorymain');

echo $OUTPUT->header();

// Ejecutamos la consulta
$cursos = $DB->get_records('course', null, 'fullname ASC');

$cursosArray = [];
// Mostrar los cursos
function ordering($fullname) {
    // Usamos una expresión regular para obtener el número al final del fullname
    preg_match('/(\d+)$/', $fullname, $coincidencias);
    return isset($coincidencias[1]) ? (int)$coincidencias[1] : 0;
}

// Mostrar los cursos
foreach ($cursos as $curso) {
    // Creamos un objeto para almacenar la información del curso
    $cursoObj = new stdClass();
    $cursoObj->id = $curso->id;
    $cursoObj->fullname = $curso->fullname;
    $cursoObj->category = $curso->category;
    $cursoObj->summary = $curso->summary;

    // Verificar si el usuario está inscrito en el curso
    if (is_enrolled(context_course::instance($curso->id), $user)) {
        $cursoObj->inscrito = true; // El usuario está inscrito
    } else {
        $cursoObj->inscrito = false; // El usuario NO está inscrito
    }

    // Añadir el objeto curso al array
    $cursosArray[] = $cursoObj;
}

// Ordenar el array de cursos según el número al final del fullname
usort($cursosArray, function($a, $b) {
    return ordering($a->fullname) - ordering($b->fullname);
});
if (is_siteadmin($user->id)) {
    // echo $content; // Aquí va el contenido que quieres mostrar
} else {
    echo "";
}
function verificarInscripcion($cursos, $id) {
    $bol = false;  // Inicializamos bol como false para el caso en que no se encuentre el id

    // Recorremos todos los cursos
    foreach ($cursos as $curso) {
        // Verificamos si el fullname del curso coincide con el nombre
        if ($curso->id == $id) {
            // Si el curso está inscrito, retornamos true, si no, false
            if ($curso->inscrito === true) {
                $bol = true;  // El usuario está inscrito
            }
            return $bol;  // Salimos de la función inmediatamente
        }
    } 
    return $bol;  // Si no encuentra el nombre en los cursos, devuelve false
}

function getLink($cursos, $id, $url) {
    foreach ($cursos as $curso) {
        if ($curso->id == $id && !empty($curso->inscrito)) {
            return $url . "=" . $id; // Si está inscrito, devuelve la URL
        }
    }
    return "#"; // Si no está inscrito o no se encontró el curso, devuelve "#"
}

if (is_siteadmin($user->id)) {
    echo $content; // Aquí va el contenido que quieres mostrar
} else {
    echo "";
}
echo $OUTPUT->skip_link_target(); ?>

<script>
    function joinClass(url) {
        //window.location.href = url;  // Redirect to the sample URL
        window.open(url, '_blank');  // Open the URL in a new window or tab
    }
    function redirectToRecordings(cohortId, courseid) {
        if(courseid && cohortId){
            window.location.href = 'sessionRecordings.php?cohortid=' + cohortId + '&courseid=' + courseid;
        }
     // Ensure both googleMeetId and id (cmid) are included in the URL query string
    }
</script>
<div class="noSelect">
    <div class="wrapper"> 

    <header>
        <ul>
        <li><a href="" class="active">Home</a></li>
        <li><a href="">Messages</a></li>
        <li><a href="">My lessons</a></li>
        <li><a href="">Learn</a></li>
        <li><a href="">Settings</a></li>
        </ul>
        
        <div class="findTutors_and_findGroups">
        <a href="">Find Tutors</a>
        <a href="">Find Groups</a>
        </div>
    </header>

    <section class="page_top">
        <div class="center_content">
            <?php
            
            
            if (isloggedin()) {
                if (!is_siteadmin($user->id)) {

                    global $DB;
                
                    // Fetch the course details using the idnumber.
                    $course = $DB->get_record('course', ['idnumber' => 'CR001'], '*');
                
                    // SQL query to fetch the cohort names the user belongs to
                    $sql = "SELECT c.id, c.name
                            FROM {cohort} c
                            JOIN {cohort_members} cm ON cm.cohortid = c.id
                            WHERE cm.userid = :userid";
                
                    // Execute the query and fetch the results
                    $cohorts = $DB->get_records_sql($sql, ['userid' => $user->id]);
                
                
                    foreach ($cohorts as $cohort) {
                        $cohortid = $cohort->id;
                    }
                    
                
                    // Fetch all sections in the course
                $sections = $DB->get_records('course_sections', ['course' => $course->id], 'section ASC');
                
                // Loop through sections to find those restricted to the cohort
                $allowed_sections = [];
                foreach ($sections as $section) {
                    if (!empty($section->availability)) {
                        // Decode the availability JSON
                        $availability = json_decode($section->availability, true);
                
                        // Check if there is a cohort restriction
                        if (isset($availability['c']) && is_array($availability['c'])) {
                            foreach ($availability['c'] as $condition) {
                                if ($condition['type'] === 'cohort' && $condition['id'] == $cohortid) {
                                    $allowed_sections[] = $section;
                                    break;
                                }
                            }
                        }
                    }
                }
                
                $googleMeetActivities = []; // Array to store Google Meet activities with their upcoming schedules
                
                if (!empty($allowed_sections)) {
                    //echo "Topics allowed for cohort ID $cohortid:<br>";
                
                    foreach ($allowed_sections as $section) {
                        //echo "Section: " . $section->section . " - " . $section->name . "<br>";
                
                        // Fetch all modules in this section
                        $modules = $DB->get_records('course_modules', ['section' => $section->id]);
                
                        if (!empty($modules)) {
                            //echo "Activities in this section:<br>";
                
                            foreach ($modules as $module) {
                                // Get module information from modinfo
                                $modinfo = $DB->get_record('modules', ['id' => $module->module]);
                
                                if ($modinfo && $modinfo->name === 'googlemeet') { // Check if it's a Google Meet module
                                    // Fetch Google Meet activity details
                                    $googleMeetActivity = $DB->get_record('googlemeet', ['id' => $module->instance]);
                                    if ($googleMeetActivity) {
                                        $schedules[] = [
                                            'starthour' => $googleMeetActivity->starthour,
                                            'startminute' => $googleMeetActivity->startminute,
                                            'days' => $googleMeetActivity->days,
                                        ];
                
                                        // Fetch the upcoming schedule for this Google Meet activity
                                        $sql = "SELECT * 
                                                FROM {googlemeet_events}
                                                WHERE googlemeetid = :googlemeetid 
                                                AND eventdate > :currenttime
                                                ORDER BY eventdate ASC
                                                LIMIT 1";
                                        $params = [
                                            'googlemeetid' => $googleMeetActivity->id,
                                            'currenttime' => time()
                                        ];
                                        $upcomingSchedule = $DB->get_record_sql($sql, $params);
                
                                        // Store activity details and the upcoming schedule
                                        $googleMeetActivities[] = (object) [
                                            'name' => $googleMeetActivity->name,
                                            'section' => $section->section,
                                            'module_id' => $module->id,
                                            'upcoming_schedule' => $upcomingSchedule
                                        ];
                
                                        //echo "- Google Meet: " . $googleMeetActivity->name . "<br>";
                                        if ($upcomingSchedule) {
                                            //echo "-- Upcoming Event Date: " . date('Y-m-d H:i:s', $upcomingSchedule->eventdate) . "<br>";
                                        // echo "-- Duration: " . $upcomingSchedule->duration . " minutes<br>";
                                        } else {
                                            //echo "-- No upcoming schedule found.<br>";
                                        }
                                    }
                                }
                            }
                        } else {
                            //echo "No activities found in this section.<br>";
                        }
                    }
                
                    // Final Output
                    if (!empty($googleMeetActivities)) {
                        $mostUpcomingSchedule = null;
                        //echo "<br>Final Google Meet Activities with Upcoming Schedules:<br>";
                        foreach ($googleMeetActivities as $activity) {
                            //echo "- " . $activity->name . " (Section: " . $activity->section . ")<br>";
                    
                            if ($activity->upcoming_schedule) {
                
                            // Directly compare eventdate for each activity to find the most upcoming one
                            if (!$mostUpcomingSchedule || $activity->upcoming_schedule->eventdate < $mostUpcomingSchedule->eventdate) {
                                $d = $activity->upcoming_schedule->eventdate;
                                $s = $mostUpcomingSchedule?->eventdate ?? null;
                                $mostUpcomingSchedule = $activity->upcoming_schedule;
                            }
                            } else {
                                //echo "-- No upcoming schedule found.<br>";
                            }
                        }
                    } 
                } else {
                    //echo "No topics are restricted to cohort ID $cohortid in this course.";
                }
                
                // Fetch the Google Meet activity record
                if($mostUpcomingSchedule){
                    $googleMeet = $DB->get_record('googlemeet', ['id' => $mostUpcomingSchedule->googlemeetid], '*', MUST_EXIST);
                
                }
                // Extract the URL from the record
                $googleMeetURL = $googleMeet->url;
                $dayOrder = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
                // Master array to store sorted data across schedules
                $allDaysWithHours = [];

                // Collect available days and their timings
                foreach ($schedules as $schedule) {
                    // Convert starthour and startminute to a 12-hour format with AM/PM
                    $hour24 = $schedule['starthour'];
                    $minute = str_pad($schedule['startminute'], 2, "0", STR_PAD_LEFT); // Ensure 2 digits for minutes
                    $formattedHour = date("g:i A", strtotime("$hour24:$minute"));

                    // Decode the JSON data in 'days'
                    $days = json_decode($schedule['days'], true); // Decoded as associative array

                    // Sort and add available days to the master array
                    foreach ($dayOrder as $day) {
                        if (isset($days[$day]) && $days[$day] === "1") {
                            $allDaysWithHours[$day][] = $formattedHour; // Group timings by day
                        }
                    }
                }

                // Ensure all days are present and in sorted order
                foreach ($dayOrder as $day) {
                    if (!isset($allDaysWithHours[$day])) {
                        $allDaysWithHours[$day] = []; // Add empty entry for non-available days
                    }
                }
                ?> 
                <div class="rightSide">
                    <div class="row01">
                    <h1 class="selectGroup_titleChange">Your 1 on 1 starts soon</h1>
                    <div href="" class="whichTutor_open">
                        <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="40"
                        height="40"
                        viewBox="0 0 40 40"
                        fill="none"
                        >
                        <path
                            d="M14.8295 9.5C14.64 9.5 14.4582 9.5753 14.3241 9.70935C14.1901 9.84339 14.1148 10.0252 14.1148 10.2148V11.3277H11.8475C11.2792 11.3293 10.7347 11.5557 10.3328 11.9575C9.93088 12.3592 9.7043 12.9037 9.70251 13.472V15.602H29.7178V13.472C29.7162 12.9037 29.4898 12.3592 29.088 11.9573C28.6863 11.5554 28.1418 11.3288 27.5735 11.327H25.3063V10.2155C25.3063 10.1216 25.2878 10.0287 25.2519 9.94198C25.2159 9.85526 25.1633 9.77647 25.0969 9.7101C25.0305 9.64372 24.9518 9.59108 24.865 9.55516C24.7783 9.51924 24.6854 9.50075 24.5915 9.50075C24.4977 9.50075 24.4047 9.51924 24.318 9.55516C24.2313 9.59108 24.1525 9.64372 24.0861 9.7101C24.0197 9.77647 23.9671 9.85526 23.9312 9.94198C23.8953 10.0287 23.8768 10.1216 23.8768 10.2155V11.3285H15.5443V10.2148C15.5443 10.1209 15.5258 10.0279 15.4899 9.94123C15.4539 9.85451 15.4013 9.77572 15.3349 9.70935C15.2685 9.64297 15.1898 9.59033 15.103 9.55441C15.0163 9.51849 14.9234 9.5 14.8295 9.5ZM25.5005 19.4705C27.1228 19.4705 28.6025 20.0997 29.7178 21.1145V17.033H9.70326V26.483C9.70505 27.0513 9.93163 27.5957 10.3335 27.9975C10.7354 28.3993 11.28 28.6257 11.8483 28.6273H20.0038C19.5181 27.7268 19.265 26.7193 19.2673 25.6962C19.2673 22.265 22.0625 19.4705 25.5005 19.4705Z"
                            fill="black"
                        />
                        <path
                            d="M25.5005 30.5C28.145 30.5 30.2968 28.3482 30.2968 25.6962C30.2954 24.4246 29.7896 23.2055 28.8905 22.3063C27.9913 21.4071 26.7721 20.9014 25.5005 20.9C22.8485 20.9 20.6968 23.0517 20.6968 25.6962C20.697 26.9702 21.2031 28.192 22.104 29.0928C23.0048 29.9936 24.2266 30.4998 25.5005 30.5ZM24.071 24.9815H24.7858V24.2667C24.7855 24.1728 24.8038 24.0797 24.8396 23.9929C24.8754 23.906 24.928 23.8271 24.9945 23.7607C25.0609 23.6942 25.1398 23.6416 25.2267 23.6058C25.3135 23.57 25.4066 23.5517 25.5005 23.552C25.8935 23.552 26.2153 23.8737 26.2153 24.2667V24.9815H26.93C27.323 24.9815 27.6448 25.3032 27.6448 25.6962C27.6451 25.7902 27.6268 25.8833 27.591 25.9701C27.5552 26.057 27.5025 26.1359 27.4361 26.2023C27.3697 26.2687 27.2908 26.3214 27.2039 26.3572C27.117 26.393 27.024 26.4113 26.93 26.411H26.2153V27.1257C26.2156 27.2197 26.1973 27.3128 26.1615 27.3996C26.1257 27.4865 26.073 27.5654 26.0066 27.6318C25.9402 27.6982 25.8613 27.7509 25.7744 27.7867C25.6875 27.8225 25.5945 27.8408 25.5005 27.8405C25.4064 27.8414 25.3131 27.8235 25.2259 27.7879C25.1388 27.7523 25.0597 27.6997 24.9931 27.6332C24.9266 27.5666 24.8739 27.4875 24.8383 27.4003C24.8027 27.3132 24.7849 27.2199 24.7858 27.1257V26.411H24.071C23.9769 26.4119 23.8836 26.394 23.7964 26.3584C23.7093 26.3228 23.6302 26.2702 23.5636 26.2037C23.4971 26.1371 23.4444 26.058 23.4088 25.9708C23.3732 25.8837 23.3554 25.7904 23.3563 25.6962C23.356 25.6023 23.3743 25.5092 23.4101 25.4224C23.4459 25.3355 23.4985 25.2566 23.565 25.1902C23.6314 25.1237 23.7103 25.0711 23.7972 25.0353C23.884 24.9995 23.9771 24.9812 24.071 24.9815Z"
                            fill="black"
                        />
                        </svg>
                    </div>
                    </div>

                    <div class="row02">
                    <div class="row02_leftSide">
                        <div class="imageContainer">
                        <img
                            src="../img/cour/1.png"
                            alt=""
                            class="selectGroup_changeImage"
                        />
                        </div>

                        <div class="col02 selectGroup_changeContent">
                        <h5>Today</h5>
                        <h1>Monday, 09:30 - 10:20</h1>
                        <p>Weekly English with <?php echo $cohort->name; ?></p>
                        </div>
                    </div>

                    <div class="row02_rightSide">
                        <div class="threeDots userOptionOpen">
                        <svg
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M3 10H7V14H3V10ZM10 10H14V14H10V10ZM21 10H17V14H21V10Z"
                            fill="#121117"
                            />
                        </svg>
                        </div>
                        
                        <?php if ($googleMeet) { ?>
                            <button class="joinLesson"  onclick='joinClass(<?php echo json_encode($googleMeetURL) ?>)'>Join Lesson</button>
                        <?php } ?>
                    </div>
                    </div>

                    <div class="row03">
                    <div class="top">
                        <h5>Up Next</h5>
                        <a href="">See all (12)</a>
                    </div>

                    <div class="bottom">
                        <div class="card">
                        <div class="content">
                            <div class="card_leftSide selectGroupBTN">
                            <p>January 15</p>
                            <h1>Wednesday, 5:00 - 6:00</h1>
                            <p class="shortText">Group Class with Florida 1</p>
                            </div>

                            <div class="threeDots userOptionOpen">
                            <svg
                                width="18"
                                height="4"
                                viewBox="0 0 18 4"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M0 0H4V4H0V0ZM7 0H11V4H7V0ZM18 0H14V4H18V0Z"
                                fill="#121117"
                                />
                            </svg>
                            </div>
                        </div>
                        <div class="underline"></div>
                        </div>
                        <div class="card">
                        <div class="content">
                            <div class="card_leftSide">
                            <p>January 17</p>
                            <h1>Friday, 4:00 - 5:50</h1>
                            <div class="shortDetail">
                                <p>1 on 1</p>
                                <div class="userShortDetail">
                                <div class="imageContainer">
                                    <img src="../img/cour/1.png" alt="" />
                                </div>
                                <p>Dinela</p>
                                </div>
                            </div>
                            </div>

                            <div class="threeDots userOptionOpen">
                            <svg
                                width="18"
                                height="4"
                                viewBox="0 0 18 4"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M0 0H4V4H0V0ZM7 0H11V4H7V0ZM18 0H14V4H18V0Z"
                                fill="#121117"
                                />
                            </svg>
                            </div>
                        </div>
                        <div class="underline"></div>
                        </div>
                        <div class="card">
                        <div class="content">
                            <div class="card_leftSide">
                            <p>January 15</p>
                            <h1>Wednesday, 16:00-16:50</h1>
                            <div class="shortDetail">
                                <p>Arabic with</p>
                                <div class="userShortDetail">
                                <div class="imageContainer">
                                    <img src="../img/cour/1.png" alt="" />
                                </div>
                                <p>Dinela</p>
                                </div>
                            </div>
                            </div>

                            <div class="threeDots userOptionOpen">
                            <svg
                                width="18"
                                height="4"
                                viewBox="0 0 18 4"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M0 0H4V4H0V0ZM7 0H11V4H7V0ZM18 0H14V4H18V0Z"
                                fill="#121117"
                                />
                            </svg>
                            </div>
                        </div>
                        <div class="underline"></div>
                        </div>
                        <div class="card">
                        <div class="content">
                            <div class="card_leftSide">
                            <p>January 15</p>
                            <h1>Wednesday, 16:00-16:50</h1>
                            <div class="shortDetail">
                                <p>Arabic with</p>
                                <div class="userShortDetail">
                                <div class="imageContainer">
                                    <img src="../img/cour/1.png" alt="" />
                                </div>
                                <p>Dinela</p>
                                </div>
                            </div>
                            </div>

                            <div class="threeDots userOptionOpen">
                            <svg
                                width="18"
                                height="4"
                                viewBox="0 0 18 4"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M0 0H4V4H0V0ZM7 0H11V4H7V0ZM18 0H14V4H18V0Z"
                                fill="#121117"
                                />
                            </svg>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

                <?php
                // Left COntent
                ?>
                <div class="leftSide">
                    <h1 class="heading">My group Classes</h1>

                    <div class="cards">
                    <a href="" class="card">
                        <p><span class="desktop">Current</span> Topic</p>
                        <h2>
                        <span class="desktop">Possessive adjectives & nouns</span>
                        <span class="mobile">Adverb</span>
                        </h2>
                    </a>
                    <a href="" class="card">
                        <p>
                        <span class="desktop">Task due in 5 days</span>
                        <span class="mobile">HomeWork</span>
                        </p>
                        <h2>
                        <span
                            ><span class="desktop">myhomewok.pdf</span>
                            <span class="mobile">work.pdf</span></span
                        >
                        <svg
                            width="25"
                            height="25"
                            viewBox="0 0 25 25"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <rect
                            x="0.706897"
                            y="0.706897"
                            width="23.5862"
                            height="23.5862"
                            rx="11.7931"
                            stroke="#001CB1"
                            stroke-width="0.413793"
                            />
                            <path
                            d="M6.75178 11.8873C6.46612 11.8881 6.18653 11.9698 5.94534 12.1228C5.70416 12.2759 5.51124 12.4942 5.38891 12.7523C5.26657 13.0104 5.21983 13.2979 5.25408 13.5815C5.28833 13.8651 5.40217 14.1333 5.58244 14.3549L9.4253 19.0624C9.56232 19.2325 9.73795 19.3675 9.93761 19.4561C10.1373 19.5447 10.3552 19.5844 10.5733 19.5719C11.0397 19.5469 11.4608 19.2974 11.7293 18.8871L19.7119 6.03112C19.7133 6.02897 19.7146 6.02685 19.716 6.02475C19.7909 5.90975 19.7666 5.68185 19.612 5.53867C19.5696 5.49936 19.5195 5.46915 19.4649 5.44992C19.4103 5.43068 19.3524 5.42282 19.2946 5.42683C19.2369 5.43083 19.1806 5.44661 19.1292 5.4732C19.0778 5.49979 19.0324 5.53662 18.9957 5.58142C18.9929 5.58495 18.9899 5.58842 18.9869 5.59183L10.9363 14.6878C10.9057 14.7224 10.8685 14.7506 10.8269 14.7707C10.7852 14.7908 10.74 14.8024 10.6939 14.8049C10.6477 14.8074 10.6015 14.8007 10.558 14.7852C10.5145 14.7697 10.4744 14.7457 10.4402 14.7146L7.76841 12.2832C7.49092 12.0288 7.12823 11.8876 6.75178 11.8873Z"
                            fill="#001CB1"
                            />
                        </svg>
                        </h2>
                    </a>
                    <a href="" class="card">
                        <p><span class="desktop">See</span> Slides</p>
                        <svg
                        width="34"
                        height="33"
                        viewBox="0 0 34 33"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        >
                        <g clip-path="url(#clip0_2444_52879)">
                            <path
                            d="M28.661 9.19295V30.5716C28.661 31.72 27.7271 32.6539 26.5787 32.6539H7.33917C6.19073 32.6539 5.25684 31.72 5.25684 30.5716V2.42852C5.25684 1.28009 6.19073 0.346191 7.33917 0.346191H19.8079L28.661 9.19295Z"
                            fill="#001CB1"
                            />
                            <path
                            d="M21.2656 15.0803H12.7785C11.9897 15.0803 11.3524 15.7176 11.3524 16.5064V24.9935C11.3524 25.7822 11.9897 26.4195 12.7785 26.4195H21.2656C22.0543 26.4195 22.6917 25.7822 22.6917 24.9935V16.5001C22.6917 15.7176 22.0543 15.0803 21.2656 15.0803ZM21.2214 23.8829H12.829V18.1722H21.2214V23.8829Z"
                            fill="white"
                            />
                            <path
                            d="M21.0132 8.82699L28.6547 15.0172V9.19928L24.3197 6.68787L21.0132 8.82699Z"
                            fill="black"
                            fill-opacity="0.0980392"
                            />
                            <path
                            d="M28.6989 9.19298H21.9345C20.7861 9.19298 19.8522 8.25908 19.8522 7.11064V0.346222L28.6989 9.19298Z"
                            fill="#9E87FA"
                            />
                        </g>
                        <defs>
                            <clipPath id="clip0_2444_52879">
                            <rect
                                width="32.3077"
                                height="32.3077"
                                fill="white"
                                transform="translate(0.846191 0.346161)"
                            />
                            </clipPath>
                        </defs>
                        </svg>
                    </a>

                    <div style="cursor:pointer" onclick="redirectToRecordings(<?php echo $cohortid; ?>, <?php echo $course->id; ?>)" class="card">
                        <p><span class="desktop">Previous</span> Recording</p>
                        <svg
                        width="32"
                        height="19"
                        viewBox="0 0 32 19"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        >
                        <path
                            d="M18.1007 0.0995483H3.50109C1.57549 0.0995483 0 1.67504 0 3.60064V15.3993C0 17.3249 1.57549 18.9004 3.50109 18.9004H18.1007C20.0263 18.9004 21.6017 17.3249 21.6017 15.3993V3.60064C21.6017 1.64003 20.0263 0.0995483 18.1007 0.0995483ZM29.4092 2.02515C29.1991 2.06016 28.9891 2.16519 28.814 2.27023L23.3523 5.42121V13.5437L28.849 16.6947C29.8643 17.2899 31.1247 16.9398 31.7199 15.9245C31.895 15.6094 32 15.2593 32 14.8742V4.05578C32 2.76038 30.7746 1.71005 29.4092 2.02515Z"
                            fill="#001CB1"
                        />
                        </svg>
                    </div>
                    </div>

                    <div class="schedule">
                    <h4>Schedule</h4>
                        <div class="row"> 

                        <?php
                        // Generate the final HTML output in sorted order
                        foreach ($dayOrder as $day) {
                            if (!empty($allDaysWithHours[$day])) {
                                // Print the day with all associated timings
                                foreach ($allDaysWithHours[$day] as $hour) {
                                    echo "
                                    <div class='date'>
                                        <div class='day'><h1>" . htmlspecialchars($day) . "</h1></div>
                                        <p>" . htmlspecialchars($hour) . "</p>
                                    </div>
                                    ";
                                }
                            } else {
                                
                                echo "
                                <div class='date'>
                                    <div class='day gray'><h1>" . htmlspecialchars($day) . "</h1></div>
                                </div>
                                ";
                            }
                        }
                        ?> 
                        </div>
                    </div>
                </div>
                <?php
                }else{
                    $googleMeetURL="";
                }
            }
            ?> 
        </div>
    </section>
    
    <?php require_once("my_lessons_details.php"); ?>
   </div>
 </div>


<?php
echo $OUTPUT->footer();
?>
