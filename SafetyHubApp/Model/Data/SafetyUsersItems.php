<?php

namespace Vgroup\SafetyHubApp\Model\Data;

use \Magento\Framework\Api\AttributeValueFactory;

class SafetyUsersItems extends \Magento\Framework\Api\AbstractExtensibleObject implements
    \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface
{

    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $attributeValueFactory
     * @param \Magento\Customer\Api\CustomerMetadataInterface $metadataService
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $attributeValueFactory,
        \Magento\Customer\Api\CustomerMetadataInterface $metadataService,
        $data = []
    ) {
        $this->metadataService = $metadataService;
        parent::__construct($extensionFactory, $attributeValueFactory, $data);
    }

    /**
     * Get Users Safety Items id
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->_get(self::ID);
    }

    public function getType()
    {
        return $this->_get(self::TYPE);
    }

    public function getModelNumber()
    {
        return $this->_get(self::MODEL_NUMBER);
    }

    public function getSerialNumber()
    {
        return $this->_get(self::SERIAL_NUMBER);
    }

    public function getNickname()
    {
        return $this->_get(self::NICKNAME);
    }

    public function getCustomerId()
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    public function getCompanyId()
    {
        return $this->_get(self::COMPANY_ID);
    }

    public function getRefillReminderStatus()
    {
        return $this->_get(self::REFILL_REMINDER_STATUS);
    }

    public function getRefillReminderDays()
    {
        return $this->_get(self::REFILL_REMINDER_DAYS);
    }

    public function getPhysicalInventoryStatus()
    {
        return $this->_get(self::PHYSICAL_INVENTORY_STATUS);
    }

    public function getPhysicalInventoryDays()
    {
        return $this->_get(self::PHYSICAL_INVENTORY_DAYS);
    }

    public function getPhysicalInventoryDate()
    {
        return $this->_get(self::PHYSICAL_INVENTORY_DATE);
    }

    public function getShowPhysicalInventoryDate()
    {
        return $this->_get(self::SHOW_PHYSICAL_INVENTORY_DATE);
    }

    public function getExpiryReminderStatus()
    {
        return $this->_get(self::EXPIRY_REMINDER_STATUS);
    }

    public function getExpiryReminderDays()
    {
        return $this->_get(self::EXPIRY_REMINDER_DAYS);
    }

    public function getExpirationDate()
    {
        return $this->_get(self::EXPIRATION_DATE);
    }

    public function getBatteryExpirationDate()
    {
        return $this->_get(self::BATTERY_EXPIRATION_DATE);
    }

    public function getPadExpirationDate()
    {
        return $this->_get(self::PAD_EXPIRATION_DATE);
    }

    public function getServiceDueDate()
    {
        return $this->_get(self::SERVICE_DUE_DATE);
    }

    public function getIsRestock()
    {
        return $this->_get(self::IS_STOCK);
    }

    public function getRestockType()
    {
        return $this->_get(self::RESTOCK_TYPE);
    }

    public function getRestockAt()
    {
        return $this->_get(self::RESTOCK_AT);
    }

    public function getRestockBy()
    {
        return $this->_get(self::RESTOCK_BY);
    }

    public function getLastRefillReminderSent()
    {
        return $this->_get(self::LAST_REFILL_REMINDER_SENT);
    }

    public function getLastBatteryReminderSent()
    {
        return $this->_get(self::LAST_BATTERY_REMINDER_SENT);
    }

    public function getPhysicalBatteryReminderSent()
    {
        return $this->_get(self::PHYSICAL_BATTERY_REMINDER_SENT);
    }

    public function getLastPadReminderSent()
    {
        return $this->_get(self::LAST_PAD_REMINDER_SENT);
    }

    public function getLastPhysicalReminderSent()
    {
        return $this->_get(self::LAST_PHYSICAL_REMINDER_SENT);
    }

    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    public function getUpdatedAt()
    {
        return $this->_get(self::UPDATED_AT);
    }

    /**
     * Set Users Safety Items id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

    public function setModelNumber($modelNumber)
    {
        return $this->setData(self::MODEL_NUMBER, $modelNumber);
    }

    public function setSerialNumber($serialNumber)
    {
        return $this->setData(self::SERIAL_NUMBER, $serialNumber);
    }

    public function setNickname($nickname)
    {
        return $this->setData(self::NICKNAME, $nickname);
    }

    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    public function setCompanyId($companyId)
    {
        return $this->setData(self::COMPANY_ID, $companyId);
    }

    public function setRefillReminderStatus($refillReminderStatus)
    {
        return $this->setData(self::REFILL_REMINDER_STATUS, $refillReminderStatus);
    }

    public function setRefillReminderDays($refillReminderDays)
    {
        return $this->setData(self::REFILL_REMINDER_DAYS, $refillReminderDays);
    }

    public function setPhysicalInventoryStatus($physicalInventoryStatus)
    {
        return $this->setData(self::PHYSICAL_INVENTORY_STATUS, $physicalInventoryStatus);
    }

    public function setPhysicalInventoryDays($physicalInventoryDays)
    {
        return $this->setData(self::PHYSICAL_INVENTORY_DAYS, $physicalInventoryDays);
    }

    public function setPhysicalInventoryDate($physicalInventoryDate)
    {
        return $this->setData(self::PHYSICAL_INVENTORY_DATE, $physicalInventoryDate);
    }

    public function setShowPhysicalInventoryDate($showPhysicalInventoryDate)
    {
        return $this->setData(self::SHOW_PHYSICAL_INVENTORY_DATE, $showPhysicalInventoryDate);
    }

    public function setExpiryReminderStatus($expiryReminderStatus)
    {
        return $this->setData(self::EXPIRY_REMINDER_STATUS, $expiryReminderStatus);
    }

    public function setExpiryReminderDays($expiryReminderDays)
    {
        return $this->setData(self::EXPIRY_REMINDER_DAYS, $expiryReminderDays);
    }

    public function setExpirationDate($expirationDate)
    {
        return $this->setData(self::EXPIRATION_DATE, $expirationDate);
    }

    public function setBatteryExpirationDate($batteryExpirationDate)
    {
        return $this->setData(self::BATTERY_EXPIRATION_DATE, $batteryExpirationDate);
    }

    public function setPadExpirationDate($padExpirationDate)
    {
        return $this->setData(self::PAD_EXPIRATION_DATE, $padExpirationDate);
    }

    public function setServiceDueDate($serviceDueDate)
    {
        return $this->setData(self::SERVICE_DUE_DATE, $serviceDueDate);
    }

    public function setIsRestock($isRestockStock)
    {
        return $this->setData(self::IS_STOCK, $isRestockStock);
    }

    public function setRestockType($restockType)
    {
        return $this->setData(self::RESTOCK_TYPE, $restockType);
    }

    public function setRestockAt($restockAt)
    {
        return $this->setData(self::RESTOCK_AT, $restockAt);
    }

    public function setRestockBy($restockBy)
    {
        return $this->setData(self::RESTOCK_BY, $restockBy);
    }

    public function setLastRefillReminderSent($lastRefillReminderSent)
    {
        return $this->setData(self::LAST_REFILL_REMINDER_SENT, $lastRefillReminderSent);
    }

    public function setLastBatteryReminderSent($lastBatteryReminderSent)
    {
        return $this->setData(self::LAST_BATTERY_REMINDER_SENT, $lastBatteryReminderSent);
    }

    public function setLastPadReminderSent($lastPadReminderSent)
    {
        return $this->setData(self::LAST_PAD_REMINDER_SENT, $lastPadReminderSent);
    }

    public function setLastPhysicalReminderSent($lastPhysicalReminderSent)
    {
        return $this->setData(self::LAST_PHYSICAL_REMINDER_SENT, $lastPhysicalReminderSent);
    }

    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    public function getSafetyItem()
    {
        return $this->_get(self::SAFETY_ITEM);
    }

    public function getAssociatedProducts()
    {
        return $this->_get(self::ASSOCIATED_PRODUCTS);
    }

    public function setSafetyItem(array $safetyItem = null)
    {
        return $this->setData(self::SAFETY_ITEM, $safetyItem);
    }

    public function setAssociatedProducts(array $products = null)
    {
        return $this->setData(self::ASSOCIATED_PRODUCTS, $products);
    }

    public function getCity()
    {
        return $this->_get(self::CITY);
    }

    public function getCompany()
    {
        return $this->_get(self::COMPANY);
    }

    public function getCountryId()
    {
        return $this->_get(self::COUNTRY_ID);
    }

    public function getEmail()
    {
        return $this->_get(self::EMAIL);
    }

    public function getFirstname()
    {
        return $this->_get(self::FIRSTNAME);
    }

    public function getLastname()
    {
        return $this->_get(self::LASTNAME);
    }

    public function getPostcode()
    {
        return $this->_get(self::POSTCODE);
    }

    public function getRegion()
    {
        return $this->_get(self::REGION);
    }

    public function getRegionId()
    {
        return $this->_get(self::REGION_ID);
    }

    public function getStreet1()
    {
        return $this->_get(self::STREET1);
    }

    public function getStreet2()
    {
        return $this->_get(self::STREET2);
    }

    public function getTelephone()
    {
        return $this->_get(self::TELEPHONE);
    }

    public function setCity($city)
    {
        return $this->setData(self::CITY, $city);
    }

    public function setCompany($company)
    {
        return $this->setData(self::COMPANY, $company);
    }

    public function setCountryId($countryId)
    {
        return $this->setData(self::COUNTRY_ID, $countryId);
    }

    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    public function setFirstname($firstname)
    {
        return $this->setData(self::FIRSTNAME, $firstname);
    }

    public function setLastname($lastname)
    {
        return $this->setData(self::LASTNAME, $lastname);
    }

    public function setPostcode($postcode)
    {
        return $this->setData(self::POSTCODE, $postcode);
    }

    public function setRegion($region)
    {
        return $this->setData(self::REGION, $region);
    }

    public function setRegionId($regionId)
    {
        return $this->setData(self::REGION_ID, $regionId);
    }

    public function setStreet1($street1)
    {
        return $this->setData(self::STREET1, $street1);
    }

    public function setStreet2($street2)
    {
        return $this->setData(self::STREET2, $street2);
    }

    public function setTelephone($telephone)
    {
        return $this->setData(self::TELEPHONE, $telephone);
    }

    public function getNumberOfEmployees()
    {
        return $this->_get(self::NUMBER_OF_EMPLOYEES);
    }

    public function setNumberOfEmployees($numberOfEmployees)
    {
        return $this->setData(self::NUMBER_OF_EMPLOYEES, $numberOfEmployees);
    }

    public function getProductsCount()
    {
        return $this->_get(self::PRODUCTS_COUNT);
    }

    public function setProductsCount($productsCount)
    {
        return $this->setData(self::PRODUCTS_COUNT, $productsCount);
    }

    public function getSafetyitemId()
    {
        return $this->_get(self::SAFETYITEM_ID);
    }

    public function setSafetyitemId($safetyitemId)
    {
        return $this->setData(self::SAFETYITEM_ID, $safetyitemId);
    }
}
