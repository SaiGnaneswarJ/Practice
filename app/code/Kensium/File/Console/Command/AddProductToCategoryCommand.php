<?php

namespace Kensium\File\Console\Command;

use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AddProductToCategoryCommand
 * @package Kensium\File\Console\Command
 */
class AddProductToCategoryCommand extends Command
{
    /**
     * @var CategoryLinkManagementInterface
     */
    private $categoryLinkManagement;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var State
     */
    private $state;

    /**
     * AddProductToCategoryCommand constructor.
     * @param CategoryLinkManagementInterface $categoryLinkManagement
     * @param Product $product
     * @param State $state
     */
    public function __construct(
        CategoryLinkManagementInterface $categoryLinkManagement,
        Product $product,
        State $state
    ) {
        $this->categoryLinkManagement = $categoryLinkManagement;
        $this->product = $product;
        $this->state = $state;

        parent::__construct();
    }

    /**
     * Configure the command options and arguments.
     */
    protected function configure()
    {
        $this->setName('kensium:product:add:category')
            ->setDescription('Add a product to a category programmatically. php bin/magento kensium:product:add:category sku categoryid')
            ->addArgument('sku', InputArgument::REQUIRED, 'Product SKU')
            ->addArgument('categoryId', InputArgument::REQUIRED, 'Category ID');

        parent::configure();
    }

    /**
     * Execute the command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->state->setAreaCode(Area::AREA_FRONTEND);
        } catch (\Exception $e) {
            // Area code already set
        }

        $productSku = $input->getArgument('sku');
        $categoryId = $input->getArgument('categoryId');

        $product = $this->product->loadByAttribute('sku', $productSku);

        if (!$product) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The product with SKU "%1" does not exist.', $productSku)
            );
        }

        $currentCategoryIds = $product->getCategoryIds();
        if (!in_array($categoryId, $currentCategoryIds)) {
            $currentCategoryIds[] = $categoryId;
            $product->setCategoryIds($currentCategoryIds);
            $product->save();
        }

        $output->writeln('Product added to category.');

        return Command::SUCCESS;
    }
}
