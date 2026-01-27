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
 * stuff for local_ws_enrolcohort.
 *
 * @package     local_ws_enrolcohort
 * @author      Donald Barrett <donald.barrett@learningworks.co.nz>
 * @copyright   2018 onwards, LearningWorks ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// No direct access.
defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot.'/local/ws_enrolcohort/classes/external/enrolcohort.php');

// Keep the old classname for db/services.php compatibility. Delegate static calls to the
// namespaced class to avoid side effects when the file is included in tests.
class local_ws_enrolcohort_external extends \core_external\external_api {
    public static function __callStatic($name, $arguments) {
        $classname = '\\local_ws_enrolcohort\\external\\enrolcohort';
        if (method_exists($classname, $name)) {
            return forward_static_call_array([$classname, $name], $arguments);
        }
        throw new \bad_method_call_exception("Method $name does not exist on $classname");
    }
}
