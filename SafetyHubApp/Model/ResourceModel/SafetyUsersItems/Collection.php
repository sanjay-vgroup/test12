<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel\SafetyUsersItems;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    protected $_idFieldName = 'entity_id';

    protected function _construct() {
	$this->_init('Vgroup\SafetyHubApp\Model\SafetyUsersItems', 'Vgroup\SafetyHubApp\Model\ResourceModel\SafetyUsersItems');
    }

    protected function _initSelect() {
	parent::_initSelect();
//	$this->addFilterToMap('entity_id', 'main_table.entity_id');
	$this->addFilterToMap('customer_id', 'main_table.customer_id');
//	$this->getSelect()->joinLeft(array("cu" => 'safetyhubapp_assigned_users_items'), "cu.entity_id = main_table.entity_id AND cu.customer_id = main_table.customer_id", array('assigend_customer_id' => 'cu.customer_id'));
//	echo $this->getSelect();
	return $this;
    }

}
