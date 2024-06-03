<?php
namespace Kensium\File\Block;

use Magento\Framework\View\Element\Template;
use Kensium\File\Model\ProductReviews;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Review\Model\RatingFactory;

/**
 * Class Product
 * @package Kensium\File\Block
 */
class Product extends Template
{
    protected $productReviews;
    protected $productCollectionFactory;
    protected $ratingFactory;

    public function __construct(
        Template\Context $context,
        ProductReviews $productReviews,
        ProductCollectionFactory $productCollectionFactory,
        RatingFactory $ratingFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productReviews = $productReviews;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->ratingFactory = $ratingFactory;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getAllProductsData()
    {
        $productCollection = $this->productCollectionFactory->create();
        $productsData = [];

        foreach ($productCollection as $product) {
            $productId = $product->getId();
            $reviewsData = [];
            $ratingsData = [];

            $reviewCollection = $this->productReviews->getReviewCollection($productId);
            foreach ($reviewCollection as $review) {
                $reviewsData[] = [
                    'review_id' => $review->getReviewId(),
                    'entity_pk_value' => $review->getEntityPkValue(),
                    'nickname' => $review->getNickname(),
                    'title' => $review->getTitle(),
                    'detail' => $review->getDetail(),
                ];
            }

            $ratingCollection = $this->ratingFactory->create()
                ->getResourceCollection()
                ->addEntityFilter('product')
                ->setPositionOrder()
                ->setStoreFilter($this->_storeManager->getStore()->getId())
                ->addRatingPerStoreName($this->_storeManager->getStore()->getId())
                ->load();

            foreach ($ratingCollection as $rating) {
                $ratingsData[] = [
                    'rating_id' => $rating->getRatingId(),
                    'value' => $rating->getValue(),
                ];
            }

            $productsData[] = [
                'id' => $productId,
                'sku' => $product->getSku(),
                'reviews' => $reviewsData,
                'ratings' => $ratingsData,
            ];
        }

        return $productsData;
    }
}
