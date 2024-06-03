<?php

namespace Magento\Demo\Plugin;

use Magento\Demo\Model\ResourceModel\Page;

class PageActionsPlugin
{

    protected $pageResourceModel;

    public function __construct(
        Page $pageResourceModel
    ) {
        $this->pageResourceModel = $pageResourceModel;
    }

    public function afterPrepareDataSource(
        \Magento\Cms\Ui\Component\Listing\Column\PageActions $subject,
        $result
    ) {
        if (isset($result['data']['items'])) {
            foreach ($result['data']['items'] as &$item) {
                $item['sub_title'] = $this->getSubTitle($item['page_id']);
            }
        }

        return $result;
    }

    protected function getSubTitle($pageId)
    {
        $subTitle = $this->pageResourceModel->getSubTitleByPageId($pageId);
        return $subTitle ? $subTitle : __('Not Available');
    }
}
