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
 * Classy locallib but not locallib for local_ws_enrolcohort.
 *
 * @package     local_ws_enrolcohort
 * @author      Donald Barrett <donald.barrett@learningworks.co.nz>
 * @copyright   2018 onwards, LearningWorks ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_ws_enrolcohort;

// No direct access.
defined('MOODLE_INTERNAL') || die();

class tools {
    /**
     * The plugins component name.
     */
    const COMPONENT_NAME = 'local_ws_enrolcohort';

    /**
     * @param string $identifier
     * @param null $a
     * @return string
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function get_string($identifier = '', $a = null) {
        // Get the string manager so we can do things.
        $stringman = get_string_manager();

        // Reset caches for our lang strings if it doesn't exist or forced plugin settings to reset lang string caches is set.
        // Add to moodle config.php - $CFG->forced_plugin_settings = ['local_ws_enrolcohort' => ['resetlangstringcaches' => true]];.
        if (!$stringman->string_exists($identifier, self::COMPONENT_NAME) || self::get_config('resetlangstringcaches')) {
            $stringman->reset_caches();
        }

        if (is_null($a)) {
            // No placeholder.
            return get_string($identifier, self::COMPONENT_NAME);
        } else {
            // Yes placeholder.
            return get_string($identifier, self::COMPONENT_NAME, $a);
        }
    }

    /**
     * Access this plugins settings.
     *
     * @param null $settingname     Omitting this parameter returns all plugin settings.
     * @return mixed
     * @throws \dml_exception
     */
    public static function get_config($settingname = null) {
        return get_config(self::COMPONENT_NAME, $settingname);
    }
}