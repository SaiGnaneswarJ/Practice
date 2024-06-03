<?php
namespace Magento\NewProduct\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Helper\Image as ImageHelper;

class NewProducts extends \Magento\Framework\View\Element\Template
{
    protected $productCollectionFactory;
    protected $imageHelper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        CollectionFactory $productCollectionFactory,
        ImageHelper $imageHelper,
        array $data = []
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->imageHelper = $imageHelper;
        parent::__construct($context, $data);
    }


    public function getProductCollection()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*')
            ->addAttributeToFilter('newly_added', 1)
            ->setPageSize($this->getProductsCount()); 
        return $collection;
    }


    public function getProductImage($product)
    {
        // Get the product image URL
        return $this->imageHelper->init($product, 'product_page_image_small')->getUrl();
    }
}
