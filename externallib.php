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
use \local_ws_enrolcohort\responses as responses;

class local_ws_enrolcohort_external extends external_api {

    /**
     * A constant that defines the query strings i.e. https://example.url?querystring[key]=value&querystring[key]=value etcera, etcetera.
     */
    const QUERYSTRING_IDENTIFIER = 'instance';

    /**
     * Constants that define the enrolment statuses.
     */
    const COHORT_STATUS_ACTIVE_YES = 0;
    const COHORT_STATUS_ACTIVE_NO  = 1;

    /**
     * Constants that define group creation modes. Create group is already defined. Values are as per the add instance mform.
     */
    const COHORT_GROUP_CREATE_NONE = 0;
    const COHORT_GROUP_CREATE_NEW = 1;

    /**
     * Constants that map the customint field names to the name of the fields.
     */
    const FIELD_GROUP   = 'customint2';
    const FIELD_COHORT  = 'customint1';

    /**
     * A constant that defines a webservice function call that has errors.
     */
    const WEBSERVICE_FUNCTION_CALL_HAS_ERRORS_ID = -1;

    /**
     * Gets the default value for a parameter. Use properly. No error checking happens.
     *
     * @param string $querystringvalue
     * @return mixed
     */
    private static function add_instance_get_parameter_default_value($querystringvalue = '') {
        // Just ask for the right things and one shall receive. We shan't be making any mistakes.
        return self::add_instance_parameters()->keys[self::QUERYSTRING_IDENTIFIER]->keys[$querystringvalue]->default;
    }

