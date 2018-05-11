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
 * Course response object for local_ws_enrolcohort.
 *
 * @package     local_ws_enrolcohort
 * @author      Donald Barrett <donald.barrett@learningworks.co.nz>
 * @copyright   2018 onwards, LearningWorks ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_ws_enrolcohort\responses;

// No direct access.
defined('MOODLE_INTERNAL') || die();

class course extends response {
    /**
     * @var $name           The name of the course.
     */
    protected $name;

    /**
     * @var $idnumber       The idnumber of the course.
     */
    protected $idnumber;

    /**
     * @var $shortname      The shortname of the course.
     */
    protected $shortname;

    /**
     * @var $visible        Course visibility.
     */
    protected $visible;

    /**
     * @var $format         The format of the course.
     */
    protected $format;

    /**
     * course constructor.
     *
     * @param int $id
     * @param string $object    The name of this object. Don't specify when constructing.
     * @throws \dml_exception
     */
    public function __construct($id = 0, $object = 'course') {
        global $DB;

        parent::__construct($id, $object);

        // Get the course.
        $course = $DB->get_record('course', ['id' => $id]);

        // Set the field values here.
        $this->name         = $course->fullname;
        $this->idnumber     = $course->idnumber;
        $this->shortname    = $course->shortname;
        $this->visible      = $course->visible;
        $this->format       = $course->format;
    }
}