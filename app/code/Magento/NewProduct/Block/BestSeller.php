<?php

namespace Magento\NewProduct\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory as BestSellersCollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Helper\Image;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\Data\Form\FormKey;

/**
 * Class BestSeller
 * @package Magento\NewProduct\Block
 */
class BestSeller extends Template
{
    protected $_bestSellersCollectionFactory;
    protected $_productCollectionFactory;
    protected $_storeManager;
    protected $_imageHelper;
    protected $_urlBuilder;
    protected $formKey;

    /**
     * BestSeller constructor.
     * @param Context $context
     * @param CollectionFactory $productCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param BestSellersCollectionFactory $bestSellersCollectionFactory
     * @param Image $imageHelper
     * @param UrlInterface $urlBuilder
     * @param FormKey $formKey
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        StoreManagerInterface $storeManager,
        BestSellersCollectionFactory $bestSellersCollectionFactory,
        Image $imageHelper,
        UrlInterface $urlBuilder,
        FormKey $formKey,
        array $data = []
    ) {
        $this->_bestSellersCollectionFactory = $bestSellersCollectionFactory;
        $this->_storeManager = $storeManager;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_imageHelper = $imageHelper;
        $this->_urlBuilder = $urlBuilder;
        $this->formKey = $formKey;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    /**
     * @param null $startDate
     * @param null $endDate
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProductCollection($startDate = null, $endDate = null)
    {
        $productIds = [];
        $bestSellers = $this->_bestSellersCollectionFactory->create()
            ->setDateRange($startDate, $endDate);

        foreach ($bestSellers as $product) {
            $productIds[] = $product->getProductId();
        }

        $collection = $this->_productCollectionFactory->create()->addIdFilter($productIds);
        $collection->addAttributeToSelect(["name", "price", "image"]);
        $collection->setPageSize(count($productIds));
        return $collection;
    }

    /**
     * @param $product
     * @param string $imageType
     * @return string
     */
    public function getImageUrl($product, $imageType = '')
    {
        return $this->_imageHelper->init($product, $imageType)->getUrl();
    }

    /**
     * @param $product
     * @return string
     */
    public function getAddToCartUrl($product)
    {
        return $this->_urlBuilder->getUrl('checkout/cart/add', ['product' => $product->getId()]);
    }


    /**
     * @param \Magento\Catalog\Model\Product $product
     * @return array
     */
    public function getAddToCartPostParams(\Magento\Catalog\Model\Product $product)
    {
        $url = $this->getAddToCartUrl($product);
        return [
            'action' => $url,
            'data' => [
                'product' => (int) $product->getEntityId(),
                ActionInterface::PARAM_NAME_URL_ENCODED =>
                    $this->_urlBuilder->getEncodedUrl($url),
            ]
        ];
    }
}
