<?php

namespace Kensium\File\Model\Product\Type;

/**
 * Class NewProductType
 * @package Kensium\File\Model\Product\Type
 */
class NewProductType extends \Magento\Catalog\Model\Product\Type\AbstractType
{

    const TYPE_CODE= 'kensium_product';

    /**
     * @param \Magento\Catalog\Model\Product $product
     */
    public function deleteTypeSpecificData(\Magento\Catalog\Model\Product $product)
    {

    }
}
