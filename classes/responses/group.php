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
 * Group response object for local_ws_enrolcohort.
 *
 * @package     local_ws_enrolcohort
 * @author      Donald Barrett <donald.barrett@learningworks.co.nz>
 * @copyright   2018 onwards, LearningWorks ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_ws_enrolcohort\responses;

// No direct access.
defined('MOODLE_INTERNAL') || die();

use local_ws_enrolcohort\tools;

class group extends response {
    /**
     * @var $courseid   The id of the course this group belongs to.
     */
    protected $courseid;

    /**
     * @var $name       The name of the group.
     */
    protected $name;

    /**
     * group constructor.
     *
     * @param int $id               The id of the group.
     * @param string $object        The name of this object. Don't specify when constructing.
     * @param null|int $courseid    The id of the course. If null then the group creation errored.
     * @throws \dml_exception
     * @throws \coding_exception
     */
    public function __construct($id = 0, $object = 'group', $courseid = null) {
        global $DB;

        parent::__construct($id, $object);

        // Set the fields.
        $this->id = $id;

        if (is_null($courseid) || $id == 0) {
            $this->name     = tools::get_string('instancegroupnone');
            $this->courseid = -1;
        } else {
            $this->name     = $DB->get_field('groups', 'name', ['id' => $id, 'courseid' => $courseid]);
            $this->courseid = $courseid;
        }
    }
}