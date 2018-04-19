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
require_once("$CFG->libdir/externallib.php");

class local_ws_enrolcohort_external extends external_api {
    /**
     * Returns description of the add_instance function parameters.
     *
     * @return external_function_parameters
     */
    public static function add_instance_parameters() {
        return new external_function_parameters(
            [
                'params' => new external_single_structure(
                    [
                        'courseid'  => new external_value(PARAM_INT, 'The id of the course.', VALUE_REQUIRED),
                        'cohortid'  => new external_value(PARAM_INT, 'The id of the cohort.', VALUE_REQUIRED),
                        'roleid'    => new external_value(PARAM_INT, 'The id of an existing role to assign users.', VALUE_OPTIONAL, 0),
                        'groupid'   => new external_value(PARAM_INT, 'The id of a group to add users to.', VALUE_OPTIONAL, 0),
                        'name'      => new external_value(PARAM_TEXT, 'The name of the cohort enrolment instance.', VALUE_OPTIONAL)
                    ]
                )
            ]
        );
    }

    /**
     * Returns description of the add_instance function return value.
     *
     * @return external_description
     */
    public static function add_instance_returns() {
        return new external_multiple_structure(
            new external_single_structure(
                [
                    'id'        => new external_value(PARAM_INT, 'enrolment instance id'),
                    'courseid'  => new external_value(PARAM_INT, 'course id'),
                    'cohortid'  => new external_value(PARAM_INT, 'cohort id'),
                    'roleid'    => new external_value(PARAM_INT, 'role id'),
                    'groupid'   => new external_value(PARAM_INT, 'group id'),
                    'name'      => new external_value(PARAM_TEXT, 'enrolment instance name'),
                    'status'    => new external_value(PARAM_BOOL, 'enrolment instance enabled')
                ]
            )
        );
    }

    /**
     * Adds a cohort enrolment instance to a given course.
     *
     * @param $params
     * @return array
     * @throws invalid_parameter_exception
     */
    public static function add_instance($params) {
        $params = self::validate_parameters(self::add_instance_parameters(), ['params' => $params]);

        // Return some test data.
        $data = [
            [
                'id'        => 1,
                'courseid'  => 2,
                'cohortid'  => 3,
                'roleid'    => 4,
                'groupid'   => 5,
                'name'      => json_encode($params),
                'status'    => true
            ]
        ];

        return $data;
    }
}
