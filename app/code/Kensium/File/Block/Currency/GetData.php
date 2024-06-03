<?php

namespace Kensium\File\Block\Currency;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Directory\Model\Currency;

/**
 * Class Getdata
 * @package Kensium\File\Block\Currency
 */
class GetData extends Template
{
    protected $storeManager;
    protected $currency;

    /**
     * Getdata constructor.
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param Currency $currency
     * @param array $data
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        Currency $currency,
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->currency = $currency;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Store\Api\Data\StoreInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCurrentStore()
    {
        return $this->storeManager->getStore();
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBaseCurrencyCode()
    {
        return $this->getCurrentStore()->getBaseCurrencyCode();
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCurrentCurrencyCode()
    {
        return $this->getCurrentStore()->getCurrentCurrencyCode();
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getDefaultCurrencyCode()
    {
        return $this->getCurrentStore()->getDefaultCurrencyCode();
    }

    /**
     * @param bool $BaseNotAllowed
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getAvailableCurrencyCodes($BaseNotAllowed = false)
    {
        return $this->getCurrentStore()->getAvailableCurrencyCodes($BaseNotAllowed);
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getAllowedCurrencies()
    {
        return $this->getCurrentStore()->getAllowedCurrencies();
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCurrentCurrencyRate()
    {
        return $this->getCurrentStore()->getCurrentCurrencyRate();
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCurrentCurrencySymbol()
    {
        $currencyCode = $this->getCurrentCurrencyCode();
        return $this->currency->load($currencyCode)->getCurrencySymbol();
    }

}
