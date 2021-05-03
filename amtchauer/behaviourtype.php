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
 * Question behaviour type for amtchauer behaviour.
 *
 * @package    qbehaviour_amtchauer
 * @copyright  2012 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * Question behaviour type information for amtchauer behaviour.
 *
 * @copyright  2012 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qbehaviour_amtchauer_type extends question_behaviour_type{
    public function is_archetypal() {
        return true;
    }

    public function get_unused_display_options() {
        return '';
    }

    public function can_questions_finish_during_the_attempt()
    {
        return false;
    }

    public function summarise_usage(question_usage_by_activity $quba, question_display_options $options) {
        global $OUTPUT, $DB;


        $summarydata = parent::summarise_usage($quba, $options);
        $slots=$quba->get_slots();
        global $DB;
        // Добавление записи в базу данных с уникальным номером попытки, чтобы потом можно было сопоставить данные с пользователем
        $dbname = 'amtchauer';

        /** @var integer|string the id for this usage. If this usage was loaded from
         * the database, then this is the database id. Otherwise a unique random
         * string is used.
         **/
        $qubaid = $quba->get_id();

        /** @return int the number of questions that are currently in this usage. */
       // $smth = $quba -> get_question_attempt($slots[0]);

        /*
        Getting the name of the firt quetion
        While setting the questions for the test each question should include name of the Sub-test
        Example: sub1
        */
        $vars = get_object_vars ($quba->get_question($slots[0]));

       
        $name= $vars['name'];
        /* Getting name of the subtest */
        preg_match('/^sub./',$name ,$found);

        //Getting answers from the response
        $resp=array();
        for ($i = 0; $i < count($slots); $i++) {
            $resp[$i] = $quba->get_response_summary($slots[$i]);
        }

        //Total mark of the test
        $totalmark = $quba->get_total_mark();

        // Answer
        if($found[0] =='sub4'){
            $totalmark=0;
            for ($i = 0; $i < count($slots); $i++) {
                if($quba->get_question_mark($slots[$i]) == 1){
                    $totalmark = $totalmark + 1;
                }
                $resp[$i] = $quba->get_response_summary($slots[$i]);
            }
        }

        $anwers = $this->mapped_implode(',', $resp, '=>');
        $anwers  = str_replace("\n", '',$anwers);



        // New data for the database
        $data = ['qubaid'=>$qubaid,'totalmark'=> $totalmark,'nameofthetest'=>$found[0], 'answers'=>$anwers];
        if(!($DB->record_exists($dbname,array('qubaid'=>$qubaid)))) $DB->insert_record($dbname, $data);

        $summarydata['get response mark'] = array('title' => 'ОТЗЫВ НА ОТВЕТ',
                'content' => html_writer::tag('h3',
                    $this->amtchauer_estimate($totalmark, $found[0])),
            );

        return $summarydata;
    }

    protected  function amtchauer_estimate($mark,$numtest){
        $text = "";
        $tests = ['sub1','sub2','sub3','sub4','sub5','sub6','sub7','sub8','sub9'];
        $num = array_search($numtest, $tests);
        $ball = array(
            0=>array(0=> 7,1=>12,2=>17),
            1=>array(0=> 8,1=>11,2=>17),
            2=>array(0=> 7,1=>11,2=>17),
            3=>[6,11,16],   4=>[9,13,18],
            5=> [8,14,20],  6=>[6,10,15],
            7 => [6,10,17], 8=> [14,18,20]
        );

        if($mark < $ball[$num][0]) $text = get_string('level0', 'qbehaviour_amtchauer');
        elseif($mark < $ball[$num][1]) $text = get_string('level1', 'qbehaviour_amtchauer');
        elseif($mark < $ball[$num][2]) $text = get_string('level2', 'qbehaviour_amtchauer');
        else $text = get_string('level3', 'qbehaviour_amtchauer');

        return $text;

    }



    protected function mapped_implode($glue, $array, $symbol = '=') {
        return implode($glue, array_map(
                function($k, $v) use($symbol) {
                    return $k . $symbol . $v;
                },
                array_keys($array),
                array_values($array)
            )
        );
    }
}
