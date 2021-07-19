<?php

namespace Vgroup\SafetyHubApp\Ui\Component\Listing\Column;

use Vgroup\SafetyHubApp\Model\ResourceModel\Companies\CollectionFactory;

class CompanyAlter extends \Magento\Ui\Component\Listing\Columns\Column {

    public function __construct(
    \Magento\Framework\View\Element\UiComponent\ContextInterface $context, \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory, array $components = [], array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource) {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if ($item['company_id']==0):
                    $item['company'] = 'First Aid Only'; //Here you can do anything with actual data
                endif;
            }
        }

        return $dataSource;
    }

}
