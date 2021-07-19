<?php

namespace Vgroup\SafetyHubApp\Model;


class DeviceToken extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface {

    const CACHE_TAG = 'safetyhubapp_device_token';

    protected $_cacheTag = 'safetyhubapp_device_token';
    protected $_eventPrefix = 'safetyhubapp_device_token';

    protected function _construct() {
        $this->_init('Vgroup\SafetyHubApp\Model\ResourceModel\DeviceToken');
    }

    public function getIdentities() {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

}
