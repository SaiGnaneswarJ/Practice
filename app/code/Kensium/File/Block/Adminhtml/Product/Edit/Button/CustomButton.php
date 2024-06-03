<?php

namespace Kensium\File\Block\Adminhtml\Product\Edit\Button;

class CustomButton extends \Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic
{
    public function getButtonData()
    {
        return [
            'label' => __('Product Grid'),
            'class' => 'action-secondary',
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'sort_order' => 10
        ];

    }

    public function getBackUrl()
    {
        return $this->getUrl('catalog/product/');
    }
}
