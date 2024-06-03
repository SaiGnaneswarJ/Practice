<?php

namespace Kensium\File\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Catalog\Model\Product\Visibility as ProductVisibility;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Data\Form\FormKey;

/**
 * Class FeaturedProducts
 * @package Kensium\File\Block
 */
class FeaturedProducts extends Template
{
    protected $_productCollectionFactory;
    protected $_catalogProductVisibility;
    protected $_formKey;

    /**
     * FeaturedProducts constructor.
     * @param Template\Context $context
     * @param ProductCollectionFactory $productCollectionFactory
     * @param ProductVisibility $catalogProductVisibility
     * @param FormKey $formKey
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ProductCollectionFactory $productCollectionFactory,
        ProductVisibility $catalogProductVisibility,
        FormKey $formKey,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_catalogProductVisibility = $catalogProductVisibility;
        $this->_formKey = $formKey;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProductCollection()
    {
        $visibleProducts = $this->_catalogProductVisibility->getVisibleInCatalogIds();
        $collection = $this->_productCollectionFactory->create()->setVisibility($visibleProducts);
        $collection->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('featured', '1');
        return $collection;
    }

    /**
     * @param $product
     * @return string
     */
    public function getAddToCartUrl($product)
    {
        return $this->getUrl('checkout/cart/add', ['product' => $product->getId()]);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getFormKey()
    {
        return $this->_formKey->getFormKey();
    }
}
