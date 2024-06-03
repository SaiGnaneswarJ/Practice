<?php

namespace Kensium\File\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Helper\Image;

/**
 * Class Resize
 * @package Kensium\File\Block
 */
class Resize extends Template
{
    protected $_productRepository;
    protected $_productImageHelper;

    /**
     * Resize constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param ProductRepository $productRepository
     * @param Image $productImageHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        ProductRepository $productRepository,
        Image $productImageHelper,
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
     * @param $width
     * @param null $height
     * @return Image
     */
    public function resizeImage($product, $imageId, $width, $height = null)
    {
        $resizedImage = $this->_productImageHelper
            ->init($product, $imageId)
            ->constrainOnly(TRUE)
            ->keepAspectRatio(TRUE)
            ->keepTransparency(TRUE)
            ->keepFrame(FALSE)
            ->resize($width, $height);
        return $resizedImage;
    }
}
