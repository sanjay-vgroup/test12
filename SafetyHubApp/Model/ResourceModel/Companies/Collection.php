<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel\Companies;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct() {
	$this->_init('Vgroup\SafetyHubApp\Model\Companies', 'Vgroup\SafetyHubApp\Model\ResourceModel\Companies');
    }

}
