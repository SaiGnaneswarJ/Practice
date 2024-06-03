<?php

namespace Magento\NewProduct\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\ActionInterface;
use Magento\Reports\Model\ResourceModel\Product\CollectionFactory as ProductsFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class MostViewed
 * @package Magento\NewProduct\Block
 */
class MostViewed extends Template
{
    protected $_productsFactory;
    protected $_storeManager;
    protected $_imageHelper;
    protected $formKey;
    protected $urlHelper;
    protected $_urlBuilder;

    /**
     * MostViewed constructor.
     * @param Template\Context $context
     * @param ProductsFactory $productsFactory
     * @param StoreManagerInterface $storeManager
     * @param ImageHelper $imageHelper
     * @param FormKey $formKey
     * @param UrlInterface $urlHelper
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ProductsFactory $productsFactory,
        StoreManagerInterface $storeManager,
        ImageHelper $imageHelper,
        FormKey $formKey,
        UrlInterface $urlHelper,
        UrlInterface $urlBuilder,
        array $data = []
    ) {
        $this->_productsFactory = $productsFactory;
        $this->_storeManager = $storeManager;
        $this->_imageHelper = $imageHelper;
        $this->formKey = $formKey;
        $this->urlHelper = $urlHelper;
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Reports\Model\ResourceModel\Product\Collection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductCollection()
    {
        $currentStoreId = $this->_storeManager->getStore()->getId();

        $collection = $this->_productsFactory->create()
            ->addAttributeToSelect('*')
            ->addViewsCount()
            ->setStoreId($currentStoreId)
            ->addStoreFilter($currentStoreId);

        return $collection;
    }


    /**
     * @param $product
     * @param $imageType
     * @return string
     */
    public function getImageUrl($product, $imageType)
    {
        return $this->_imageHelper->init($product, $imageType)->getUrl();
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
                'product' => (int) $product->getId(),
                ActionInterface::PARAM_NAME_URL_ENCODED =>
                    $this->urlHelper->getEncodedUrl($url),
            ]
        ];
    }
}
