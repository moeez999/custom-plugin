<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Add link to the primary navigation (visible for users with proper capability).
 * @param global_navigation $nav
 */
function local_customplugin_extend_navigation(global_navigation $nav) {
    if (isloggedin() && !isguestuser() && has_capability('local/customplugin:view', context_system::instance())) {
        $url = new moodle_url('/local/customplugin/index.php');
        $node = navigation_node::create(
            get_string('pluginname', 'local_customplugin'),
            $url,
            navigation_node::TYPE_CUSTOM,
            null,
            'local_customplugin',
            new pix_icon('i/siteevent', '')
        );
        $nav->add_node($node);
    }
}

/**
 * Add a "Local plugins → Custom plugin" node in Settings nav (Admin tree).
 * @param settings_navigation $settingsnav
 * @param context $context
 */
function local_customplugin_extend_settings_navigation(settings_navigation $settingsnav, $context) {
    if (!has_capability('local/customplugin:manage', context_system::instance())) {
        return;
    }
    if ($locallink = $settingsnav->find('root', navigation_node::TYPE_SITE_ADMIN)) {
        if ($localplugins = $locallink->find('localplugins', navigation_node::TYPE_CONTAINER)) {
            $localplugins->add(
                get_string('pluginname', 'local_customplugin'),
                new moodle_url('/local/customplugin/index.php'),
                navigation_node::TYPE_SETTING,
                null,
                'local_customplugin_adminlink'
            );
        }
    }
}
