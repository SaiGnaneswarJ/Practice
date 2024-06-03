<?php

namespace Magento\Operation\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Operation\Model\OperationFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;

class Submit extends Action
{
    protected $resultPageFactory;
    protected $practiceFactory;

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
            $data = (array)$this->getRequest()->getPost();
            if ($data) {
                $model = $this->operationFactory->create();
                $model->setData($data)->save();

                $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can't submit your request, Please try again."));
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('operation/index/viewdata');
        return $resultRedirect;
    }
}
