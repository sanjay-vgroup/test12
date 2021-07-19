<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel\SafetyUsers;

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
	$this->_init('Vgroup\SafetyHubApp\Model\SafetyUsers', 'Vgroup\SafetyHubApp\Model\ResourceModel\SafetyUsers');
    }


}
