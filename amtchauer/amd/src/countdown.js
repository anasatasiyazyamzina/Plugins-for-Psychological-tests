/**
 * @module qbehaviour_lusherr/scripts
 */
define(['jquery'], function($) { // Moodle needs this to recognise $ https://docs.moodle.org/dev/jQuery .
    // JQuery is available via $.

    return {
        initialise: function(text) {

            // Module initialised.
            var nextButt = document.getElementsByName("next");
            nextButt.item(0).setAttribute("hidden","true");
            var answer_input = document.getElementsByClassName("ablock form-inline");
            var get_input = document.getElementsByClassName("form-control d-inline");

            answer_input.item(0).setAttribute("hidden","true");
            //нужно как-то обработать эту херню
            get_input[0].value = '1';

            function getTimeRemaining(endtime) {
                var t = Date.parse(endtime) - Date.parse(new Date());
                var seconds = Math.floor((t / 1000) % 60);
                var minutes = Math.floor((t / 1000 / 60) % 60);
                return {
                    'total': t,
                    'minutes': minutes,
                    'seconds': seconds
                };
            }

            function initializeClock(id, endtime) {
                /*var buttonNext=document.getElementById('butTT');
                buttonNext.hidden=true;*/

                var clock = document.getElementById("time");
                clock.hidden=false;
                var minutesSpan = clock.querySelector('.minutes');
                var secondsSpan = clock.querySelector('.seconds');

                function updateClock() {
                    var t = getTimeRemaining(endtime);

                    minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
                    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

                    if (t.total <= 0) {
                        clearInterval(timeinterval);
                        nextButt.item(0).click();
                    }
                }
                updateClock();
                var timeinterval = setInterval(updateClock, 1000);
            }


            var deadline = new Date(Date.parse(new Date()) + 3 * 60 * 1000); //интервал в 3 минуты между вопросами
            initializeClock('countdown', deadline);

        }
    };
});