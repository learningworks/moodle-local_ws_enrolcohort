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
 * Enrolment instance response object for local_ws_enrolcohort.
 *
 * @package     local_ws_enrolcohort
 * @author      Donald Barrett <donald.barrett@learningworks.co.nz>
 * @copyright   2018 onwards, LearningWorks ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_ws_enrolcohort\responses;

// No direct access.
defined('MOODLE_INTERNAL') || die();

class enrol extends response {
    /**
     * @var $name           The name provided to the enrolment instance.
     */
    protected $name;

    /**
     * @var $status         The status of the enrolment instance.
     */
    protected $status;

    /**
     * @var $roleid         The id of the role associated to this enrolment instance.
     */
    protected $roleid;

    /**
     * @var $courseid       The id of the course this enrolment instance is for.
     */
    protected $courseid;

    /**
     * @var $cohortid       The id of the cohort.
     */
    protected $cohortid;

    /**
     * @var $groupid        The id of the group.
     */
    protected $groupid;

    public function __construct($id = 0, $object = 'enrol', $name = '', $status = 0, $roleid = 0, $courseid = 0, $cohortid = 0, $groupid = 0) {
        parent::__construct($id, $object);

        // Set the values for the fields.
        $this->name     = $name;
        $this->status   = $status;
        $this->roleid   = $roleid;
        $this->courseid = $courseid;
        $this->cohortid = $cohortid;
        $this->groupid  = $groupid;
    }
}