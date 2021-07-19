<?php

namespace Vgroup\SafetyHubApp\Model\Data;

use \Magento\Framework\Api\AttributeValueFactory;

class OfflineSync extends \Magento\Framework\Api\AbstractExtensibleObject implements \Vgroup\SafetyHubApp\Api\Data\OfflineSyncInterface
{
    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $attributeValueFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $attributeValueFactory,
        $data = []
    ) {
        parent::__construct($extensionFactory, $attributeValueFactory, $data);
    }

    public function getSave()
    {
        return $this->_get(self::SAVE);
    }

    public function getUpdate()
    {
        return $this->_get(self::UPDATE);
    }

    public function getDelete()
    {
        return $this->_get(self::DELETE);
    }
    public function getSaveInventory()
    {
        return $this->_get(self::SAVE_INVENTORY);
    }

    public function getPlace()
    {
        return $this->_get(self::PLACE);
    }


    public function getRestock()
    {
        return $this->_get(self::RESTOCK);
    }

    public function getUpdateProfile()
    {
        return $this->_get(self::UPDATE_PROFILE);
    }


    public function setSave(array $saveUserSafetyItems)
    {
        return $this->setData(self::SAVE, $saveUserSafetyItems);
    }

    public function setUpdate(array $updateUserSafetyItems)
    {
        return $this->setData(self::UPDATE, $updateUserSafetyItems);
    }

    public function setDelete(array $deleteUserSafetyItems)
    {
        return $this->setData(self::DELETE, $deleteUserSafetyItems);
    }

    public function setSaveInventory(array $inventoryUserSafetyItems)
    {
        return $this->setData(self::SAVE_INVENTORY, $inventoryUserSafetyItems);
    }

    public function setPlace(array $requisition)
    {
        return $this->setData(self::PLACE, $requisition);
    }

    public function setRestock(array $restockRequisition)
    {
        return $this->setData(self::RESTOCK, $restockRequisition);
    }

    public function setUpdateProfile($customer)
    {
        return $this->setData(self::UPDATE_PROFILE, $customer);
    }

    public function getCustomerId()
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    public function getCompanyId()
    {
        return $this->_get(self::COMPANY_ID);
    }

    public function setCompanyId($companyId)
    {
        return $this->setData(self::COMPANY_ID, $companyId);
    }
}
