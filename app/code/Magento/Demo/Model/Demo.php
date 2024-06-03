<?php
namespace Magento\Demo\Model;

use Magento\Framework\Model\AbstractModel;

class Demo extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Magento\Demo\Model\ResourceModel\Demo');
    }
}
