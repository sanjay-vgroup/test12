<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel\Companies\PartNumbers;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    /**
     * @var string
     */
    protected $_idFieldName = 'value_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct() {
	$this->_init('Vgroup\SafetyHubApp\Model\Companies\PartNumbers', 'Vgroup\SafetyHubApp\Model\ResourceModel\Companies\PartNumbers');
    }

}
