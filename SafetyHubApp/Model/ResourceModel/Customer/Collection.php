<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel\Customer;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'vgroup_safetyhubapp_customer_collection';
	protected $_eventObject = 'customer_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct() {
	$this->_init('Vgroup\SafetyHubApp\Model\Customer', 'Vgroup\SafetyHubApp\Model\ResourceModel\Customer');
    }
    }
