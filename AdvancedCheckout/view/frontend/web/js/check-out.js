/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

define(['jquery', 'mage/url', 'Magento_Ui/js/modal/modal'], function ($, urlBuilder, modal) {
    $(document).ready(function () {
        var options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            title: 'Pop-up title',
            buttons: [{
                text: $.mage.__('Clear cart'),
                class: 'Clear Cart',
                click: function () {
                    clearCart();
                }
            },
                {
                    text: $.mage.__('Go To Check'),
                    class: 'Go check',
                    click: function () {
                        location.replace("http://magento.localhost.com/checkout/cart/")
                    }
                }
            ]
        };
        modal(options, $('#modal-content'));
        $('button[class="checkout"]').on('click',function (event){
            event.preventDefault();
            alert('a');
        })
        alert('avcd')
    })
})
