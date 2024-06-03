<?php

namespace Magento\Demo\Plugin;

use Magento\Catalog\Model\Product;

class SpecificProductPriceModifier
{
    public function afterGetPrice(Product $product, $result)
    {
        if($product->getSku() === '24-MB02')
        {
            $modifiedPrice = $result + 100;
            return $modifiedPrice;
        }

        return $result;
    }
}

