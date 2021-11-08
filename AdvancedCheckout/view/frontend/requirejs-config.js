/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */

var config = {
        map: {
            '*': {
                checkcart: 'Tigren_AdvancedCheckout/js/CheckCart',
                checkout:'Tigren_AdvancedCheckout/js/CheckOut'
            }
        },
        config:{
            mixins:{
                'Magento_Checkout/js/action/place-order': {
                    'Tigren_AdvancedCheckout/js/action/place-order-mixin': true
                }
            }
        }

};
