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
 * Locallib for LibAnswers
 *
 * @package    block_libanswers
 * @copyright  2020 University of Chichester {@link http://www.chi.ac.uk}
 * @author     Mark Sharp <m.sharp@chi.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

namespace block_libanswers;

use \curl;

defined('MOODLE_INTERNAL') || die();

/**
 * Returns an array list for an HTML select element.
 * @return array key/value pairs
 */
function widgetoptions() : array {
    global $CFG;

    $config = get_config('block_libanswers');
    $url = ($config->libanswersurl) ?? null;
    $iid = ($config->iid) ?? null;

    if (!$url || !$iid) {
        return [];
    }

    if ($url == 'https://myinsitution.libanswers.com' || $iid == 0) {
        return [];
    }
    $options = [];
    require_once($CFG->libdir . '/filelib.php');
    $curl = new curl();
    $json = $curl->get($url . '/api/1.0/chat/widgets?iid=' . $iid);
    
    $response = json_decode($json);
    $widgets = $response->widgets;
    $hashRe = "/https:\/\/(?'region'[^\.]+).+(?'pre'hash=)(?'hash'[^\"]+)/";
    foreach ($widgets as $widget) {
        
        if ($widget->type !== 'Embed') {
            continue;
        }
        $name = $widget->name;
        if (preg_match($hashRe, $widget->code->script, $matches) == 0) {
            continue;
        }

        $hash = $matches['hash'];
        $region = $matches['region'];
        $options[$region . '_' . $hash] = $name;
    }
    return $options;
}
