<?php
namespace Magento\QuickOrder\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\CatalogInventory\Api\StockStateInterface;

/**
 * Class Search
 * @package Magento\QuickOrder\Controller\Index
 */
class Search extends Action
{
    protected $productFactory;
    protected $jsonResultFactory;
    protected $stockState; 

    public function __construct(
        Context $context,
        ProductFactory $productFactory,
        JsonFactory $jsonResultFactory,
        StockStateInterface $stockState 
    ) {
        parent::__construct($context);
        $this->productFactory = $productFactory;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->stockState = $stockState; 
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $query = $this->getRequest()->getParam('query');
        $pageSize = $this->getRequest()->getParam('limit', 10);

        $products = $this->productFactory->create()->getCollection()
            ->addAttributeToSelect(['name', 'sku', 'price', 'image'])
            ->addAttributeToFilter([
                ['attribute' => 'name', 'like' => '%' . $query . '%'],
                ['attribute' => 'sku', 'like' => '%' . $query . '%']
            ])
            ->setPageSize($pageSize)
            ->setCurPage(1);

        $responseData = [];
        foreach ($products as $product) {
            $productData = [
                'entity_id' => $product->getId(),
                'name' => $product->getName(),
                'sku' => $product->getSku(),
                'price' => $product->getPrice(),
                'image_url' => $this->getImageUrl($product),
                'quantity' => $this->getProductQuantity($product),
                'status' => $this->getProductStatus($product) 
            ];
            $responseData[] = $productData;
        }

        $result = $this->jsonResultFactory->create();
        $result->setData(['products' => $responseData]);
        return $result;
    }

    /**
     * @param $product
     * @return null
     */
    private function getImageUrl($product)
    {
        if ($product->getImage()) {
            return $product->getMediaConfig()->getMediaUrl($product->getImage());
        }
        return null;
    }

    /**
     * Get product quantity using StockStateInterface
     * @param $product
     * @return int|null
     */
    private function getProductQuantity($product)
    {
        try {
            return $this->stockState->getStockQty($product->getId(), $product->getStore()->getWebsiteId());
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get product status based on quantity
     * @param $product
     * @return string
     */
    private function getProductStatus($product)
    {
        $quantity = $this->getProductQuantity($product);
        return $quantity > 0 ? 'In Stock' : 'Out of Stock';
    }
}
