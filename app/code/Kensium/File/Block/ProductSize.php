<?php

namespace Kensium\File\Block;

use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Helper\Image as ImageHelper;

/**
 * Class ProductSize
 * @package Kensium\File\Block
 */
class ProductSize extends Template
{
    protected $_productRepository;
    protected $_productImageHelper;

    /**
     * ProductSize constructor.
     * @param Context $context
     * @param ProductRepository $productRepository
     * @param ImageHelper $productImageHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProductRepository $productRepository,
        ImageHelper $productImageHelper,
        array $data = []
    )
    {
        $this->_productRepository = $productRepository;
        $this->_productImageHelper = $productImageHelper;
        parent::__construct($context, $data);
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
     * @param $imageId
     * @param array $attributes
     * @return string
     */
    public function getImageOriginalWidth($product, $imageId, $attributes = [])
    {
        return $this->_productImageHelper->init($product, $imageId, $attributes)->getWidth();
    }

    /**
     * @param $product
     * @param $imageId
     * @param array $attributes
     * @return string
     */
    public function getImageOriginalHeight($product, $imageId, $attributes = [])
    {
        return $this->_productImageHelper->init($product, $imageId, $attributes)->getHeight();
    }

    /**
     * @param $product
     * @return mixed
     */
    public function getProductName($product)
    {
        return $product->getName();
    }

    /**
     * @param $product
     * @return mixed
     */
    public function getProductSku($product)
    {
        return $product->getSku();
    }

    /**
     * @param $product
     * @return mixed
     */
    public function getProductFinalPrice($product)
    {
        return $product->getFinalPrice();
    }

    /**
     * @param $product
     * @param $imageId
     * @param array $attributes
     * @return string
     */
    public function getProductImageUrl($product, $imageId, $attributes = [])
    {
        return $this->_productImageHelper->init($product, $imageId, $attributes)->getUrl();
    }
}
