<?php

defined('MOODLE_INTERNAL') || die();

$observers = [
    [
        'eventname'   => '\core\event\course_created',
        'callback'    => '\local_autocontent\observer::course_created',
        'includefile' => '/local/autocontent/classes/observer.php'
    ],
];
