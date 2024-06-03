<?php

namespace Magento\Demo\Model\ResourceModel\Demo;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magento\Demo\Model\Demo', 'Magento\Demo\Model\ResourceModel\Demo');
    }
}
