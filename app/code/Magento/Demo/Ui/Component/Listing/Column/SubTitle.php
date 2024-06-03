<?php

namespace Magento\Demo\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class SubTitle extends Column
{

    protected $resourceConnection;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        array $components = [],
        array $data = []
    ) {
        $this->resourceConnection = $resourceConnection;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $connection = $this->resourceConnection->getConnection();
            $tableName = $connection->getTableName('cms_page');

            foreach ($dataSource['data']['items'] as &$item) {
                // Fetch the sub_title data from the database
                $pageId = $item['page_id'];
                $select = $connection->select()
                    ->from($tableName, ['sub_title'])
                    ->where('page_id = ?', $pageId);
                $subTitle = $connection->fetchOne($select);

                // Set the fetched sub_title data
                $item[$this->getData('name')] = $subTitle;
            }
        }

        return $dataSource;
    }
}
