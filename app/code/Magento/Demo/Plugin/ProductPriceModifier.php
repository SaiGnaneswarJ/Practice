<?php

namespace Magento\Demo\Plugin;

use Magento\Catalog\Model\Product;

class ProductPriceModifier
{
    public function afterGetPrice(Product $product, $result)
    {
        $modifiedPrice = $result + 10; // Increase price by 10% for *,+,-
        return $modifiedPrice;
    }
}
