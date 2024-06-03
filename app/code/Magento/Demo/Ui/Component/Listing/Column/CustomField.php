<?php

namespace Magento\Demo\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class CustomField extends Column
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
            $tableName = $connection->getTableName('customer_entity');

            foreach ($dataSource['data']['items'] as &$item) {
                $itemId = $item['entity_id'];
                $select = $connection->select()
                    ->from($tableName, ['my_custom_field'])
                    ->where('entity_id = ?', $itemId);
                $customFieldData = $connection->fetchOne($select);

                $item[$this->getData('name')] = $customFieldData;
            }
        }

        return $dataSource;
    }
}
