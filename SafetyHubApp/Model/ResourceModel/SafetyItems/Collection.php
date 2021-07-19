<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel\SafetyItems;

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
	$this->_init('Vgroup\SafetyHubApp\Model\SafetyItems', 'Vgroup\SafetyHubApp\Model\ResourceModel\SafetyItems');
    }
    
    

}
