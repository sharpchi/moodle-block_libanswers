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
 * LibAnswers edit form.
 *
 * @package   block_libanswers
 * @author    Mark Sharp <m.sharp@chi.ac.uk>
 * @copyright 2020 University of Chichester {@link https://www.chi.ac.uk}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/libanswers/locallib.php');

/**
 * LibAnswers edit form.
 */
class block_libanswers_edit_form extends block_edit_form {

    /**
     * Form definition for the instances.
     *
     * @param moodle_form $mform
     * @return void
     */
    protected function specific_definition($mform) {

        $widgetoptions = \block_libanswers\widgetoptions();
        if (empty($widgetoptions)) {
            // Show error message with instructions to do the settings correctly.
            $mform->addElement('html', new lang_string('notconfigured', 'block_libanswers'));
        } else {
            $mform->addElement('select', 'config_widgets', new lang_string('widgets', 'block_libanswers'), $widgetoptions);
        }

        $mform->addElement('header', 'weekdays',  get_string('weekdays', 'block_libanswers'));
        $mform->setExpanded('weekdays');

        $mform->addElement('text', 'config_start_time', get_string('starttime', 'block_libanswers'));
        $mform->setDefault('config_start_time', '18:00:00');
        $mform->setType('config_start_time', PARAM_TEXT);
        $mform->addHelpButton('config_start_time', 'starttime', 'block_libanswers');

        $mform->addElement('text', 'config_end_time', get_string('endtime', 'block_libanswers'));
        $mform->setDefault('config_end_time', '08:00:00');
        $mform->setType('config_end_time', PARAM_TEXT);
        $mform->addHelpButton('config_end_time', 'endtime', 'block_libanswers');

        $mform->addElement('header',  'weekends', get_string('weekends', 'block_libanswers'));
        $mform->setExpanded('weekends', true);

        $mform->addElement('text', 'config_start_time_w_end', get_string('starttime', 'block_libanswers'));
        $mform->setDefault('config_start_time_w_end', '18:00:00');
        $mform->setType('config_start_time_w_end', PARAM_TEXT);
        $mform->addHelpButton('config_start_time_w_end', 'starttime', 'block_libanswers');

        $mform->addElement('text', 'config_end_time_w_end', get_string('endtime', 'block_libanswers'));
        $mform->setDefault('config_end_time_w_end', '10:00:00');
        $mform->setType('config_end_time_w_end', PARAM_TEXT);
        $mform->addHelpButton('config_end_time_w_end', 'endtime', 'block_libanswers');
    }
}
