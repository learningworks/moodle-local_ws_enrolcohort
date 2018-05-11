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
$string['courseissite']     = 'Can not add instance to the site course.';

// Strings for cohort stuff.
$string['cohortnotexists']              = 'Cohort does not exist.';
$string['cohortnotavailableatcontext']  = 'Cohort cannot be added to this course.';

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
$string['instanceexists']           = 'Cohort is already synchronised with selected role.';
$string['instanceusingdefaultname'] = 'Using system generated name.';
$string['instancegroupnone']        = 'Enrol instance group none.';

// Strings for webservice function add_instance return messages.
$string['addinstance:200']  = 'Cohort enrolment instance added.';
$string['addinstance:400']  = 'Could not add cohort enrolment instance.';