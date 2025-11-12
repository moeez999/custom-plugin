<?php
require(__DIR__ . '/../../config.php');

require_login();
$context = context_system::instance();
require_capability('local/customplugin:view', $context);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/customplugin/index.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('pluginname', 'local_customplugin'));
$PAGE->set_heading(get_string('pluginname', 'local_customplugin'));

// Load plugin CSS (local plugin styles aren't auto-included).
$PAGE->requires->css(new moodle_url('/local/customplugin/styles.css'));

// Prepare renderable/templatable data.
$output = $PAGE->get_renderer('core');
$renderable = new \local_customplugin\output\main();
echo $output->header();
echo $output->render($renderable);
echo $output->footer();
