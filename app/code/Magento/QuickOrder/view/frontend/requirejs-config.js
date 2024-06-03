var config = {
    map: {
        '*': {
            'sellerselect': 'Magento_QuickOrder/js/view/sellerselect',
        }
    },
    config: {
        mixins: {
            'Magento_Checkout/js/action/place-order': {
                'Magento_QuickOrder/js/order/place-order-mixin': true
            },
        }
    }
};
