<?php

namespace Kensium\File\Console\Command;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\State;
use Magento\Framework\App\Area;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateProduct
 * @package Kensium\File\Console\Command
 */
class UpdateProduct extends Command
{

    const STORE_ID = 'store_id';
    const PRODUCT_SKU = 'product_sku';
    const PRODUCT_NAME = 'product_name';
    const PRODUCT_PRICE = 'product_price';

    protected $productRepository;
    protected $storeManager;
    protected $state;

    /**
     * UpdateProduct constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param StoreManagerInterface $storeManager
     * @param State $state
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storeManager,
        State $state
    ) {
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
        $this->state = $state;
        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this->setName('kensium:update:product')
            ->setDescription('Update product name and price based on store ID and product SKU')
            ->addArgument(self::STORE_ID, InputArgument::REQUIRED, 'Store ID')
            ->addArgument(self::PRODUCT_SKU, InputArgument::REQUIRED, 'Product SKU')
            ->addArgument(self::PRODUCT_NAME, InputArgument::OPTIONAL, 'Product Name')
            ->addArgument(self::PRODUCT_PRICE, InputArgument::OPTIONAL, 'Product Price');
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
            $this->state->setAreaCode(Area::AREA_GLOBAL);
        } catch (LocalizedException $e) {
            // Area code was already set, no action needed
        }

        try {
            $storeId = $input->getArgument(self::STORE_ID);
            $productSku = $input->getArgument(self::PRODUCT_SKU);
            $productName = $input->getArgument(self::PRODUCT_NAME);
            $productPrice = $input->getArgument(self::PRODUCT_PRICE);

            $store = $this->storeManager->getStore($storeId);
            $product = $this->productRepository->get($productSku, false, $store->getId());

            if ($productName !== null) {
                $product->setName($productName);
            }

            if ($productPrice !== null) {
                $product->setPrice($productPrice);
            }

            $this->productRepository->save($product);

            $output->writeln("<info>Product updated successfully.</info>");
        } catch (LocalizedException $e) {
            $output->writeln("<error>Error: " . $e->getMessage() . "</error>");
        } catch (\Exception $e) {
            $output->writeln("<error>General Error: " . $e->getMessage() . "</error>");
        }

        return Command::SUCCESS;
    }
}
