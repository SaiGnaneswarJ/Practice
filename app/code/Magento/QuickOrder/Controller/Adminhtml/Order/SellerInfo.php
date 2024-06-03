<?php

namespace Magento\QuickOrder\Controller\Adminhtml\Order;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class SellerInfo
 * @package Magento\QuickOrder\Controller\Adminhtml\Order
 */
class SellerInfo extends Action
{
    protected $resultPageFactory;

    /**
     * SellerInfo constructor.
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Seller Information'));
        return $resultPage;
    }
}
