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
 * Upgrade ws stuff. for local_ws_enrolcohort.
 *
 * @package     local_ws_enrolcohort
 * @author      Donald Barrett <donald.barrett@learningworks.co.nz>
 * @copyright   2018 onwards, LearningWorks ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This is a CLI script.
define('CLI_SCRIPT', true);

// Config file.
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php');

global $CFG;

// Other things to require.
require_once("{$CFG->libdir}/clilib.php");
require_once("{$CFG->libdir}/cronlib.php");
require_once("{$CFG->libdir}/upgradelib.php");

// Get the locallib if we have one.
if (file_exists("{$CFG->dirroot}/local/locallib.php")) {
    require_once("{$CFG->dirroot}/local/locallib.php");
}

// We may need a lot of memory here.
@set_time_limit(0);
raise_memory_limit(MEMORY_HUGE);

// CLI options.
list($options, $unrecognized) = cli_get_params(
    // Long names.
    [
        'help' => false,
        'no-verbose' => false,
        'no-debugging' => false,
        'print-logo' => false
    ],
    // Short names.
    [
        'h' => 'help',
        'nv' => 'no-verbose',
        'nd' => 'no-debugging',
        'pl' => 'print-logo'
    ]
);

if (function_exists('cli_logo') && $options['print-logo']) {
    // Show a logo because we can..
    cli_logo();
    echo PHP_EOL;
}

if ($unrecognized) {
    $unrecognized = implode("\n ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized));
}

// Show help.
if ($options['help']) {
    $help =
            "Local WS Enrol cohort CLI script to update things without updating things.

Please note you must execute this script with the same uid as apache!

Options:
-nv, --no-verbose       Disables output to the console.
-h, --help              Print out this help.
-nd, --no-debugging     Disables debug messages.
-pl, --print-logo       Prints a cool CLI logo if available.

Example:
Run script with default parameters  - \$sudo -u www-data /usr/bin/php upgrade.php\n
";
    echo $help;
    die;
}

// Error checking.
// Todo: Check any parameters that need stuff.

// Set debugging.
if (!$options['no-debugging']) {
    @error_reporting(E_ALL | E_STRICT);
    @ini_set('display_errors', '1');
}

// Start output log.
$trace = new \text_progress_trace();
$trace->output(get_string('pluginname', 'local_ws_enrolcohort').' - This is a CLI script that will update webservice things.');

// Say some stuff like debugging is whatever.
if (!$options['no-debugging']) {
    $trace->output("Debugging is enabled.");
} else {
    $trace->output("Debugging has been disabled.");
}

// Set verbosity and output stuff.
if ($options['no-verbose']) {
    $trace->output("Verbose output has been disabled.\n");
    $trace = new \null_progress_trace();
} else {
    $trace->output("Verbose output is enabled.\n");
}

// Non classy style of timing.
$timenow = time();
$trace->output("Server Time: " . date('r', $timenow) . "\n");
$starttime = microtime();

$trace->output('Updating the webservices without doing the moodle updateyness.');
external_update_descriptions('local_ws_enrolcohort');
$pluginman = \core_plugin_manager::instance();
upgrade_noncore(true);
$trace->output('The webservice functions stuff should be updated.'.PHP_EOL);

// Finish timing.
$difftime = microtime_diff($starttime, microtime());
$trace->output("Script execution took {$difftime} seconds\n");