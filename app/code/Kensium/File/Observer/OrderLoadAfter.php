<?php

namespace Kensium\File\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Sales\Api\Data\OrderExtensionFactory;

class OrderLoadAfter implements ObserverInterface
{
    protected $orderExtensionFactory;

    public function __construct(OrderExtensionFactory $orderExtensionFactory)
    {
        $this->orderExtensionFactory = $orderExtensionFactory;
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getOrder();
        $extensionAttributes = $order->getExtensionAttributes();

        if ($extensionAttributes === null) {
            $extensionAttributes = $this->orderExtensionFactory->create();
        }

        $attr = $order->getData('custom_attribute');
        $extensionAttributes->setCustomAttribute($attr);
        $order->setExtensionAttributes($extensionAttributes);
    }
}

