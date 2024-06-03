define(['jquery', 'mage/translate'], function($, $t) {
    'use strict';

    return function(targetWidget) {
        $.validator.addMethod(
            'myvalidationrule',
            function(value, element) {
                if ($.trim(value) === '' || value === 0) {
                    return false;
                }
                return true;
            },
            function(value, element) {
                if ($.trim(value) === '' || value === 0) {
                    return $t('This is a required field');
                }

                return undefined;
            }
        );

        return targetWidget;
    };
});
