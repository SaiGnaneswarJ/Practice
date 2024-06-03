<?php

namespace Kensium\File\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class File
 * @package Kensium\File\Model\ResourceModel
 */
class File extends AbstractDb
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init('data_example', 'id');
    }
}

