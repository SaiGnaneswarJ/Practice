<?php

namespace Magento\ProductAdd\Model;

use Magento\Framework\MessageQueue\ConsumerInterface;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class ProductConsumer implements ConsumerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(
        LoggerInterface $logger,
        ProductRepositoryInterface $productRepository
    ) {
        $this->logger = $logger;
        $this->productRepository = $productRepository;
    }

    public function process($maxNumberOfMessages = null)
    {
        try {
            // Fetch messages from the queue
            // Process each message here
            $this->logger->info('Processing messages from the queue');
        } catch (\Exception $e) {
            $this->logger->error('Error while processing messages: ' . $e->getMessage());
        }
    }
}
