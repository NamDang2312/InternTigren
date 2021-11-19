/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */
define(['jquery'], function ($) {
    'use strict';
    $.widget('tigren.countdown', {
        options: {
            endTime: null
        },
        _create: function () {

            var countDownDate = new Date(this.options.endTime).getTime();

            var x = setInterval(function () {
                // Get today's date and time
                var now = new Date().getTime();
                // Find the distance between now and the count down date
                var distance = countDownDate - now;
                var days = Math.floor(distance /
                    (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 *
                    60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance
                    % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance
                    % (1000 * 60)) / 1000);
                // Display the result in the element with
                var id = "demo";
                document.getElementById("demo").innerHTML = days + "d " +
                    hours + "h "
                    + minutes + "m " + seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML
                        = "EXPIRED";
                }
            }, 1000);
        },
    })
    return $.tigren.countdown;
})
