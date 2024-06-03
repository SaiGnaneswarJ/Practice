<?php
namespace Magento\Demo\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Demo extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('data_example', 'id');
    }
}

