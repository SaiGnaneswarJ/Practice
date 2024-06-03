<?php

namespace Magento\Operation\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Operation\Model\OperationFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;

class Delete extends Action
{
    protected $resultPageFactory;
    protected $operationFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        OperationFactory $operationFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->operationFactory = $operationFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $data = (array)$this->getRequest()->getParams();
            if (isset($data['id'])) {
                $model = $this->operationFactory->create()->load($data['id']);
                $model->delete();
                $this->messageManager->addSuccessMessage(__("Record Deleted Successfully."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("We can't delete the record, Please try again."));
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('operation/index/viewdata');

        return $resultRedirect;
    }
}
