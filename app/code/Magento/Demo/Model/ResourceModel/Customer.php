<?php

namespace Magento\Demo\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Customer extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('customer_entity', 'entity_id');
    }

    public function getCustomFieldByCustomerId($customerId)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->
        from($this->getMainTable(), 'my_custom_field')->
        where('entity_id = ?', $customerId);
        return $connection->fetchOne($select);

    }
}
