<?php

namespace Magento\Demo\Plugin;

use Magento\Catalog\Model\Product;

class ProductNameModifier
{
    public function afterGetName(Product $product, $result)
    {
        if ($product->getSku() === 'MT07') {
            // Modify product name
            return "My Store " . $result;
        }
        return $result;
    }
}
