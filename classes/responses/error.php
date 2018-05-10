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
 * Error response for local_ws_enrolcohort.
 *
 * @package     local_ws_enrolcohort
 * @author      Donald Barrett <donald.barrett@learningworks.co.nz>
 * @copyright   2018 onwards, LearningWorks ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_ws_enrolcohort\responses;

// No direct access.
defined('MOODLE_INTERNAL') || die();

use \local_ws_enrolcohort\tools as tools;

class error extends response {
    /**
     * @var string $message     A localized message with details about the error.
     */
    protected $message;

    /**
     * error constructor.
     *
     * @param int $id
     * @param string $object                            The name of the object this error response is describing.
     * @param string $identifier                        The langstring identifier. Only gets strings from this plugins lang file.
     * @param string|\stdClass $langstringplaceholder   Any placeholder values for the lang string.
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function __construct($id = 0, $object = '', $identifier = '', $langstringplaceholder = null) {
        parent::__construct($id, $object);

        // Get a localized message.
        $this->message = tools::get_string($identifier, $langstringplaceholder);
    }
}