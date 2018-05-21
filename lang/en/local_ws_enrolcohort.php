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
 * Strings for language 'en' for local_ws_enrolcohort.
 *
 * @package     local_ws_enrolcohort
 * @author      Donald Barrett <donald.barrett@learningworks.co.nz>
 * @copyright   2018 onwards, LearningWorks ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// No direct access.
defined('MOODLE_INTERNAL') || die();

// Default langstring.
$string['pluginname'] = 'Extended enrol cohort webservices';

// Strings for course stuff.
$string['coursenotexists']  = 'Course does not exist.';

// Strings for cohort stuff.
$string['cohortnotexists']              = 'Cohort does not exist.';
$string['cohortnotavailableatcontext']  = 'Cohort cannot be added to this course.';
$string['cohortnullcontext']            = 'Cohort cannot be added because the context is null.';

// Strings for role stuff.
$string['rolenotexists']            = 'Role does not exist.';
$string['rolenotassignablehere']    = 'Role is not assignable here.';

// Strings for group stuff.
$string['groupnotexists']   = 'Group does not exist.';

// Strings for capabilities stuff.
$string['usermissingrequiredcapability']    = 'User is missing the required capability \'{$a}\' at the course context.';
$string['usermissinganycapability']         = 'User is missing one of the following capabilities at the course context: {$a}.';

// Strings for enrolment method stuff.
$string['enrolmentmethodnotavailable']  = 'Could not instantiate enrol_cohort.';

// Strings for status stuff.
$string['statusinvalid'] = 'Invalid status {$a}. Possible statuses are: 0 - active, 1 - not active.';

// Strings for instance.
$string['instancegroupnone']        = 'Enrol instance group none.';
$string['instancenotexists']        = 'Unknown enrolment instance.';

// Strings for webservice function add_instance.
$string['addinstance:201']                  = 'Cohort enrolment instance added.';
$string['addinstance:400']                  = 'Could not add cohort enrolment instance.';
$string['addinstance:cohortalreadysynced']  = 'Cohort is already synchronised with selected role.';
$string['addinstance:usingdefaultname']     = 'Using system generated name.';
$string['addinstance:courseissite']         = 'Can not add instance to the site course.';

// Strings for webservice function update_instance.
$string['updateinstance:200'] = 'Cohort enrolment instance updated.';
$string['updateinstance:400'] = 'Could not update cohort enrolment instance.';
$string['updateinstance:nochange'] = 'No changes were made to the cohort enrolment instance.';

// Strings for webservice function delete_instance.
$string['deleteinstance:200'] = 'Cohort enrolment instance deleted.';
$string['deleteinstance:400'] = 'Could not delete cohort enrolment instance.';

// Strings for webservice function get_instances.
$string['getinstance:200'] = 'Found {$a->numberofenrolmentinstances} cohort enrolment instances for the course with id {$a->courseid}.';
$string['getinstances:200'] = 'Found {$a->numberofenrolmentinstances} cohort enrolment instances in {$a->numberofcourses} courses (All courses).';
$string['getinstances:400'] = 'Could not get cohort enrolment instances.';
$string['getinstances:courseissite']    = 'Can not get instances for the site course.';

// String for an unknown HTTP status code.
$string['unknownstatuscode'] = 'Unknown status code {$a}.';