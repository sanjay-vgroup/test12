<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel\CustomerPermission;

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
	$this->_init('Vgroup\SafetyHubApp\Model\CustomerPermission', 'Vgroup\SafetyHubApp\Model\ResourceModel\CustomerPermission');
    }
     

}
