<?php

namespace Kensium\File\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Quote\Model\QuoteFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Api\AddressRepositoryInterface;

class CreateOrder extends \Magento\Framework\View\Element\Template
{
    protected $storeManager;
    protected $quoteManagement;
    protected $customerRepository;
    protected $quoteFactory;
    protected $productRepository;
    protected $addressRepository;
    protected $shippingMethod;

    public function __construct(
        StoreManagerInterface $storeManager,
        CartManagementInterface $quoteManagement,
        CustomerRepositoryInterface $customerRepository,
        QuoteFactory $quoteFactory,
        ProductRepositoryInterface $productRepository,
        AddressRepositoryInterface $addressRepository,
        \Magento\Framework\View\Element\Template\Context $context
    )
    {
        $this->storeManager = $storeManager;
        $this->quoteManagement = $quoteManagement;
        $this->customerRepository = $customerRepository;
        $this->quoteFactory = $quoteFactory;
        $this->productRepository = $productRepository;
        $this->addressRepository = $addressRepository;

        parent::__construct($context);
    }

    public function setShippingMethod($shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;
        return $this;
    }

    public function createOrder(array $productSkus, string $customerEmail)
    {
        try {
            // Retrieve customer by email
            $customer = $this->customerRepository->get($customerEmail);
        } catch (NoSuchEntityException $e) {
            // Return error if customer not found
            return ['error' => 1, 'msg' => 'Customer not found with email: ' . $customerEmail];
        }

        // Create new quote
        $quote = $this->quoteFactory->create();
        $store = $this->storeManager->getStore();
        $quote->setStore($store);
        $quote->assignCustomer($customer);

        // Add products to quote
        foreach ($productSkus as $productSku) {
            try {
                $product = $this->productRepository->get($productSku);
                $quote->addProduct($product);
            } catch (NoSuchEntityException $e) {
                // Log or handle exception if product not found
            }
        }

        try {
            // Retrieve billing address
            $billingAddress = $this->addressRepository->getById($customer->getDefaultBilling());
            if ($billingAddress) {
                $quote->getBillingAddress()->importCustomerAddressData($billingAddress);
            }

            // Retrieve shipping address
            $shippingAddress = $this->addressRepository->getById($customer->getDefaultShipping());
            if ($shippingAddress) {
                $quote->getShippingAddress()->importCustomerAddressData($shippingAddress);
            }
        } catch (NoSuchEntityException $e) {
            // Log or handle exception if address not found
        }

        // Set payment method
        $quote->setPaymentMethod('checkmo');
        $quote->setInventoryProcessed(false);

        // Set shipping method
        if ($this->shippingMethod) {
            $quote->getShippingAddress()->setCollectShippingRates(true)->collectShippingRates()->setShippingMethod($this->shippingMethod);
        }

        // Save quote
        $quote->save();

        try {
            // Set sales order payment, collect totals, and save quote
            $quote->getPayment()->importData(['method' => 'checkmo']);
            $quote->collectTotals()->save();

            // Create order from quote
            $order = $this->quoteManagement->submit($quote);

            // Return success message with order increment ID
            return ['success' => 1, 'msg' => 'Order placed successfully. Order number: ' . $order->getIncrementId()];
        } catch (\Exception $e) {
            // Log or handle exception if order creation fails
            return ['error' => 1, 'msg' => 'Error placing order: ' . $e->getMessage()];
        }
    }
}
