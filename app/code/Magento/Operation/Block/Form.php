<?php

namespace Magento\Operation\Block;

use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Operation\Model\OperationFactory;

class Form extends Template
{
    private $operationFactory;

    public function __construct(Context $context, OperationFactory $operationFactory , array $data = [])
    {
        parent::__construct($context, $data);
        $this->operationFactory = $operationFactory;
    }

    public function getFormAction(){
        return $this->getUrl('operation/index/submit',['_secure' => true]);
    }

    public function getAllData()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->operationFactory->create();
        return $model->load($id);
    }
}
