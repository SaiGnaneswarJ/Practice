<?php

namespace Kensium\File\Block;

use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Sales\Model\Order;


/**
 * Class Options
 * @package Kensium\File\Block
 */
class Options extends Template
{
    protected $_orderModel;

    /**
     * Options constructor.
     * @param Context $context
     * @param Order $orderModel
     * @param array $data
     */
    public function __construct(
        Context $context,
        Order $orderModel,
        array $data = []
    )
    {
        $this->_orderModel = $orderModel;
        parent::__construct($context, $data);
    }

    /**
     * @param $orderId
     * @return array
     */
    public function getOrderItems($orderId)
    {
        $order = $this->_orderModel->load($orderId);
        return $order->getAllVisibleItems();
    }
}

?>