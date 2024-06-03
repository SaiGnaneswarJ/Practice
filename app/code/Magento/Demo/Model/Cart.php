<?php

namespace Magento\Demo\Model;

use Magento\Checkout\Model\Cart as ModelCart;

class Cart
{
    public function beforeAddProduct(
        ModelCart $subject,
        $productInfo,
        $requestInfo = null
    ) {
        $requestInfo['qty'] = 1;
        return array($productInfo, $requestInfo);
    }
}
