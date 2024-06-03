<?php

namespace Kensium\File\Block;

use Magento\Framework\View\Element\Template;
use Magento\CatalogRule\Model\RuleFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class RuleProducts extends Template
{
    protected $ruleFactory;
    protected $productCollectionFactory;
    protected $storeManager;

    public function __construct(
        Template\Context $context,
        RuleFactory $ruleFactory,
        ProductCollectionFactory $productCollectionFactory,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->ruleFactory = $ruleFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCatalogPriceRuleProductIds()
    {
        $websiteId = $this->storeManager->getStore()->getWebsiteId(); // current Website Id
        $resultProductIds = [];
        $catalogRuleCollection = $this->ruleFactory->create()->getCollection();
        $catalogRuleCollection->addIsActiveFilter(1); // filter for active rules only

        foreach ($catalogRuleCollection as $catalogRule) {
            $productIdsAccToRule = $catalogRule->getMatchingProductIds();
            foreach ($productIdsAccToRule as $productId => $ruleProductArray) {
                if (!empty($ruleProductArray[$websiteId])) {
                    $resultProductIds[$productId] = [
                        'rule_id' => $catalogRule->getId(),
                        'rule_name' => $catalogRule->getName()
                    ];
                }
            }
        }

        return $resultProductIds;
    }

    /**
     * @param $productIds
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProductCollectionByIds($productIds)
    {
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToSelect('name');
        $productCollection->addIdFilter($productIds);
        return $productCollection;
    }
}
