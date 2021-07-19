<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel\Reports;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct() {
	$this->_init('Vgroup\SafetyHubApp\Model\Reports', 'Vgroup\SafetyHubApp\Model\ResourceModel\Reports');
    }

}
