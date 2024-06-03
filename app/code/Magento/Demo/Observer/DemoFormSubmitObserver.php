<?php

namespace Magento\Demo\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class DemoFormSubmitObserver implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $data = $observer->getEvent()->getData('data');

        $logger = \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class);
        $logger->info("Form data is successfully added - Data: " . print_r($data, true));
    }
}
