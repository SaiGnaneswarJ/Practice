<?php
namespace Kensium\File\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class ProductReviews
 * @package Kensium\File\Model
 */
class ProductReviews extends AbstractModel
{
    protected $_storeManager;
    protected $_productFactory;
    protected $_ratingFactory;
    protected $_reviewFactory;

    /**
     * ProductReviews constructor.
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Review\Model\RatingFactory $ratingFactory
     * @param \Magento\Review\Model\ResourceModel\Review\CollectionFactory $reviewFactory
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Review\Model\RatingFactory $ratingFactory,
        \Magento\Review\Model\ResourceModel\Review\CollectionFactory $reviewFactory
    ) {
        $this->_storeManager = $storeManager;
        $this->_productFactory = $productFactory;
        $this->_ratingFactory = $ratingFactory;
        $this->_reviewFactory = $reviewFactory;
    }

    /**
     * @param $productId
     * @return \Magento\Review\Model\ResourceModel\Review\Collection
     */
    public function getReviewCollection($productId)
    {
        $collection = $this->_reviewFactory->create()
            ->addStatusFilter(\Magento\Review\Model\Review::STATUS_APPROVED)
            ->addEntityFilter('product', $productId)
            ->setDateOrder();

        // Join with review_detail table to fetch nickname
        $collection->getSelect()->join(
            ['detail_table' => $collection->getTable('review_detail')],
            'main_table.review_id = detail_table.review_id',
            ['nickname']
        );

        $collection->getSelect()->columns(['review_id' => 'main_table.review_id', 'entity_pk_value' => 'main_table.entity_pk_value']);

        return $collection;
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getRatingCollection()
    {
        $ratingCollection = $this->_ratingFactory->create()
            ->getResourceCollection()
            ->addEntityFilter('product')
            ->setPositionOrder()
            ->setStoreFilter($this->_storeManager->getStore()->getId())
            ->addRatingPerStoreName($this->_storeManager->getStore()->getId());

        return $ratingCollection;
    }
}
