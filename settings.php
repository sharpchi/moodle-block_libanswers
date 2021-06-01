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
 * Settings for LibAnswers widget.
 *
 * @package    block_libanswers
 * @author    Mark Sharp <m.sharp@chi.ac.uk>
 * @copyright 2020 University of Chichester {@link https://www.chi.ac.uk}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$settings->add(new admin_setting_configtext('block_libanswers/iid', new lang_string('iid', 'block_libanswers'),
            new lang_string('iid_help', 'block_libanswers'), 0, PARAM_INT));

$settings->add(new admin_setting_configtext('block_libanswers/libanswersurl', new lang_string('libanswersurl', 'block_libanswers'),
            new lang_string('libanswersurl_desc', 'block_libanswers'), 'https://myinsitution.libanswers.com', PARAM_URL));

$settings->add(new admin_setting_configtext('block_libanswers/limitto', new lang_string('limitto', 'block_libanswers'),
            new lang_string('limitto_desc', 'block_libanswers'), '', PARAM_SEQUENCE));

$settings->add(new admin_setting_configcheckbox('block_libanswers/hideinhours', new lang_string('hideinhours', 'block_libanswers'),
            new lang_string('hideinhours_desc', 'block_libanswers'), 1, PARAM_INT));
