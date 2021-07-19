<?php

namespace Vgroup\SafetyHubApp\Model;

class CompanyDefaultLabels extends \Magento\Framework\Model\AbstractModel {

    const CACHE_TAG = 'safetyhubapp_default_labels';
    const DEVICE_TYPE = 'device_type';

    protected $_cacheTag = 'safetyhubapp_default_labels';
    protected $_eventPrefix = 'safetyhubapp_default_labels';

    protected function _construct() {
	$this->_init('Vgroup\SafetyHubApp\Model\ResourceModel\CompanyDefaultLabels');
    }

    public function getIdentities() {
	return [self::CACHE_TAG . '_' . $this->getId()];
    }

//    public function getDefaultValues() {
//	$values = [];
//	return $values;
//    }
//
//    /**
//     * Get Device Type
//     *
//     * @return int|null
//     */
//    public function getDeviceType() {
//	return $this->getData(self::DEVICE_TYPE);
//    }
//
//    /**
//     * Set Device Type
//     *
//     * @param int $deviceType
//     * @return $this
//     */
//    public function setDeviceType($deviceType) {
//	return $this->setData(self::DEVICE_TYPE, $id);
//    }

}
