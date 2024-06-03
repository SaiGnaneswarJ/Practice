<?php

namespace Kensium\File\Block\Adminhtml\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**+
 * Class Back
 * @package Kensium\File\Block\Adminhtml\Button
 */
class FileInfo extends Generic implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('File Info'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'action-secondary',
            'sort_order' => 30,
        ];
    }

    /**
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('file/index/index');
    }
}

