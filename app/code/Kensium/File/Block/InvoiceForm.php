<?php

namespace Kensium\File\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class InvoiceForm
 * @package Kensium\File\Block
 */
class InvoiceForm extends Template
{
    /**
     * InvoiceForm constructor.
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
        return 'Kensium_File::invoive_form.phtml';
    }
}
