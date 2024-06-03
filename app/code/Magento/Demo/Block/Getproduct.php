<?php

namespace Magento\Demo\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image as ImageHelper;

class Getproduct extends Template
{
    protected $productRepository;
    protected $registry;
    protected $imageHelper;

    public function __construct(
        Template\Context $context,
        ProductRepositoryInterface $productRepository,
        Registry $registry,
        ImageHelper $imageHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productRepository = $productRepository;
        $this->registry = $registry;
        $this->imageHelper = $imageHelper;
    }

    public function getProductByIdFromRegistry($productId)
    {
        // Store the product ID in the registry
        $this->registry->unregister('current_product_id'); // Unregister previous value if exists
        $this->registry->register('current_product_id', $productId);

        // Retrieve the product details using the stored product ID
        return $this->productRepository->getById($productId);
    }

    public function getProductImage($product)
    {
        // Get the product image URL
        return $this->imageHelper->init($product, 'product_page_image_large')->getUrl();
    }
}
