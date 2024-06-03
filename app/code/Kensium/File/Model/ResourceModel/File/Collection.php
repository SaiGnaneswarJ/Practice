<?php

namespace Kensium\File\Model\ResourceModel\File;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Kensium\File\Model\ResourceModel\File
 */
class Collection extends AbstractCollection
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init('Kensium\File\Model\File', 'Kensium\File\Model\ResourceModel\File');
    }
}
