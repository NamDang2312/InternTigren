/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

define(['jquery'], function ($) {
    $(document).ready(function () {
        var x = setInterval(function () {  // Get today's date and time
            $('.hidden_countdown').each(function (){
                if($(this).text().length != 0){
                    var countDownDate = new Date($(this).text()).getTime();
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
                    $(this).parent().find('.display_countdown').text(days + "Day " +
                        hours + "Hours "
                        + minutes + "Minutes " + seconds + "Secounds ");
                }
            })
        }, 1000);
    })
})
