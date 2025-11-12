<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage(
        'local_customplugin',
        get_string('pluginname', 'local_customplugin')
    );

    // Toggle enable/disable.
    $settings->add(new admin_setting_configcheckbox(
        'local_customplugin/enabled',
        get_string('enabled', 'local_customplugin'),
        get_string('enabled_desc', 'local_customplugin'),
        1
    ));

    // Example text setting.
    $settings->add(new admin_setting_configtext(
        'local_customplugin/apikey',
        get_string('apikey', 'local_customplugin'),
        get_string('apikey_desc', 'local_customplugin'),
        ''
    ));

    $ADMIN->add('localplugins', $settings);
}
