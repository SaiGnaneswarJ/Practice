<?php

namespace Kensium\File\Block;
use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;

class Stock extends Template
{
    protected $_stockItemRepository;

    public function __construct(
        Context $context,
        StockItemRepository $stockItemRepository,
        array $data = []
    )
    {
        $this->_stockItemRepository = $stockItemRepository;
        parent::__construct($context, $data);
    }

    public function getStockItem($productId)
    {
        return $this->_stockItemRepository->get($productId);
    }
}

?>