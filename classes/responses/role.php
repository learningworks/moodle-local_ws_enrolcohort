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
 * Role response object for local_ws_enrolcohort.
 *
 * @package     local_ws_enrolcohort
 * @author      Donald Barrett <donald.barrett@learningworks.co.nz>
 * @copyright   2018 onwards, LearningWorks ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_ws_enrolcohort\responses;

// No direct access.
defined('MOODLE_INTERNAL') || die();

class role extends response {
    /**
     * @var mixed $shortname    The shortname of the role.
     */
    protected $shortname;

    /**
     * role constructor.
     *
     * @param int $id           The id of the role.
     * @param string $object    The name of this object. Default is role. Don't specify when constructing.
     * @throws \dml_exception
     */
    public function __construct($id = 0, $object = 'role') {
        global $DB;

        parent::__construct($id, $object);

        // Get the shortname of this role from the database.
        $this->shortname = $DB->get_field('role', 'shortname', ['id' => $id]);
    }
}