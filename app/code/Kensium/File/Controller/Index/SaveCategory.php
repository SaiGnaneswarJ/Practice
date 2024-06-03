<?php
namespace Kensium\File\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Api\CategoryRepositoryInterface;

/**
 * Class SaveCategory
 * @package Kensium\File\Controller\Index
 */
class SaveCategory extends Action
{
    protected $jsonFactory;
    protected $productFactory;
    protected $categoryRepository;


    /**
     * SaveCategory constructor.
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param ProductFactory $productFactory
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        ProductFactory $productFactory,
        CategoryRepositoryInterface $categoryRepository
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->productFactory = $productFactory;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $response = ['success' => false];
        $productSku = $this->getRequest()->getParam('sku');
        $categoryId = $this->getRequest()->getParam('categoryId');

        try {

            $product = $this->productFactory->create()->loadByAttribute('sku', $productSku);
            if (!$product || !$product->getId()) {
                throw new \Exception('Product not found.');
            }


            $category = $this->categoryRepository->get($categoryId);
            if (!$category || !$category->getId()) {
                throw new \Exception('Category not found.');
            }


            $categoryIds = $product->getCategoryIds();
            $categoryIds[] = $categoryId;
            $product->setCategoryIds(array_unique($categoryIds));


            $product->save();

            $response['success'] = true;
            $response['message'] = 'Product added to category successfully.';
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        $resultJson = $this->jsonFactory->create();
        return $resultJson->setData($response);
    }
}
