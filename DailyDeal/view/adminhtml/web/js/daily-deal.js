/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */
define(['jquery'], function ($) {
    'use strict';
    $.widget('tigren.deal', {
        _create: function () {
            this.clickCheckBox();
            this.dealPriceChange();
            this.initProductChecked();
        },
        clickCheckBox: function () {
            var self = this;
            $('body').delegate('tbody tr', 'click', function () {
                var productId = $(this).find('.col-id').text().trim();
                var productName = $(this).find('.col-name').text().trim();
                var productPrice = $(this).find('.col-price').text().trim();
                var productQty = $(this).find('.col-quantity').text().trim();
                $(this).find('input').attr('checked', 'checked');
                $('#original_price').text(productPrice)
                $('#product_name').val(productName);
                $('#product_id').val(productId);
                $('#product_qty').text(productQty);
                $('#deal_price').val('');
                self.formatDiscount(productPrice, 0)
            })
        },
        dealPriceChange: function () {
            var self = this;
            $('#deal_price').keyup(function () {
                var dealPrice = $(this).val();
                var originalPrice = $('#original_price').text();
                self.formatDiscount(originalPrice, dealPrice);
            })
        },

        formatDiscount: function (originalPrice, dealPrice) {
            if (!dealPrice) {
                dealPrice = 0;
            }
            var valOriginalPrice = parseInt(originalPrice);
            var valDealPrice = parseInt(dealPrice);
            var disCount = valOriginalPrice - valDealPrice;
            var percentiDscount = disCount / valOriginalPrice * 100;
            $('#discount').text(disCount + '( - ' + percentiDscount + ' %)');
        },
        initProductChecked: function () {
            var self = this;
            var product = $('#product_id').val().trim();
            if (product) {
                $('tbody tr').each(function () {
                    if ($(this).find('.col-id').text().trim() === product) {
                        $(this).find('input').attr('checked', 'checked');
                        var productPrice = $(this).find('.col-price').text().trim();
                        var productQty = $(this).find('.col-quantity').text().trim();
                        var dealPrice = $('#deal_price').val().trim();
                        $('#original_price').text(productPrice)
                        $('#product_qty').text(productQty);
                        self.formatDiscount(productPrice, dealPrice);
                    }
                })
            }
        }
    })
    return $.tigren.deal;
})
