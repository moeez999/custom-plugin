
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

// $PAGE->requires->css(new moodle_url('./style.css?v=' . time()), true);
// $PAGE->requires->css(new moodle_url('./course.css?v=' . time()), true);

// $user = $USER;
// $urlCourse = new moodle_url($CFG->wwwroot .'/course/view.php?id');

// $categoryid = optional_param('categoryid', 0, PARAM_INT); // Category id
// $site = get_site();

// if ($CFG->forcelogin) {
//     require_login();
// }


// $heading = $site->fullname;




// $PAGE->set_pagelayout('coursecategory');
// $PAGE->set_primary_active_tab('home');
// $PAGE->add_body_class('limitedwidth');
// $courserenderer = $PAGE->get_renderer('core', 'course');

// $PAGE->set_heading($heading);
// $content = $courserenderer->course_category($categoryid);

// $PAGE->set_secondary_active_tab('categorymain');

echo $OUTPUT->header();

// Ejecutamos la consulta
// $cursos = $DB->get_records('course', null, 'fullname ASC');

// $cursosArray = [];
// // Mostrar los cursos
// function ordering($fullname) {
//     // Usamos una expresión regular para obtener el número al final del fullname
//     preg_match('/(\d+)$/', $fullname, $coincidencias);
//     return isset($coincidencias[1]) ? (int)$coincidencias[1] : 0;
// }

// // Mostrar los cursos
// foreach ($cursos as $curso) {
//     // Creamos un objeto para almacenar la información del curso
//     $cursoObj = new stdClass();
//     $cursoObj->id = $curso->id;
//     $cursoObj->fullname = $curso->fullname;
//     $cursoObj->category = $curso->category;
//     $cursoObj->summary = $curso->summary;

//     // Verificar si el usuario está inscrito en el curso
//     if (is_enrolled(context_course::instance($curso->id), $user)) {
//         $cursoObj->inscrito = true; // El usuario está inscrito
//     } else {
//         $cursoObj->inscrito = false; // El usuario NO está inscrito
//     }

//     // Añadir el objeto curso al array
//     $cursosArray[] = $cursoObj;
// }

// // Ordenar el array de cursos según el número al final del fullname
// usort($cursosArray, function($a, $b) {
//     return ordering($a->fullname) - ordering($b->fullname);
// });
// if (is_siteadmin($user->id)) {
//     // echo $content; // Aquí va el contenido que quieres mostrar
// } else {
//     echo "";
// }
// function verificarInscripcion($cursos, $id) {
//     $bol = false;  // Inicializamos bol como false para el caso en que no se encuentre el id

//     // Recorremos todos los cursos
//     foreach ($cursos as $curso) {
//         // Verificamos si el fullname del curso coincide con el nombre
//         if ($curso->id == $id) {
//             // Si el curso está inscrito, retornamos true, si no, false
//             if ($curso->inscrito === true) {
//                 $bol = true;  // El usuario está inscrito
//             }
//             return $bol;  // Salimos de la función inmediatamente
//         }
//     } 
//     return $bol;  // Si no encuentra el nombre en los cursos, devuelve false
// }

// function getLink($cursos, $id, $url) {
//     foreach ($cursos as $curso) {
//         if ($curso->id == $id && !empty($curso->inscrito)) {
//             return $url . "=" . $id; // Si está inscrito, devuelve la URL
//         }
//     }
//     return "#"; // Si no está inscrito o no se encontró el curso, devuelve "#"
// }

// if (is_siteadmin($user->id)) {
//     echo $content; // Aquí va el contenido que quieres mostrar
// } else {
//     echo "";
// }
// echo $OUTPUT->skip_link_target(); ?>

<script>
    // function joinClass(url) {
    //     //window.location.href = url;  // Redirect to the sample URL
    //     window.open(url, '_blank');  // Open the URL in a new window or tab
    // }
    // function redirectToRecordings(cohortId, courseid) {
    //     if(courseid && cohortId){
    //         window.location.href = 'sessionRecordings.php?cohortid=' + cohortId + '&courseid=' + courseid;
    //     }
    //  // Ensure both googleMeetId and id (cmid) are included in the URL query string
    // }
</script>

<!-- <div class="noSelect">
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


   </div>
 </div> -->

     <?php require_once("my_lessons_details.php"); ?>
<?php
echo $OUTPUT->footer();
?>


