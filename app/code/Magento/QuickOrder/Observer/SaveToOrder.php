<?php
namespace Magento\QuickOrder\Observer;

/**
 * Class SaveToOrder
 * @package Magento\QuickOrder\Observer
 */
class SaveToOrder implements \Magento\Framework\Event\ObserverInterface
{   
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $event = $observer->getEvent();
        $quote = $event->getQuote();
    	$order = $event->getOrder();
           $order->setData('seller', $quote->getData('seller'));
    }
}

