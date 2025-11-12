<?php

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/course/lib.php');

function create_googlemeet_in_topic(int $courseid, int $topicid, array $meetfields) : stdClass {
    global $DB;

    // 1) Resolve the topic (course_sections) and get its section number
    $sectionrec = $DB->get_record('course_sections', ['id' => $topicid, 'course' => $courseid], '*', MUST_EXIST);
    $sectionnum = (int)$sectionrec->section; // <-- this is what add_moduleinfo() wants

    // 2) Capability checks
    $context  = context_course::instance($courseid);
    require_capability('moodle/course:manageactivities', $context);
    require_capability('mod/googlemeet:addinstance', $context);

    // 3) Lookup module id
    $module = $DB->get_record('modules', ['name' => 'googlemeet'], '*', MUST_EXIST);

    // 4) Build cm data (same keys as mod_form)
    $cmdata = (object)[
        'course'         => $courseid,
        'section'        => $sectionnum,     // place in this topic
        'module'         => $module->id,
        'modulename'     => 'googlemeet',
        'visible'        => 1,
        'showdescription'=> 0,

        'name'           => $meetfields['name'] ?? 'Google Meet',
        'intro'          => $meetfields['intro'] ?? '',
        'introformat'    => FORMAT_HTML,

        // completion example (adjust as needed)
        'completion'     => COMPLETION_TRACKING_MANUAL,
    ];

    // 5) Add plugin-specific fields if you have them
    foreach (['scheduledtime','duration','timezone','meetingcode','allowstudentstart'] as $k) {
        if (array_key_exists($k, $meetfields)) {
            $cmdata->$k = $meetfields[$k];
        }
    }

    // 6) Create it
    return add_moduleinfo($cmdata, get_course($courseid), null);
}

// Example call
$cm = create_googlemeet_in_topic(
    $courseid = 42,
    $topicid  = 1234, // course_sections.id
    [
        'name' => 'Week 3 – Speaking practice',
        'intro' => '<p>Join on time.</p>',
        'scheduledtime' => 1739879400,
        'duration' => 60,
        'allowstudentstart' => 0,
    ]
);
// $cm->id (cmid), $cm->instance (googlemeet instance id) are available here.
