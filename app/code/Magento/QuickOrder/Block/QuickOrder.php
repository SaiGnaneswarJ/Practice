<?php

namespace Magento\QuickOrder\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class QuickOrder
 * @package Magento\QuickOrder\Block
 */
class QuickOrder extends Template
{
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Return template file to render
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'Magento_QuickOrder::quickorder.phtml';
    }
}
