<?php

namespace Magento\Operation\Model\ResourceModel\Operation;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magento\Operation\Model\Demo', 'Magento\Operation\Model\ResourceModel\Demo');
    }
}
