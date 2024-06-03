<?php
namespace Magento\Demo\Block\Catalog\Product;

use Magento\Catalog\Model\Product as ProductModel;

class View extends \Magento\Catalog\Block\Product\View
{

    protected $detailsLogged = false;

    public function getProduct()
    {
        // Logging to test override
        $logger = \Magento\Framework\App\ObjectManager::getInstance()->get('\Psr\Log\LoggerInterface');
        $logger->debug('Overriding the block for the product view');

        // Retrieve the product
        $product = parent::getProduct();

        // Log product details if not already logged
        if (!$this->detailsLogged && $product instanceof ProductModel) {
            $logger->debug('Product ID: ' . $product->getId());
            $logger->debug('Product Name: ' . $product->getName());
            // Add more details as needed
            $this->detailsLogged = true; // Set the flag to true to indicate details have been logged
        }

        return $product;
    }
}
?>
