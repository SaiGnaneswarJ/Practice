<?php

namespace Kensium\File\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class File
 * @package Kensium\File\Model
 */
class File extends AbstractModel
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init('Kensium\File\Model\ResourceModel\File');
    }
}
