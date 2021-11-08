/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

define([
    'mage/utils/wrapper',
    'jquery',
    'Magento_Ui/js/modal/modal'
], function (wrapper, $, modal) {
    'use strict';

    return function (placeOrderAction) {
        return wrapper.wrap(placeOrderAction, function (originalAction, paymentData, redirectOnSuccess) {

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
            $("#modal-content").modal("openModal");
            return originalAction(paymentData, redirectOnSuccess);
        });
    };
});
