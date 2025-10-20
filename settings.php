<?php

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    // Create a settings page under: Site administration > Plugins > Local plugins
    $settings = new admin_settingpage('local_autocontent', get_string('pluginname', 'local_autocontent'));

    // Welcome Section HTML
    $settings->add(new admin_setting_configtextarea(
        'local_autocontent/welcomehtml',
        'Welcome Section HTML',
        'Default HTML for Section 0 of every new course.',
        '<h2>Welcome to your new course</h2><p>Insert intro here...</p>'
    ));

    // Module Content Template HTML
    $settings->add(new admin_setting_configtextarea(
        'local_autocontent/pagehtml',
        'Module Content Template HTML',
        'HTML inserted inside the default sample Page activity.',
        '<h2>Module Content Template</h2><p>Insert content structure here...</p>'
    ));

    // Register settings page
    $ADMIN->add('localplugins', $settings);
}
