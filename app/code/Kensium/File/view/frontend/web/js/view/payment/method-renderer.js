define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'onlinepayment',
                component: 'Kensium_File/js/view/payment/method-renderer/onlinepayment'
            }
        );
        return Component.extend({});
    }
);
