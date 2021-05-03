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
 * Multiple choice question type upgrade code.
 *
 * @package    qtype
 * @subpackage behaviour
 * @copyright  1999 onwards Martin Dougiamas {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Upgrade code for the multiple choice question type.
 * @param int $oldversion the version we are upgrading from.
 */
function xmldb_qbehaviour_amtchauer_upgrade($oldversion) {
    global $CFG, $DB, $THEME;
    require_once($CFG->libdir.'/db/upgradelib.php'); // Core Upgrade-related functions.
    $dbman = $DB->get_manager();

    $result = true;
    if ($result && $oldversion < 2020300306) {
        $table = new xmldb_table('amtchauer');
        $table->add_field('id', XMLDB_TYPE_INTEGER, 10, null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null, null, null);
        $table->add_field('qubaid', XMLDB_TYPE_INTEGER, 10, null, XMLDB_NOTNULL);
        $table->add_field('totalmark', XMLDB_TYPE_INTEGER, 10, null, XMLDB_NOTNULL);
        $table->add_field('nameofthetest', XMLDB_TYPE_CHAR, 100, null,XMLDB_NOTNULL);
        $table->add_field('answers',XMLDB_TYPE_CHAR, 1000, null,XMLDB_NOTNULL);
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        if (!$dbman->table_exists($table)) {
            $result = $result && $dbman->create_table($table);
        }
    }


    upgrade_plugin_savepoint(true, 2021200309, 'qbehaviour', 'amthauer', false);
    return $result;

}
