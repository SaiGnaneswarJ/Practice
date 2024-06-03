<?php

namespace Magento\Operation\Block;

use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Operation\Model\ResourceModel\Operation\CollectionFactory;

class Viewdata extends Template
{

    public $collection;

    public function __construct(Context $context, CollectionFactory $collectionFactory, array $data = [])
    {
        $this->collection = $collectionFactory;
        parent::__construct($context, $data);
    }

    public function getCollection()
    {
        return $this->collection->create();
    }

    public function getDeleteAction()
    {
        return $this->getUrl('operation/index/delete',['_secure' => true]);
    }

    public function getEditAction()
    {
        return $this->getUrl('operation/index/index',['_secure' => true]);
    }


}
