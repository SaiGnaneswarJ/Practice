<?php

namespace Magento\Demo\Block;

use Magento\Framework\View\Element\Template;
use Magento\Cms\Model\Page as GPage;

class Page extends Template
{
    protected $_page;

    public function setPage(GPage $page)
    {
        $this->_page = $page;
    }

    public function getPage()
    {
        return $this->_page;
    }

    public function getPageTitle()
    {
        return $this->getPage()->getTitle();
    }

}
