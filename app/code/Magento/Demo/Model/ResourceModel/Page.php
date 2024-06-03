<?php

namespace Magento\Demo\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Page extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('cms_page', 'page_id');
    }

    public function getSubTitleByPageId($pageId)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->
        from($this->getMainTable(), 'sub_title')->
        where('page_id = ?', $pageId);
        return $connection->fetchOne($select);
    }
}
