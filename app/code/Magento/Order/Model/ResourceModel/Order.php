<?php
namespace Magento\Order\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Order extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('sales_order_grid', 'entity_id');
    }
}
