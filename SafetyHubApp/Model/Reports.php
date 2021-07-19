<?php

namespace Vgroup\SafetyHubApp\Model;

use Magento\Framework\DataObject\IdentityInterface;

class Reports extends \Magento\Framework\Model\AbstractModel implements IdentityInterface {

    /**
     * cache tag
     */
    const CACHE_TAG = 'safetyhubapp_reports';

    /**
     * @var string
     */
    protected $_cacheTag = 'safetyhubapp_reports';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'safetyhubapp_reports';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct() {

	$this->_init('Vgroup\SafetyHubApp\Model\ResourceModel\Reports');
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities() {
	return [self::CACHE_TAG . '_' . $this->getId()];
    }

}
