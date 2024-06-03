<?php
namespace Magento\Operation\Model;

use Magento\Framework\Model\AbstractModel;

class Operation extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Magento\Operation\Model\ResourceModel\Demo');
    }
}
