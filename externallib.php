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

use \local_ws_enrolcohort\tools as tools;

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
     * @return external_single_structure
     */
    public static function add_instance_returns() {
        return new external_single_structure(
            [
                'id'        => new external_value(PARAM_INT, 'enrolment instance id'),
                'code'      => new external_value(PARAM_INT, 'http status code'),
                'message'   => new external_value(PARAM_TEXT, 'human readable response message'),
                'errors'    => new external_multiple_structure(
                    new external_single_structure(
                        [
                            'object'    => new external_value(PARAM_TEXT, 'the object that failed'),
                            'id'        => new external_value(PARAM_INT, 'the id of the failed object'),
                            'message'   => new external_value(PARAM_TEXT, 'human readable response message')
                        ],
                        'component errors',
                        VALUE_OPTIONAL
                    )
                ),
                'data' => new external_multiple_structure(
                    new external_single_structure(
                        [
                            'object'    => new external_value(PARAM_TEXT, 'the object this is describing'),
                            'id'        => new external_value(PARAM_INT, 'the id of the object', VALUE_OPTIONAL),
                            'name'      => new external_value(PARAM_TEXT, 'the name of the object'),
                            'courseid'  => new external_value(PARAM_INT, 'the id of the related course', VALUE_OPTIONAL),
                            'cohortid'  => new external_value(PARAM_INT, 'the id of the cohort', VALUE_OPTIONAL),
                            'roleid'    => new external_value(PARAM_INT, 'the id of the related role', VALUE_OPTIONAL),
                            'groupid'   => new external_value(PARAM_INT, 'the id of the group', VALUE_OPTIONAL),
                            'idnumber'  => new external_value(PARAM_RAW, 'the idnumber of the object', VALUE_OPTIONAL),
                            'shortname' => new external_value(PARAM_TEXT, 'the shortname of the object', VALUE_OPTIONAL),
                            'status'    => new external_value(PARAM_BOOL, 'the status of the object', VALUE_OPTIONAL),
                            'visible'   => new external_value(PARAM_BOOL, 'the visibility of the object', VALUE_OPTIONAL),
                            'format'    => new external_value(PARAM_PLUGIN, 'the course format', VALUE_OPTIONAL)
                        ],
                        'extra details',
                        VALUE_OPTIONAL
                    )
                )
            ]
        );
    }

    /**
     * Adds a cohort enrolment instance to a given course.
     *
     * @param $params
     * @return array
     * @throws invalid_parameter_exception
     * @throws dml_exception
     */
    public static function add_instance($params) {
        global $DB, $SITE;

        $params = self::validate_parameters(self::add_instance_parameters(), ['params' => $params]);

        // In case of errors.
        $errors = [];

        // Other data.
        $extradata = [];

        // Get the course.
        $courseid = $params['params']['courseid'];

        if ($courseid == $SITE->id) {
            $errors[] = self::generate_error('course', $courseid, 'courseissite');
        } else if (!$DB->record_exists('course', ['id' => $courseid])) {
            $errors[] = self::generate_error('course', $courseid, 'coursenotexists');
        }

        // Get the cohort.
        $cohortid = $params['params']['cohortid'];

        // Get the role.
        $roleid = $params['params']['roleid'];

        // Get the group.
        $groupid = $params['params']['groupid'];

        // The name of the cohort enrolment instance.
        $name = $params['params']['name'];

        // The status of the enrolment instance.
        $status = $params['params']['status'];

        $extradata[] = ['object' => 'params', 'cohortid' => $cohortid, 'roleid' => $roleid, 'groupid' => $groupid, 'name' => $name, 'status' => $status];

        // Set the HTTP status code.
        $code = empty($errors) ? 200 : 400;

        // Return some test data.
        $response = [
            'id'        => 1,
            'code'      => $code,
            'message'   => 'message',
            'errors'    => $errors,
            'data'      => $extradata
        ];

        return $response;
    }

    private static function generate_error($object = '', $id = 0, $identifier = '') {
        return [
            'object'    => $object,
            'id'        => $id,
            'message'   => tools::get_string($identifier)
        ];
    }
}
