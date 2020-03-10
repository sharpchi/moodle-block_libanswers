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
 * LibAnswers block class.
 *
 * @package    block_libanswers
 * @author    Mark Sharp <m.sharp@chi.ac.uk>
 * @copyright 2020 University of Chichester {@link www.chi.ac.uk}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

/**
 * LibAnswers class.
 */
class block_libanswers extends block_base {

    /**
     * Sets the title for the block.
     */
    function init() {
        $this->title = get_string('pluginname', 'block_libanswers');
    }


    /**
     * Returns the content html for the block.
     */
    function get_content() {

        if ($this->content !== null) {
            return $this->content;
        }

        $config = get_config('block_libanswers');
        
        if (!isset($config->iid) || $config->iid == 0) {
            return $this->content;
        }

        if (!isset($this->config->widgets)) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '';

        $now = time();
        $day_name = date('l', $now);

        // Week or weekend.
        if ($day_name == 'Saturday' || $day_name == 'Sunday') {  // Weekend.
            $start =  strtotime($this->config->start_time_w_end);
            $end = strtotime($this->config->end_time_w_end);
        } else {   // Week days.
            $start =  strtotime($this->config->start_time);
            $end = strtotime($this->config->end_time);
        }

        if ($now < $end || $now > $start) {
            $widget = explode('_', $this->config->widgets);
            if (count($widget) !== 2) {
                return $this->content;
            }
            $region = $widget[0];
            $hash = $widget[1];
            $this->content->text .=    '
            <div class="libchat-container">
                <div id="libchat_' . $hash . '"></div>
                <script src="https://' . $region . '.libanswers.com/load_chat.php?hash=' . $hash . '"></script>
            </div>';

        } else {
            if ($config->hideinhours) {
                $this->content = null;
            } else {
                $this->content->text .=  get_string('serviceoffline', 'block_libanswers');
            }
        }

        return $this->content;
    }

    /**
     * Where can the block be used.
     */
    public function applicable_formats() {
        return array('all' => false,
                     'site' => false,
                     'site-index' => false,
                     'course-view' => true,
                     'course-view-social' => false,
                     'mod' => false,
                     'mod-quiz' => false);
    }

    public function instance_allow_multiple() {
        return true;
    }

    function has_config() {
        return true;
    }

    function user_can_edit() {
        global $USER;

        if (!has_capability('block/libanswers:addinstance', $this->context)) {
            return false;
        }

        if (has_capability('moodle/block:edit', $this->context)) {
            return true;
        }

        // The blocks in My Moodle are a special case.  We want them to inherit from the user context.
        if (!empty($USER->id)
            && $this->instance->parentcontextid == $this->page->context->id   // Block belongs to this page
            && $this->page->context->contextlevel == CONTEXT_USER             // Page belongs to a user
            && $this->page->context->instanceid == $USER->id) {               // Page belongs to this user
            return has_capability('moodle/my:manageblocks', $this->page->context);
        }

        return false;
    }

    /**
     * Allows the block class to have a say in the user's ability to create new instances of this block.
     * The framework has first say in whether this will be allowed (e.g., no adding allowed unless in edit mode)
     * but if the framework does allow it, the block can still decide to refuse.
     * This function has access to the complete page object, the creation related to which is being determined.
     *
     * @param moodle_page $page
     * @return boolean
     */
    function user_can_addto($page) {
        global $USER;

        $canaddto = parent::user_can_addto($page);

        $limitto = get_config('block_libanswers', 'limitto');
        if (!empty($limitto)) {
            $courseids = explode(',', $limitto);
            if (!in_array($page->course->id, $courseids)) {
                return false;
            }
        }
        return $canaddto;
    }

}
