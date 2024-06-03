<?php

namespace Magento\ProductAdd\Api;

interface ProductApiInterface
{
    /**
     * Create a new product.
     *
     * @param string $name
     * @param string $sku
     * @param float $price
     * @param int $quantity
     * @return string
     */
    public function createProduct($name, $sku, $price, $quantity);
}
