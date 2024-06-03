<?php

namespace Magento\Operation\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Operation\Model\OperationFactory;

class Index extends Action
{
    protected $resultPageFactory;

    private $operationFactory;


    public function __construct(Context $context, PageFactory $resultPageFactory, OperationFactory $operationFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->operationFactory = $operationFactory;

    }

    public function isCorrectData()
    {
        if($id = $this->getRequest()->getParam('id'))
        {
            $model = $this->operationFactory->create();
            $model->load($id);
            if($model->getId())
            {
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    public function execute()
    {
        if ($this->isCorrectData()) {
            return $this->resultPageFactory->create();
        } else {
            $this->messageManager->addErrorMessage(__("Record Not Found"));
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setPath('practice/index/showdata');
            return $resultRedirect;
        }
    }

}
