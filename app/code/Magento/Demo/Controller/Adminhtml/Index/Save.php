<?php

namespace Magento\Demo\Controller\adminhtml\Index;

use Magento\Demo\Model\DemoFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\View\Result\PageFactory;

class Save extends Action
{

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        DemoFactory $DemoFactory,
        Validator $formKeyValidator
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->DemoFactory = $DemoFactory;
        $this->formKeyValidator = $formKeyValidator;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultPageFactory = $this->resultRedirectFactory->create();
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            $this->messageManager->addErrorMessage(__("Form key is Invalidate"));
            return $resultPageFactory->setPath('*/*/index');
        }
        $data = $this->getRequest()->getPostValue();
        try {
            if ($data) {
                $model = $this->DemoFactory->create();
                $model->setData($data)->save();

                // creating the event dispatch after saving
                $this->_eventManager->dispatch('demo_form_submit', ['data' => $data]);


                $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));

                return $resultPageFactory->setPath('*/*/index');
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can't submit your request, Please try again."));
        }
        return $resultPageFactory->setPath('*/*/index');
    }
}
