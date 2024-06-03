<?php

namespace Kensium\File\Block;

use Magento\Framework\View\Element\Template;

/**
 * Class CustomBlock
 * @package Kensium\File\Block
 */
class CustomBlock extends Template
{
    /**
     * @return string
     */
    public function getCustomData()
    {
        return "Custom data from Custom Block";
    }
}
