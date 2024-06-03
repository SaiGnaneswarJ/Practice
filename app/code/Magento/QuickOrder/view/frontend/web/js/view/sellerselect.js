define([
    'uiComponent'
], function (Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magento_QuickOrder/sellerselect'
        },

        initialize: function () {
            this._super();

            // Get seller value from local storage
            var seller = sessionStorage.getItem('selected_option');
            
            // Bind seller value to the template
            this.seller = seller || "No seller selected";

            // Set visibility based on whether seller is present
            this.isSellerPresent = !!seller;
        }
    });
});
