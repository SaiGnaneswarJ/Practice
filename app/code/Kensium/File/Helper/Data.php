<?php

namespace Kensium\File\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Bundle\Model\Product\Type as BundleType;
use Magento\GroupedProduct\Model\Product\Type\Grouped;
use Magento\Catalog\Model\ProductFactory;

/**
 * Class Data
 * @package Kensium\File\Helper
 */
class Data extends AbstractHelper
{
    protected $bundleType;
    protected $groupedType;
    protected $productFactory;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param BundleType $bundleType
     * @param Grouped $groupedType
     * @param ProductFactory $productFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        BundleType $bundleType,
        Grouped $groupedType,
        ProductFactory $productFactory
    ) {
        $this->bundleType = $bundleType;
        $this->groupedType = $groupedType;
        $this->productFactory = $productFactory;
        parent::__construct($context);
    }

    /**
     * @param $id
     * @return bool|\Magento\Catalog\Model\Product
     */
    public function getBundleParentProduct($id)
    {
        $bundleProductIds = $this->bundleType->getParentIdsByChild($id);
        if (!empty($bundleProductIds)) {
            $productId = reset($bundleProductIds);
            $product = $this->productFactory->create()->load($productId);
            return $product;
        }
        return false;
    }

    /**
     * @param $id
     * @return bool|\Magento\Catalog\Model\Product
     */
    public function getGroupParentProduct($id)
    {
        $groupedProductIds = $this->groupedType->getParentIdsByChild($id);
        if (!empty($groupedProductIds)) {
            $productId = reset($groupedProductIds);
            $product = $this->productFactory->create()->load($productId);
            return $product;
        }
        return false;
    }
}
