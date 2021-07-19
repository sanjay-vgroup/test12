<?php

namespace Vgroup\SafetyHubApp\Model;

use Magento\Framework\DataObject\IdentityInterface;

class CabinetSerialNumbers extends \Magento\Framework\Model\AbstractModel implements IdentityInterface {

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'safetyhubapp_safetyitem_serials';

    /**
     * @var string
     */
    protected $_cacheTag = 'safetyhubapp_safetyitem_serials';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'safetyhubapp_safetyitem_serials';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct() {

        $this->_init('Vgroup\SafetyHubApp\Model\ResourceModel\CabinetSerialNumbers');
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
