<?php

namespace Kensium\File\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Kensium\File\Model\ResourceModel\File\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class MassDelete
 * @package Kensium\File\Controller\Adminhtml\Index
 */
class MassDelete extends Action
{
    protected $collectionFactory;

    /**
     * MassDelete constructor.
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $collection = $this->collectionFactory->create();
        $selected = $this->getRequest()->getParam('selected');

        if (!empty($selected)) {
            try {
                foreach ($selected as $id) {
                    $item = $collection->getItemById($id);
                    if ($item) {
                        $item->delete();
                    }
                }
                $this->messageManager->addSuccessMessage(__('Selected items have been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        } else {
            $this->messageManager->addErrorMessage(__('Please select item(s) to delete.'));
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/index');
    }
}
