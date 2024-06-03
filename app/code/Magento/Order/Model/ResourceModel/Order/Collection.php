<?php

namespace Magento\Order\Model\ResourceModel\Order;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magento\Order\Model\Order', 'Magento\Order\Model\ResourceModel\Order');
    }
}
