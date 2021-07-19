<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel\Company;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'vgroup_safetyhubapp_company_collection';
   protected $_eventObject = 'company_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct() {
	$this->_init('Vgroup\SafetyHubApp\Model\Company', 'Vgroup\SafetyHubApp\Model\ResourceModel\Company');
    }
    }
