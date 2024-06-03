<?php

namespace Kensium\File\Block;

/**
 * Class Category
 * @package Kensium\File\Block
 */
class Category extends \Magento\Framework\View\Element\Template
{
    protected $_categoryCollectionFactory;
    protected $_productRepository;
    protected $_imageHelper;

    /**
     * Category constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Helper\Image $imageHelper,
        array $data = []
    )
    {
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_productRepository = $productRepository;
        $this->_imageHelper = $imageHelper;
        parent::__construct($context, $data);
    }

    /**
     * @param bool $isActive
     * @param bool $level
     * @param bool $sortBy
     * @param bool $pageSize
     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCategoryCollection($isActive = true, $level = false, $sortBy = false, $pageSize = false)
    {
        $collection = $this->_categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');

        if ($isActive) {
            $collection->addIsActiveFilter();
        }

        if ($level) {
            $collection->addLevelFilter($level);
        }

        if ($sortBy) {
            $collection->addOrderField($sortBy);
        }

        if ($pageSize) {
            $collection->setPageSize($pageSize);
        }

        return $collection;
    }

    /**
     * @param $id
     * @return \Magento\Catalog\Api\Data\ProductInterface|mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductById($id)
    {
        return $this->_productRepository->getById($id);
    }

    /**
     * @param $product
     * @return string
     */
    public function getProductImageUrl($product)
    {
        return $this->_imageHelper->init($product, 'product_page_image_small')->getUrl();
    }
}

?>
