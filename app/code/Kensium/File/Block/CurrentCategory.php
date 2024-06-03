<?php

namespace Kensium\File\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;

/**
 * Class CurrentCategory
 * @package Kensium\File\Block
 */
class CurrentCategory extends \Magento\Framework\View\Element\Template
{
    protected $registry;
    protected $categoryFactory;
    protected $productRepository;

    /**
     * CurrentCategory constructor.
     * @param Context $context
     * @param Registry $registry
     * @param CategoryFactory $categoryFactory
     * @param ProductRepositoryInterface $productRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        CategoryFactory $categoryFactory,
        ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->categoryFactory = $categoryFactory;
        $this->productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function getCurrentProductCategories()
    {
        $product = $this->registry->registry('current_product');

        if ($product) {
            $categoryIds = $product->getCategoryIds();
            $categories = [];

            foreach ($categoryIds as $categoryId) {
            $category = $this->categoryFactory->create()->load($categoryId);
            $categories[] = $category;
            }

            return $categories;
        }

        return [];
    }

    /**
     * @return mixed
     */
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getRelatedProducts()
    {
        $product = $this->getCurrentProduct();
        if ($product) {
            $relatedProductIds = $product->getRelatedProductIds();
            $relatedProducts = [];

            foreach ($relatedProductIds as $relatedProductId) {
                $relatedProducts[] = $this->productRepository->getById($relatedProductId);
            }

            return $relatedProducts;
        }
        return [];
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getUpSellProducts(){
        $product = $this->getCurrentProduct();
        if ($product) {
            $UpSellProductIds = $product->getUpSellProductIds();
            $UpSellProducts = [];

            foreach ($UpSellProductIds as $relatedProductId) {
                $relatedProducts[] = $this->productRepository->getById($relatedProductId);
            }

            return $UpSellProducts;
        }
        return [];
    }
}
