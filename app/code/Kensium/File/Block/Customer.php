<?php

namespace Kensium\File\Block;

use Magento\Framework\View\Element\Template;
use Kensium\File\Model\ResourceModel\Customer\CollectionFactory;
use Psr\Log\LoggerInterface;

class Customer extends Template
{
    protected $customerCollectionFactory;
    protected $logger;

    public function __construct(
        Template\Context $context,
        CollectionFactory $customerCollectionFactory,
        LoggerInterface $logger,
        array $data = []
    ) {
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->logger = $logger;
        parent::__construct($context, $data);
    }

    public function getCustomerCollection()
    {
        $customerCollection = $this->customerCollectionFactory->create();
        // Manually join the 'Order' table
        $customerCollection->getSelect()->joinLeft(
            ['order_table' => $customerCollection->getTable('Order')],
            'main_table.cust_id = order_table.cust_id',
            ['ord_id', 'order_item']
        );

        // Log the SQL query
        $sql = (string)$customerCollection->getSelect();
        $this->logger->info('Customer Collection Query: ' . $sql);

        // Log customer details
        foreach ($customerCollection as $customer) {
            if (function_exists('json_encode')) {
                // Use json_encode safely
                $jsonData = json_encode($customer->getData());
                $this->logger->info('Customer Data: ' . $jsonData);
            } else {
                // Handle the case where json_encode is not available
                $this->logger->error('json_encode function is not available.');
            }
        }

        return $customerCollection;
    }
}
