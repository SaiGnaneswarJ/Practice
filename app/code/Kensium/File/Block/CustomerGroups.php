<?php

namespace Kensium\File\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory;

/**
 * Class CustomerGroups
 * @package Kensium\File\Block
 */
class CustomerGroups extends Template
{
    protected $customerGroupCollectionFactory;

    /**
     * CustomerGroups constructor.
     * @param Context $context
     * @param CollectionFactory $customerGroupCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $customerGroupCollectionFactory,
        array $data = []
    ) {
        $this->customerGroupCollectionFactory = $customerGroupCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     */
    public function getCustomerGroupCollection()
    {
        if (!$this->hasData('customer_group_collection')) {
            $collection = $this->customerGroupCollectionFactory->create();
            $this->setData('customer_group_collection', $collection);
        }
        return $this->getData('customer_group_collection');
    }
}
