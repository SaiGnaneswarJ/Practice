<?php

namespace Kensium\File\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Data\Form\FormKey;

/**
 * Class View
 * @package Kensium\File\Block
 */
class View extends Template
{
    protected $_productCollectionFactory;
    protected $_formKey;

    /**
     * View constructor.
     * @param Template\Context $context
     * @param ProductCollectionFactory $productCollectionFactory
     * @param FormKey $formKey
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ProductCollectionFactory $productCollectionFactory,
        FormKey $formKey,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_formKey = $formKey;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProductCollection()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*')
            ->addAttributeToFilter('newly_added', 1)
            ->setPageSize($this->getProductsCount());
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
