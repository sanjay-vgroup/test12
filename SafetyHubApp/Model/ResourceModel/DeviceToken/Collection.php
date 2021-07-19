<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel\DeviceToken;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    protected $_idFieldName = 'rel_id';
    protected $_eventPrefix = 'safetyhubapp_device_token_collection';
    protected $_eventObject = 'device_token_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct() {
        $this->_init('Vgroup\SafetyHubApp\Model\DeviceToken', 'Vgroup\SafetyHubApp\Model\ResourceModel\DeviceToken');
    }

}
