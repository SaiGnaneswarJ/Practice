<?php
namespace Kensium\File\Model;

use Magento\Framework\Model\AbstractModel;

class Customer extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Kensium\File\Model\ResourceModel\Customer');
    }
}
