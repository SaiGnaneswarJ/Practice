<?php

namespace Kensium\File\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Form
 * @package Kensium\File\Block
 */
class Form extends Template
{
    /**
     * Form constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return 'Kensium_File::form.phtml';
    }
}
