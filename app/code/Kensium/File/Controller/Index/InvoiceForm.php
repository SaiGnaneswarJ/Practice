<?php
namespace Kensium\File\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class InvoiceForm
 * @package Kensium\File\Controller\Index
 */
class InvoiceForm extends Action
{
    protected $resultPageFactory;
    protected $productReviews;
    protected $productCollectionFactory;

    /**
     * InvoiceForm constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory

    )
    {
        $this->resultPageFactory = $resultPageFactory;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {

        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
