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
 * Definition of webservices for ws_enrolcohort.
 *
 * @package     ws_enrolcohort
 * @author      Donald Barrett <donald.barrett@learningworks.co.nz>
 * @copyright   2018 onwards, LearningWorks ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// No direct access.
defined('MOODLE_INTERNAL') || die();

// The individual capabilities.
$cohortview         = 'moodle/cohort:view';
$roleassign         = 'moodle/role:assign';
$coursemanagegroups = 'moodle/course:managegroups';
$courseenrolconfig  = 'moodle/course:enrolconfig';
$enrolcohortconfig  = 'enrol/cohort:config';

// Put the capabilities together for each webservice function.
$addcapabilities    = "{$cohortview}, {$roleassign}, {$coursemanagegroups}, {$courseenrolconfig}, {$enrolcohortconfig}";
$updatecapabilities = "{$roleassign}, {$coursemanagegroups}, {$courseenrolconfig}, {$enrolcohortconfig}";
$deletecapabilities = "{$cohortview}, {$coursemanagegroups}, {$courseenrolconfig}, {$enrolcohortconfig}";
$getcapabilities    = "{$cohortview}, {$courseenrolconfig}, {$enrolcohortconfig}";

// We defined the web service functions to install.
$functions = [
    'local_ws_enrolcohort_add_instance' => [
        'classname'     => 'local_ws_enrolcohort_external',
        'methodname'    => 'add_instance',
        'classpath'     => 'local/ws_enrolcohort/externallib.php',
        'description'   => 'Adds a new cohort sync enrolment instance to the specified course.',
        'capabilities'  => $addcapabilities,
        'type'          => 'create'
    ],
    'local_ws_enrolcohort_update_instance' => [
        'classname'     => 'local_ws_enrolcohort_external',
        'methodname'    => 'update_instance',
        'classpath'     => 'local/ws_enrolcohort/externallib.php',
        'description'   => 'Updates an existing cohort enrolment instance.',
        'capabilities'  => $updatecapabilities,
        'type'          => 'update'
    ],
    'local_ws_enrolcohort_delete_instance' => [
        'classname'     => 'local_ws_enrolcohort_external',
        'methodname'    => 'delete_instance',
        'classpath'     => 'local/ws_enrolcohort/externallib.php',
        'description'   => 'Deletes an existing cohort enrolment instance.',
        'capabilities'  => $deletecapabilities,
        'type'          => 'delete'
    ],
    'local_ws_enrolcohort_get_instances' => [
        'classname'     => 'local_ws_enrolcohort_external',
        'methodname'    => 'get_instances',
        'classpath'     => 'local/ws_enrolcohort/externallib.php',
        'description'   => 'Gets a list of cohort enrolment instances.',
        'capabilities'  => $getcapabilities,
        'type'          => 'get'
    ]
];

// We define the services to install as pre-build services. A pre-build service is not editable by administrator.
$services = [
    'Extended webservice for enrol_cohort' => [
        'functions'         => [
            'local_ws_enrolcohort_add_instance',
            'local_ws_enrolcohort_update_instance',
            'local_ws_enrolcohort_delete_instance',
            'local_ws_enrolcohort_get_instances'
        ],
        'restrictedusers'   => 1,
        'enabled'           => 1,
    ]
];
