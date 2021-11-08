/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2021 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License ("OSL") v. 3.0
 */
define(['jquery', 'mage/url', 'Magento_Ui/js/modal/modal'], function ($, urlBuilder, modal) {
    $(document).ready(function () {
        $('.tocart').each(function (){
            $(this).on('click',function (event){
                event.preventDefault();
                var form = $(this).parent();
                var idProduct = $(this).parent().children('input[name="product"]').val();
                var url = urlBuilder.build('check/check/checkallowmultiorder');
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        idProduct: idProduct
                    }
                }).done(function (response) {
                    var localStore = JSON.parse(localStorage.getItem("mage-cache-storage"));
                    var countItem;
                    if (typeof (localStore['cart']) == "undefined") {
                        countItem = 1;
                    } else {
                        countItem = localStore['cart']['summary_count'];
                    }
                    if (parseInt(response.MultiOrder) == 0) {
                        if (!countItem) {
                          form.submit().ajaxSuccess(function () {})
                        } else {
                            $("#modal-content").modal("openModal");
                        }
                    } else {
                        form.submit().ajaxSuccess(function () {

                        })
                    }
                })
            })
        })
        function clearCart() {
            var url = urlBuilder.build('check/clear/clearcart');
            $.ajax({
                url: url,
                showLoader: true,
                success: function (res) {
                    localStorage.removeItem('mage-cache-storage')
                    location.reload();
                }
            })
        }
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

        $('#product-addtocart-button').on('click', function (event) {
            event.preventDefault();
            var id = $('input[name="product"]').val();
            var inputqty = $('input[name="qty"]').val();
            var url = urlBuilder.build('check/check/checkallowmultiorder');

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {
                    idProduct: id
                }
            }).done(function (response) {
                var localStore = JSON.parse(localStorage.getItem("mage-cache-storage"));
                var countItem;
                if (typeof (localStore['cart']) == "undefined") {
                    countItem = 1;
                } else {
                    countItem = localStore['cart']['summary_count'];
                }

                if (parseInt(response.MultiOrder) == 0) {
                    if (!countItem && parseInt(inputqty) == 1) {
                        $('#product_addtocart_form').submit().ajaxSuccess(function () {

                        })
                    } else {
                        $("#modal-content").modal("openModal");
                    }
                } else {
                    $('#product_addtocart_form').submit().ajaxSuccess(function () {

                    })
                }
            })
        })
    })
});
