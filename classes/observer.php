<?php

namespace local_autocontent;

defined('MOODLE_INTERNAL') || die();

class observer {

    public static function course_created(\core\event\course_created $event): void {
        global $DB, $CFG;

        require_once($CFG->dirroot . '/course/lib.php');
        require_once($CFG->dirroot . '/course/modlib.php');

        // Get the course
        $course = $event->get_record_snapshot('course', $event->objectid);

        // Ensure section 0 exists
        course_create_sections_if_missing($course->id, [0]);

        // ─────────────────────────────────────────────
        // 1) INSERT WELCOME CONTENT INTO SECTION SUMMARY
        // ─────────────────────────────────────────────
        $welcomehtml = (string) get_config('local_autocontent', 'welcomehtml');

        if ($section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => 0])) {
            $section->summary        = $welcomehtml;
            $section->summaryformat  = 1; // HTML
            $DB->update_record('course_sections', $section);
        }

        // ─────────────────────────────────────────────
        // 2) INSERT MODULE CONTENT TEMPLATE PAGE
        // ─────────────────────────────────────────────
        $pagehtml = (string) get_config('local_autocontent', 'pagehtml');

        if (!empty($pagehtml)) {
            $pagedata = new \stdClass();
            $pagedata->course        = $course->id;
            $pagedata->section       = 0; // Section 0
            $pagedata->visible       = 1;
            $pagedata->modulename    = 'page';
            $pagedata->module        = $DB->get_field('modules', 'id', ['name' => 'page'], MUST_EXIST);
            $pagedata->coursemodule  = 0;
            $pagedata->name          = 'Module Content Template';
            $pagedata->intro         = '';
            $pagedata->introformat   = 1;
            $pagedata->content       = $pagehtml;
            $pagedata->contentformat = 1;

            add_moduleinfo($pagedata, $course, null);
        }
    }
}
