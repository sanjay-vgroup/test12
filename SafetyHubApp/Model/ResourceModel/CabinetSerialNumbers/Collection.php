<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel\CabinetSerialNumbers;

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
	$this->_init('Vgroup\SafetyHubApp\Model\CabinetSerialNumbers', 'Vgroup\SafetyHubApp\Model\ResourceModel\CabinetSerialNumbers');
    }
    
    

}
