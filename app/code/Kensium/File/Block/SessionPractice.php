<?php

namespace Kensium\File\Block;

use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Session as CustomerSession;

class SessionPractice extends Template
{
    protected $customerSession;

    public function __construct(
        Template\Context $context,
        CustomerSession $customerSession,
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    public function getCustomer()
    {
        return $this->customerSession->getCustomer();
    }

    public function getCustomerId()
    {
        return $this->customerSession->getCustomerId();
    }

    public function isLoggedIn()
    {
        return $this->customerSession->isLoggedIn();
    }
}
