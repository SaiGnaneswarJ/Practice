<?php
namespace Magento\Order\Model;

use Magento\Framework\Model\AbstractModel;

class Order extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Magento\Order\Model\ResourceModel\Order');
    }
}
