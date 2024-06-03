<?php

namespace Magento\Demo\Block;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Demo\Model\DemoFactory;

class Display extends Template
{
    protected $demoFactory;

    public function __construct(
        Context $context,
        DemoFactory $demoFactory
    )
    {
        $this->demoFactory = $demoFactory;
        parent::__construct($context);
    }


    public function getInformation(){
        $data = $this->demoFactory->create();
        return $data->getCollection();
    }
}
