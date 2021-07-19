<?php

namespace Vgroup\SafetyHubApp\Model;

use Magento\Framework\Model\AbstractModel;
use Vgroup\SafetyHubApp\Model\ResourceModel\SafetyUsersItems as SafetyUsersItemsResource;

class SafetyUsersItems extends AbstractModel
{

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'safetyhubapp_users_items';

    /**
     * @var string
     */
    protected $_cacheTag = 'safetyhubapp_users_items';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'safetyhubapp_users_items';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {

        $this->_init(SafetyUsersItemsResource::class);
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function addCheckOk($data)
    {
        $result = $this->_getResource()->addCheckOk($data);
        return $result;
    }
    public function getPhysicalInventoryData($userSafetyItemData)
    {
        $result = $this->_getResource()->getPhysicalInventoryData($userSafetyItemData);
        return $result;
    }
}
