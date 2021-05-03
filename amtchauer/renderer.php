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
 * Renderer for outputting parts of a question belonging to the legacy
 * amtchauer behaviour.
 *
 * @package    qbehaviour
 * @subpackage amtchauer
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * Renderer for outputting parts of a question belonging to the legacy
 * amtchauer behaviour.
 *
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qbehaviour_amtchauer_renderer extends qbehaviour_renderer {

    public function controls(question_attempt $qa, question_display_options $options) {
       // $result= "";
        global $PAGE;
        //getting url
        $url = $_SERVER['REQUEST_URI'];
        //checking if we are on a summary page

        //print_r($qa->get_question());//delete

        $vars = get_object_vars ($qa->get_question());
        $name= $vars['name'];
        /* Getting name of the subtest */
        preg_match('/^sub./',$name ,$found);


        $result = html_writer::tag('div', "Вы не можете закончить попытку без ответа на этот вопрос");

        //checking if we are on a summary page
        $isnt_first = stripos($url, 'page');

        if(!$isnt_first && $found[0]=='sub9'&&!strpos($url, 'review')) {
            $result = "";
            $result .= html_writer:: start_tag('table', array('id' => 'time'));
            $result .= html_writer::start_tag('td', array('class' => 'minutes', 'style' => 'height:100px; width:100px;text-align: right;padding: 10px 0; font-size: 50px;'));
            $result .= html_writer:: end_tag('td');
            $result .= html_writer::start_tag('td', array('style' => 'text-align:right;padding: 10px 0; font-size: 50px;')) . ':';
            $result .= html_writer:: end_tag('td');
            $result .= html_writer::start_tag('td', array('class' => 'seconds', 'style' => 'height:100px; width:100px;text-align:left;padding:0; font-size: 50px;'));
            $result .= html_writer:: end_tag('td');

            $result .= html_writer:: end_tag('table');


            if(!strpos($url, 'review')){
                $PAGE->requires->js_call_amd('qbehaviour_amtchauer/countdown', 'initialise');
            }
        }

        if($isnt_first &&  !strpos($url, 'review') && $found[0]=='sub9'){
            $PAGE->requires->js_call_amd('qbehaviour_amtchauer/nobutton', 'init');
        }

        return $result;
    }

    public function feedback(question_attempt $qa, question_display_options $options) {

    }
/*
    /**
     * Display the scoring information about an amtchauer attempt.
     * @param qbehaviour_amtchauer_mark_details contains all the score details we need.
     * @param question_display_options $options display options.

    public function render_amtchauer_marks(qbehaviour_amtchauer_mark_details $details, question_display_options $options) {
        if ($details->state == question_state::$todo || $options->marks < question_display_options::MARK_AND_MAX) {
            // No grades yet.
            return '';
        }

        // Display the grading details from the last graded state.
        $class = $details->state->get_feedback_class();
        return html_writer::tag('div', get_string($class, 'question'),
                        array('class' => 'correctness ' . $class))
                . html_writer::tag('div', $this->grading_details($details, $options),
                        array('class' => 'gradingdetails'));
    }*/

    /**
     * Display the information about the penalty calculations.
     * @param qbehaviour_amtchauer_mark_details contains all the score details we need.
     * @param question_display_options $options display options.
     * @return string html fragment
     */
    /*protected function grading_details(qbehaviour_amtchauer_mark_details $details, question_display_options $options) {

        $mark = $details->get_formatted_marks($options->markdp);

        if ($details->currentpenalty == 0 && $details->totalpenalty == 0) {
            return get_string('gradingdetails', 'qbehaviour_amtchauer', $mark);
        }

        $output = '';

        // Print details of grade adjustment due to penalties
        if ($details->rawmark != $details->actualmark) {
            if (!$details->improvable) {
                return get_string('gradingdetailswithadjustment', 'qbehaviour_amtchauer', $mark);
            } else if ($details->totalpenalty > $details->currentpenalty) {
                return get_string('gradingdetailswithadjustmenttotalpenalty', 'qbehaviour_amtchauer', $mark);
            } else {
                return get_string('gradingdetailswithadjustmentpenalty', 'qbehaviour_amtchauer', $mark);
            }

        } else {
            if (!$details->improvable) {
                return get_string('gradingdetails', 'qbehaviour_amtchauer', $mark);
            } else if ($details->totalpenalty > $details->currentpenalty) {
                return get_string('gradingdetailswithtotalpenalty', 'qbehaviour_amtchauer', $mark);
            } else {
                return get_string('gradingdetailswithpenalty', 'qbehaviour_amtchauer', $mark);
            }
        }

        return $output;
    }*/

    /**
     * Display information about a disregarded (incomplete) response.
     */
   /* protected function disregarded_info() {
        return get_string('disregardedwithoutpenalty', 'qbehaviour_amtchauer');
    }*/
}
