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
 * Exception for an object that doesn't exist for local_ws_enrolcohort.
 *
 * @package     local_ws_enrolcohort
 * @author      Donald Barrett <donald.barrett@learningworks.co.nz>
 * @copyright   2018 onwards, LearningWorks ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_ws_enrolcohort\exceptions;

// No direct access.
defined('MOODLE_INTERNAL') || die();

use \local_ws_enrolcohort\tools;

class object_not_found_exception extends \moodle_exception {
    public function __construct($object = '', $key = '', $value = '') {
        $a = ['object' => $object, 'key' => $key, 'value' => $value];
        parent::__construct('objectnotfound', tools::COMPONENT_NAME, '', null, tools::get_string('objectnotfound:message', $a));
    }
}