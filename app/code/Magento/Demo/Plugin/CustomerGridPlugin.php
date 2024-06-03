<?php

namespace Magento\Demo\Plugin;

use Magento\Demo\Model\ResourceModel\Customer;

class CustomerGridPlugin
{

    protected $customerResourceModel;

    public function __construct(
        Customer $customerResourceModel
    ) {
        $this->customerResourceModel = $customerResourceModel;
    }

    public function afterPrepareDataSource(
        \Magento\Customer\Ui\Component\Listing\Columns $subject,
        $result
    ) {
        if (isset($result['data']['items'])) {
            foreach ($result['data']['items'] as &$item) {
                $item['my_custom_field'] = $this->getCustomField($item['entity_id']);
            }
        }

        return $result;
    }

    protected function getCustomField($customerId)
    {
        $customField = $this->customerResourceModel->getCustomFieldByCustomerId($customerId);
        return $customField ? $customField : __('Not Available');
    }
}
