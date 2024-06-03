<?php

namespace Magento\QuickOrder\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class QuickOrder
 * @package Magento\QuickOrder\Controller\Index
 */
class QuickOrder extends Action
{
    protected $resultPageFactory;

    /**
     * QuickOrder constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
    $this->resultPageFactory = $resultPageFactory;
    parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
    return $this->resultPageFactory->create();
    }
}
