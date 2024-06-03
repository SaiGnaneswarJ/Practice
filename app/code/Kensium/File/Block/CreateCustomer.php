<?php

namespace Kensium\File\Block;

/**
 * Class CreateCustomer
 * @package Kensium\File\Block
 */
class CreateCustomer extends \Magento\Framework\View\Element\Template
{
    protected $storeManager;
    protected $customerFactory;
    protected $addressFactory;
    protected $logger;

    /**
     * CreateCustomer constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param \Magento\Customer\Model\AddressFactory $addressFactory
     * @param \Kensium\File\Logger\Logger $logger
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Model\AddressFactory $addressFactory,
        \Kensium\File\Logger\Logger $logger,
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->customerFactory = $customerFactory;
        $this->addressFactory = $addressFactory;
        $this->logger = $logger;
        parent::__construct($context, $data);
    }

    /**
     * @param $data
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function createCustomer($data) {
        $store = $this->storeManager->getStore();
        $websiteId = $store->getWebsiteId();

        $customer = $this->customerFactory->create();
        $customer->setWebsiteId($websiteId);
        $customer->loadByEmail($data['customer']['email']);

        if (!$customer->getId()) {
            $customer->setWebsiteId($websiteId)
                ->setStore($store)
                ->setFirstname($data['customer']['firstname'])
                ->setLastname($data['customer']['lastname'])
                ->setPrefix($data['customer']['prefix'])
                ->setEmail($data['customer']['email'])
                ->setPassword($data['customer']['password']);
            $customer->save();

            if (isset($data['address'])) {
                $this->saveCustomerAddress($customer, $data['address']);
            }

            $this->logger->notice('Customer created successfully: ' . $data['customer']['email']);
            return "Customer created successfully.";
        } else {
            $this->logger->notice('Customer already exists: ' . $data['customer']['email']);
            return "Customer already exists.";
        }
    }

    /**
     * @param $customer
     * @param $addressData
     * @throws \Exception
     */
    protected function saveCustomerAddress($customer, $addressData) {
        $address = $this->addressFactory->create();
        $address->setCustomerId($customer->getId())
            ->setFirstname($customer->getFirstname())
            ->setLastname($customer->getLastname())
            ->setCountryId($addressData['country_id'])
            ->setPostcode($addressData['postcode'])
            ->setCity($addressData['city'])
            ->setTelephone($addressData['telephone'])
            ->setStreet($addressData['street'])
            ->setIsDefaultBilling(isset($addressData['default_billing']) ? $addressData['default_billing'] : false)
            ->setIsDefaultShipping(isset($addressData['default_shipping']) ? $addressData['default_shipping'] : false);

        $address->save();
    }
}
