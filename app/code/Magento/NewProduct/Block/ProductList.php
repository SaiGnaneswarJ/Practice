<?php
namespace Magento\NewProduct\Block;

use Magento\Catalog\Pricing\Price\FinalPrice;
use Magento\Framework\Pricing\Render;
use Magento\Framework\App\ActionInterface;
use Magento\Catalog\Block\Product\AbstractProduct;

class ProductList extends AbstractProduct
{
    protected $urlHelper;
    protected $productFactory;
    protected $formKey;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Magento\Catalog\Model\ProductFactory $productloader,
        \Magento\Framework\Data\Form\FormKey $formKey,
        array $data = []
    ) {
        $this->urlHelper = $urlHelper;
        $this->productFactory = $productloader;
        $this->formKey = $formKey;
        parent::__construct($context, $data);
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    public function getLoadProducts()
    {
        $products = $this->productFactory->create()->getCollection()
            ->addAttributeToSelect(["name", "price", "image"])
            ->addAttributeToFilter("newly_added", 1)
            ->addFieldToFilter('newly_added_end', ['gteq' => date('Y-m-d H:i:s')]);
//        echo $products->getSelect();
//        exit();
        return $products;
    }

    public function getLoadProduct($id)
    {
        return $this->productFactory->create()->load($id);
    }

    public function getAddToCartPostParams(\Magento\Catalog\Model\Product $product)
    {
        $url = $this->getAddToCartUrl($product, ['_escape' => false]);
        return [
            'action' => $url,
            'data' => [
                'product' => (int) $product->getEntityId(),
                ActionInterface::PARAM_NAME_URL_ENCODED =>
                    $this->urlHelper->getEncodedUrl($url),
            ]
        ];
    }

    public function getProductPrice(\Magento\Catalog\Model\Product $product)
    {
        $priceRender = $this->getPriceRender($product);
        $price = '';
        if ($priceRender) {
            $price = $priceRender->render(
                FinalPrice::PRICE_CODE,
                $product,
                [
                    'include_container' => true,
                    'display_minimal_price' => true,
                    'zone' => Render::ZONE_ITEM_LIST,
                    'list_category_page' => true
                ]
            );
        }
        return $price;
    }

    protected function getPriceRender($product)
    {
        return $this->getLayout()->createBlock(\Magento\Framework\Pricing\Render::class, "product.price.render.default".$product->getSku())
            ->setData('is_product_list', true);
    }
}
