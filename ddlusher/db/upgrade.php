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
 * Ddmarker question type upgrade code.
 *
 * @package    qtype_ddlusherr
 * @copyright  2013 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


/**
 * Upgrade code for the ddlusherr question type.
 * @param int $oldversion the version we are upgrading from.
 * @return bool
 */
function xmldb_qtype_ddlusher_upgrade($oldversion) {
    global $CFG, $DB, $THEME;
    require_once($CFG->libdir.'/db/upgradelib.php'); // Core Upgrade-related functions.
    $dbman = $DB->get_manager();

    // Automatically generated Moodle v3.2.0 release upgrade line.
    // Put any upgrade step following this.

    // Automatically generated Moodle v3.3.0 release upgrade line.
    // Put any upgrade step following this.

    // Automatically generated Moodle v3.4.0 release upgrade line.
    // Put any upgrade step following this.

    // Automatically generated Moodle v3.5.0 release upgrade line.
    // Put any upgrade step following this.
    $result = true;
    if ($result && $oldversion <= 2021200303) {

        $table = new xmldb_table('lusherr');
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table, $continue = true, $feedback = true);
        }
        $table->add_field('id', XMLDB_TYPE_INTEGER, 10, null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null, null, null);
        $table->add_field('qubaid', XMLDB_TYPE_INTEGER, 20, null, XMLDB_NOTNULL);
        $table->add_field('grplus', XMLDB_TYPE_CHAR, 100, null, XMLDB_NOTNULL);
        $table->add_field('grx', XMLDB_TYPE_CHAR, 100, null,XMLDB_NOTNULL);
        $table->add_field('greq', XMLDB_TYPE_CHAR, 100, null, XMLDB_NOTNULL);
        $table->add_field('grmin', XMLDB_TYPE_CHAR, 100, null, XMLDB_NOTNULL);
        $table->add_field('grplusmin', XMLDB_TYPE_CHAR, 100, null, XMLDB_NOTNULL);
        $table->add_field('firstans', XMLDB_TYPE_CHAR, 100, null, XMLDB_NOTNULL);
        $table->add_field('secondans', XMLDB_TYPE_CHAR, 100, null, XMLDB_NOTNULL);
        $table->add_field('exclamcount', XMLDB_TYPE_INTEGER, 20, null, XMLDB_NOTNULL);
        //$table->add_field('timeremain', XMLDB_TYPE_CHAR, 100, null, XMLDB_NOTNULL);

        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        if (!$dbman->table_exists($table)) {
            $result = $result && $dbman->create_table($table);
        }
       /* elseif(!$dbman->field_exists($table,$field1) && !$dbman->field_exists($table,$field2)) {
            $dbman->add_field($table, $field1);
            $dbman->add_field($table, $field2);
        }*/

        /*if(!$dbman->field_exists($table,$fieldtime)) $dbman->add_field($table, $fieldtime);*/

       // if(!$dbman->field_exists($table,$fieldexclamation)) $dbman->add_field($table, $fieldexclamation);


        upgrade_plugin_savepoint(true, 2021200303, 'qtype', 'ddlusher', false);

    }
    return $result;

}
