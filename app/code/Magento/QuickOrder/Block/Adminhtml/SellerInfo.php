<?php

namespace Magento\QuickOrder\Block\Adminhtml;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;

/**
 * Class SellerInfo
 * @package Magento\QuickOrder\Block\Adminhtml
 */
class SellerInfo extends Template
{
    protected $registry;

    /**
     * SellerInfo constructor.
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
    }

    /**
     * @return null
     */
    public function getSellerInfo()
    {
        $order = $this->registry->registry('current_order');

        if ($order && $order->getId()) {

            return $order->getData('seller');
        }

        return null;
    }
}
