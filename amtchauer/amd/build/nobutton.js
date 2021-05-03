define(['jquery'], function($) { // Moodle needs this to recognise $ https://docs.moodle.org/dev/jQuery .
    // JQuery is available via $.

    return {
        init: function () {
            var prevButt = document.getElementsByName("previous");
            if(prevButt) prevButt.item(0).setAttribute("hidden", "true");
        }
    }
});