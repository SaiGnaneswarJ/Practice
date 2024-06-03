<?php
namespace Magento\Demo\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Config extends Template
{
    protected $scopeConfig;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function getMessage()
    {
        // Retrieve message from configuration
        return $this->scopeConfig->getValue('demo/general/display_data', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
