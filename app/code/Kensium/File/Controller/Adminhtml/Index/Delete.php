<?php

namespace Kensium\File\Controller\Adminhtml\Index;

use Kensium\File\Model\FileFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Delete
 * @package Kensium\File\Controller\Adminhtml\Index
 */
class Delete extends Action
{
    protected $resultPageFactory;
    protected $fileFactory;

    /**
     * Delete constructor.
     * @param Context $context
     * @param FileFactory $fileFactory
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        Context $context,
        FileFactory $fileFactory,
        ResultFactory $resultFactory
    ) {
        $this->fileFactory = $fileFactory;
        parent::__construct($context);
        $this->resultFactory = $resultFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        try {
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model = $this->fileFactory->create()->load($id);
                if ($model->getId()) {
                    $model->delete();
                    $this->messageManager->addSuccessMessage(__("Record deleted successfully."));
                } else {
                    $this->messageManager->addErrorMessage(__("Record not found."));
                }
            } else {
                $this->messageManager->addErrorMessage(__("Invalid record identifier."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage(), __("An error occurred while deleting the record."));
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