    /**
     * Returns description of the add_instance function parameters.
     *
     * @return external_function_parameters
     */
    public static function add_instance_parameters() {
        return new external_function_parameters(
            [
                self::QUERYSTRING_IDENTIFIER => new external_single_structure(
                    [
                        'courseid'  => new external_value(PARAM_INT, 'The id of the course.', VALUE_REQUIRED),
                        'cohortid'  => new external_value(PARAM_INT, 'The id of the cohort.', VALUE_REQUIRED),
                        'roleid'    => new external_value(PARAM_INT, 'The id of an existing role to assign users.', VALUE_REQUIRED),
                        'groupid'   => new external_value(PARAM_INT, 'The id of a group to add users to.', VALUE_OPTIONAL, self::COHORT_GROUP_CREATE_NONE),
                        'name'      => new external_value(PARAM_TEXT, 'The name of the cohort enrolment instance.', VALUE_OPTIONAL),
                        'status'    => new external_value(PARAM_INT, 'The status of the enrolment method.', VALUE_OPTIONAL, self::COHORT_STATUS_ACTIVE_YES)
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
     * @throws coding_exception
     * @throws dml_exception
     * @throws invalid_parameter_exception
     */
    public static function add_instance($params) {
        global $CFG, $DB, $SITE;

        require_once("{$CFG->dirroot}/cohort/lib.php");

        // Check the call for parameters.
        $params = self::validate_parameters(self::add_instance_parameters(), [self::QUERYSTRING_IDENTIFIER => $params]);

        // In case of errors.
        $errors = [];

        // Other data.
        $extradata = [];

        // Get the course.
        $courseid = $params[self::QUERYSTRING_IDENTIFIER]['courseid'];

        // Initial context.
        $context = null;

        // Validate the course. This is required.
        if ($courseid == $SITE->id) {
            $errors[] = (new responses\error($courseid, 'course', 'courseissite'))->to_array();

            // Set the context to system for validation.
            $context = \context_system::instance();
        } else if (!$DB->record_exists('course', ['id' => $courseid])) {
            $errors[] = (new responses\error($courseid, 'course', 'coursenotexists'))->to_array();
        } else {
            // Set the context to course for validation.
            $context = \context_course::instance($courseid);
        }

        // Get the cohort. This is required
        $cohortid = $params[self::QUERYSTRING_IDENTIFIER]['cohortid'];

        // Validate the cohort. This is required.
        if (!$DB->record_exists('cohort', ['id' => $cohortid])) {
            $errors[] = (new responses\error($cohortid, 'cohort', 'cohortnotexists'))->to_array();
        } else if ($context instanceof \context_system) {
            $errors[] = (new responses\error($cohortid, 'cohortsite', 'cohortnotavailableatcontext'))->to_array();
        } else if ($context instanceof \context_course) {
            $availablecohorts = cohort_get_available_cohorts($context);
            if (empty($availablecohorts) || !isset($availablecohorts[$cohortid])) {
                $errors[] = (new responses\error($cohortid, 'cohort', 'cohortnotavailableatcontext'))->to_array();
            }
        }

        // Get the role.
        $roleid = $params[self::QUERYSTRING_IDENTIFIER]['roleid'];

        // Validate the role. This is required.
        $assignableroles = $context instanceof \context_course ? get_assignable_roles($context) : [];

        if (!$DB->record_exists('role', ['id' => $roleid])) {
            // Role doesn't exist.
            $errors[] = (new responses\error($roleid, 'role', 'rolenotexists'))->to_array();
        } else if (empty($assignableroles) || !isset($assignableroles[$roleid])) {
            // Role is not assignable at this context.
            $errors[] = (new responses\error($roleid, 'role', 'rolenotassignablehere'))->to_array();
        }

        // Get the group.
        $groupid = $params[self::QUERYSTRING_IDENTIFIER]['groupid'];

        // Validate the role. This is optional.
        if (!is_null($groupid)) {
            if ($groupid !== COHORT_CREATE_GROUP && !$DB->record_exists('groups', ['courseid' => $courseid, 'id' => $groupid])) {
                // Provided group id doesn't exist for this course.
                $errors[] = (new responses\error($groupid, 'group', 'groupnotexists'))->to_array();
            }
        } else {
            // Get the default value specified for the parameter groupid.
            $groupid = self::add_instance_get_parameter_default_value('groupid');
        }

        // Validate the name of the cohort enrolment instance. This is optional.
        $name = $params[self::QUERYSTRING_IDENTIFIER]['name'];

        if (is_null($name)) {
            // Get the default value for the name.
            $name = self::add_instance_get_parameter_default_value('name');
        }

        // Check the users capabilities to ensure that they can do this.
        if ($context instanceof \context_course) {
            // Check that the user has the required capabilities for the course context.
            $requiredcapabilities = ['moodle/cohort:view', 'moodle/course:managegroups', 'moodle/role:assign'];
            foreach ($requiredcapabilities as $requiredcapability) {
                if (!has_capability($requiredcapability, $context)) {
                    $errors[] = (new responses\error(null, 'capability', 'usermissingrequiredcapability', $requiredcapability))->to_array();
                }
            }

            // Check that the user has the capability to enrol config (cohort and moodle course level).
            $anycapability = ['moodle/course:enrolconfig', 'enrol/cohort:config'];
            if (!has_any_capability($anycapability, $context)) {
                $errors[] = (new responses\error(null, 'capability', 'usermissinganycapability', '\''.implode('\', \'', $anycapability).'\''))->to_array();
            }
        }

        // Validate the status and set to a default.
        $status = $params[self::QUERYSTRING_IDENTIFIER]['status'];

        if (!is_null($status) && !in_array($status, [self::COHORT_STATUS_ACTIVE_YES, self::COHORT_STATUS_ACTIVE_NO])) {
            $errors[] = (new responses\error(null, 'status', 'statusinvalid', $status))->to_array();
        }

        // This is the important one. Check if the cohort enrolment instance is available for use.
        $cohortenrolment = enrol_get_plugin('cohort');
        if (!$cohortenrolment) {
            $errors[] = (new responses\error(null, 'enrol_plugin', 'enrolmentmethodnotavailable'))->to_array();
        }

        // Prepare the data to be returned as the response.
        $extradata[] = [
            'object'    => self::QUERYSTRING_IDENTIFIER,
            'cohortid'  => $cohortid,
            'roleid'    => $roleid,
            'groupid'   => $groupid,
            'name'      => $name,
            'status'    => $status
        ];

        // Set the HTTP status code.
        $code = empty($errors) ? 200 : 400;

        // Set the response message.
        $message = tools::get_string("addinstance:{$code}");

        // The initial response. The field id will be filled in later.
        $response = [
            'code'      => $code,
            'message'   => $message,
            'errors'    => $errors,
            'data'      => $extradata
        ];

        if (!empty($errors)) {
            // Return now due to errors.
            $response['id'] = self::WEBSERVICE_FUNCTION_CALL_HAS_ERRORS_ID;

            return $response;
        }

        // Get the full course object.
        $course = $DB->get_record('course', ['id' => $courseid]);

        // Prepare the fields.
        $fields = [
            'name'              => $name,
            'status'            => $status,
            'roleid'            => $roleid,
            'id'                => 0,
            'courseid'          => $courseid,
            'type'              => 'cohort',
            self::FIELD_COHORT  => $cohortid,
            self::FIELD_GROUP   => $groupid
        ];

        // After all that hard work we can now add the instance.
        $response['id'] = $cohortenrolment->add_instance($course, $fields);

        // Return some data.
        return $response;
    }
}
