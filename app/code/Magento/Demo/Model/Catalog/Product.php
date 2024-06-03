<?php

namespace Magento\Demo\Model\Catalog;

class Product extends \Magento\Catalog\Model\Product
{

    public function getName()
    {
        // logging to test override
        $logger = \Magento\Framework\App\ObjectManager::getInstance()->get('\Psr\Log\LoggerInterface');
        $logger->debug('Overriding the model and getting the product name');

        return $this->_getData(self::NAME);
    }
}
?>