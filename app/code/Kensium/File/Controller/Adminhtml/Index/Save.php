<?php

namespace Kensium\File\Controller\Adminhtml\Index;

use Kensium\File\Model\FileFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Data\Form\FormKey\Validator;

class Save extends Action
{
    protected $resultPageFactory;
    protected $fileFactory;
    protected $formKeyValidator;

    public function __construct(
        Context $context,
        FileFactory $fileFactory,
        Validator $formKeyValidator,
        ResultFactory $resultFactory
    ) {
        $this->fileFactory = $fileFactory;
        $this->formKeyValidator = $formKeyValidator;
        $this->resultFactory = $resultFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        if (!$this->formKeyValidator->validate($this->getRequest())) {
            $this->messageManager->addErrorMessage(__("Form key is invalid"));
            return $resultRedirect->setPath('*/*/index');
        }

        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            return $resultRedirect->setPath('*/*/index');
        }

        try {
            $model = $this->fileFactory->create();
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }
            $model->setData($data)->save();
            $this->messageManager->addSuccessMessage(__("Data saved successfully."));

            $buttonData = $this->getRequest()->getParam('back');
            if ($buttonData == 'add') {
                return $resultRedirect->setPath('*/*/form');
            } elseif ($buttonData == 'close') {
                return $resultRedirect->setPath('*/*/index');
            }

            return $resultRedirect->setPath('*/*/form', ['id' => $model->getId()]);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("We can't submit your request, Please try again."));
            return $resultRedirect->setPath('*/*/index');
        }
    }
}
