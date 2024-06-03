<?php

namespace Magento\ProductAdd\Model;

use Magento\ProductAdd\Api\ProductApiInterface;
use Magento\ProductAdd\Model\ProductPublisher;

/**
 * Class ProductApi
 * @package Magento\ProductAdd\Model
 *
 */
class ProductApi implements ProductApiInterface
{
    /**
     * @var ProductPublisher
     */
    private $productPublisher;

    /**
     * ProductApi constructor.
     * @param \Magento\ProductAdd\Model\ProductPublisher $productPublisher
     */
    public function __construct(
        ProductPublisher $productPublisher
    ) {
        $this->productPublisher = $productPublisher;
    }

    /**
     * @param string $name
     * @param string $sku
     * @param float $price
     * @param int $quantity
     * @return string
     */
    public function createProduct($name, $sku, $price, $quantity)
    {
        $productData = [
            'name' => $name,
            'sku' => $sku,
            'price' => $price,
            'quantity' => $quantity
        ];

        // Publish product data to RabbitMQ
        try {

            $this->productPublisher->execute($productData);

            return 'Product data published to RabbitMQ successfully.';
        }catch (\Exception $e){
            return $e->getMessage();
        }


//        print_r($productData);


    }
}

