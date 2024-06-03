<?php

namespace Magento\Demo\Block\Adminhtml\Button;

use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic;

class Reset extends Generic
{
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30,
        ];
    }
}
