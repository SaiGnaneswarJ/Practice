<?php

namespace Kensium\File\Console\Command;

use Magento\Framework\App\State;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class UpdateStock
 * @package Kensium\File\Console\Command
 */
class UpdateStock extends Command
{
    const PRODUCT_ID = 'product_id';
    const QTY = 'qty';

    protected $productRepository;
    protected $stockRegistry;
    protected $state;

    /**
     * UpdateStock constructor.
     * @param State $state
     * @param ProductRepositoryInterface $productRepository
     * @param StockRegistryInterface $stockRegistry
     */
    public function __construct(
        State $state,
        ProductRepositoryInterface $productRepository,
        StockRegistryInterface $stockRegistry
    ) {
        $this->state = $state;
        $this->productRepository = $productRepository;
        $this->stockRegistry = $stockRegistry;
        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this->setName('stock:update')
            ->setDescription('Update product stock')
            ->addArgument(self::PRODUCT_ID, InputArgument::REQUIRED, 'Product ID')
            ->addArgument(self::QTY, InputArgument::REQUIRED, 'Quantity');
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);
            $productId = $input->getArgument(self::PRODUCT_ID);
            $qty = $input->getArgument(self::QTY);
            $product = $this->productRepository->getById($productId);
            $stockItem = $this->stockRegistry->getStockItemBySku($product->getSku());
            $stockItem->setQty($qty);
            $stockItem->setIsInStock((bool)$qty);
            $this->stockRegistry->updateStockItemBySku($product->getSku(), $stockItem);
            $output->writeln('Stock updated successfully.');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
