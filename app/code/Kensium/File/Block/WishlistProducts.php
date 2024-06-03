<?php
namespace Kensium\File\Block;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\View\Element\Template;
use Magento\Wishlist\Model\ResourceModel\Item\CollectionFactory as WishlistItemCollectionFactory;
use Magento\Wishlist\Model\ResourceModel\Wishlist\CollectionFactory as WishlistCollectionFactory;

/**
 * Class WishlistProducts
 * @package Kensium\File\Block
 */
class WishlistProducts extends Template
{
    protected $_wishlistItemCollectionFactory;
    protected $_productCollectionFactory;
    protected $_catalogProductVisibility;
    protected $_dateTime;
    protected $_httpContext;
    protected $_wishlistCollectionFactory;
    protected $_customerRepository;

    /**
     * WishlistProducts constructor.
     * @param Context $context
     * @param ProductCollectionFactory $productCollectionFactory
     * @param Visibility $catalogProductVisibility
     * @param DateTime $dateTime
     * @param HttpContext $httpContext
     * @param WishlistItemCollectionFactory $wishlistItemCollectionFactory
     * @param WishlistCollectionFactory $wishlistCollectionFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProductCollectionFactory $productCollectionFactory,
        Visibility $catalogProductVisibility,
        DateTime $dateTime,
        HttpContext $httpContext,
        WishlistItemCollectionFactory $wishlistItemCollectionFactory,
        WishlistCollectionFactory $wishlistCollectionFactory,
        CustomerRepositoryInterface $customerRepository,
        array $data = []
    ) {
        $this->_wishlistItemCollectionFactory = $wishlistItemCollectionFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_catalogProductVisibility = $catalogProductVisibility;
        $this->_dateTime = $dateTime;
        $this->_httpContext = $httpContext;
        $this->_wishlistCollectionFactory = $wishlistCollectionFactory;
        $this->_customerRepository = $customerRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getWishlistProducts()
    {
        $wishlistCollection = $this->_wishlistCollectionFactory->create();
        $customerIds = $wishlistCollection->getColumnValues('customer_id');

        $customerProducts = [];

        foreach ($customerIds as $customerId) {
            $customer = $this->_customerRepository->getById($customerId);
            $customerName = $customer->getFirstname() . ' ' . $customer->getLastname();

            $wishlistItemCollection = $this->_wishlistItemCollectionFactory->create();

            $wishlistItemCollection->getSelect()->join(
                ['wishlist' => $wishlistItemCollection->getTable('wishlist')],
                'main_table.wishlist_id = wishlist.wishlist_id',
                []
            )->where('wishlist.customer_id = ?', $customerId);

            $productIds = [];
            foreach ($wishlistItemCollection as $wishlistItem) {
                $productIds[] = $wishlistItem->getProductId();
            }

            $productCollection = $this->_productCollectionFactory->create();
            $productCollection->addFieldToFilter('entity_id', ['in' => $productIds])
                ->addAttributeToSelect('*')
                ->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());

            $customerProducts[] = ['customer_id' => $customerId, 'customer_name' => $customerName, 'products' => $productCollection];
        }

        return $customerProducts;
    }
}
