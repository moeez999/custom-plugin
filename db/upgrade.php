<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Upgrade hook.
 */
function xmldb_local_customplugin_upgrade($oldversion) {
    global $DB;

    // Example template: place future upgrade steps here.
    // if ($oldversion < 2025082101) {
    //     // Upgrade steps...
    //     upgrade_plugin_savepoint(true, 2025082101, 'local', 'customplugin');
    // }

    return true;
}
