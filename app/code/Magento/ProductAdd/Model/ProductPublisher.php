<?php

namespace Magento\ProductAdd\Model;

use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Framework\MessageQueue\PublisherInterface;


/**
 * Class ProductPublisher
 * @package Magento\ProductAdd\Model
 */
class ProductPublisher
{

    /**
     * @var JsonHelper
     */
    private $jsonHelper;

    /**
     * @var PublisherInterface
     */
    private $publisher;

    /**
     * ProductPublisher constructor.
     * @param JsonHelper $jsonHelper
     * @param PublisherInterface $publisher
     */
    public function __construct(
        JsonHelper $jsonHelper,
        PublisherInterface $publisher
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->publisher = $publisher;
    }

//    const TOPIC_NAME = 'product.add';

    /**
     * @param $productData
     * @return array
     */
    public function execute($productData)
    {
        print_r($productData);
//
//        $this->publisher->publish('product.add', $productData);
//        exit;

        try {


//            $jsonData = $this->jsonHelper->jsonEncode($productData);
//
//            echo $jsonData;
////            exit;

            $topicName = 'product.add';

            echo "coming here";

            $this->publisher->publish($topicName, $productData);

            echo "coming after here";

            return ['msg' => 'success'];

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
