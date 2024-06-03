<?php
namespace Magento\Operation\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Operation extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('Person_Operation', 'id');
    }
}

