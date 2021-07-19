<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api\Data;

/**
 * Safety User Item interface.
 * @api
 * @since 100.0.2
 */
interface SafetyUsersItemsInterface
{

    /**
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const ID = 'entity_id';
    const SAFETYITEM_ID = 'safetyitem_id';
    const TYPE = 'type';
    const MODEL_NUMBER = 'model_number';
    const SERIAL_NUMBER = 'serial_number';
    const REQUISITION_EMAIL_ADDRESS = 'requisition_email_address';
    const NICKNAME = 'nickname';
    const CUSTOMER_ID = 'customer_id';
    const COMPANY_ID = 'company_id';
    const FIRSTNAME = 'firstname';
    const LASTNAME = 'lastname';
    const EMAIL = 'email';
    const STREET1 = 'street1';
    const STREET2 = 'street2';
    const CITY = 'city';
    const REGION_ID = 'region_id';
    const REGION = 'region';
    const COUNTRY_ID = 'country_id';
    const COMPANY = 'company';
    const NUMBER_OF_EMPLOYEES = 'number_of_employees';
    const POSTCODE = 'postcode';
    const TELEPHONE = 'telephone';
    const REFILL_REMINDER_STATUS = 'refill_reminder_status';
    const REFILL_REMINDER_DAYS = 'refill_reminder_days';
    const PHYSICAL_INVENTORY_STATUS = 'physical_inventory_status';
    const PHYSICAL_INVENTORY_DAYS = 'physical_inventory_days';
    const PHYSICAL_INVENTORY_DATE = 'physical_inventory_date';
    const SHOW_PHYSICAL_INVENTORY_DATE = 'show_physical_inventory_date';
    const EXPIRY_REMINDER_STATUS = 'expiry_reminder_status';
    const EXPIRY_REMINDER_DAYS = 'expiry_reminder_days';
    const EXPIRATION_DATE = 'expiration_date';
    const BATTERY_EXPIRATION_DATE = 'battery_expiration_date';
    const PAD_EXPIRATION_DATE = 'pad_expiration_date';
    const SERVICE_DUE_DATE = 'service_due_date';
    const IS_STOCK = 'is_restock';
    const RESTOCK_TYPE = 'restock_type';
    const RESTOCK_AT = 'restock_at';
    const RESTOCK_BY = 'restock_by';
    const LAST_REFILL_REMINDER_SENT = 'last_refill_reminder_sent';
    const LAST_BATTERY_REMINDER_SENT = 'last_battery_reminder_sent';
    const LAST_PAD_REMINDER_SENT = 'last_pad_reminder_sent';
    const LAST_PHYSICAL_REMINDER_SENT = 'last_physical_reminder_sent';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const SAFETY_ITEM = 'safety_item';
    const ASSOCIATED_PRODUCTS = 'associated_products';
    const PRODUCTS_COUNT = 'products_count';

    /**
     * Get Users Safety Items id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set Users Safety Items id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);
    /**
     * Get Safety Items id
     *
     * @return int|null
     */
    public function getSafetyitemId();

    /**
     * Set Safety Items id
     *
     * @param int $safetyitemId
     * @return $this
     */
    public function setSafetyitemId($safetyitemId);
    /**
     * Get type id
     *
     * @return int|null
     */
    public function getType();

    /**
     * Set type id
     *
     * @param int $type
     * @return $this
     */
    public function setType($type);

    /**
     * Get model number
     *
     * @return string|null
     */
    public function getModelNumber();

    /**
     * Set model number
     *
     * @param string $modelNumber
     * @return $this
     */
    public function setModelNumber($modelNumber);

    /**
     * Get serial number
     *
     * @return string|null
     */
    public function getSerialNumber();

    /**
     * Set serial number
     *
     * @param string $serialNumber
     * @return $this
     */
    public function setSerialNumber($serialNumber);

    /**
     * Get nickname
     *
     * @return string|null
     */
    public function getNickname();

    /**
     * Set nickname
     *
     * @param string $nickname
     * @return $this
     */
    public function setNickname($nickname);

    /**
     * Get customer id
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set Customer Id
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * Get Company Id
     *
     * @return int
     */
    public function getCompanyId();

    /**
     * Set Company Id
     *
     * @param int $companyId
     * @return $this
     */
    public function setCompanyId($companyId);

    /**
     * Get First name
     *
     * @return string
     */
    public function getFirstname();

    /**
     * Set First name
     *
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname);

    /**
     * Get Last name
     *
     * @return string
     */
    public function getLastname();

    /**
     * Set Last name
     *
     * @param string $lastname
     * @return $this
     */
    public function setLastname($lastname);

    /**
     * Get Email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set Email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     * Get Street 1
     *
     * @return string|null
     */
    public function getStreet1();

    /**
     * Set Street 1
     *
     * @param string $street1
     * @return $this
     */
    public function setStreet1($street1);

    /**
     * Get Street 2
     *
     * @return string|null
     */
    public function getStreet2();

    /**
     * Set Street 2
     *
     * @param string $street2
     * @return $this
     */
    public function setStreet2($street2);

    /**
     * Get City
     *
     * @return string|null
     */
    public function getCity();

    /**
     * Set Street 2
     *
     * @param string $city
     * @return $this
     */
    public function setCity($city);

    /**
     * Get Region Id
     *
     * @return int|null
     */
    public function getRegionId();

    /**
     * Set Region Id
     *
     * @param int $regionId
     * @return $this
     */
    public function setRegionId($regionId);

    /**
     * Get Region
     *
     * @return string|null
     */
    public function getRegion();

    /**
     * Set Region
     *
     * @param string $region
     * @return $this
     */
    public function setRegion($region);

    /**
     * Get Country Id
     *
     * @return string|null
     */
    public function getCountryId();

    /**
     * Set Country Id
     *
     * @param string $countryId
     * @return $this
     */
    public function setCountryId($countryId);

    /**
     * Get Company
     *
     * @return string
     */
    public function getCompany();

    /**
     * Set Company
     *
     * @param string $company
     * @return $this
     */
    public function setCompany($company);

    /**
     * Get Number Of Employees
     *
     * @return string|null
     */
    public function getNumberOfEmployees();

    /**
     * Set Number Of Employees
     *
     * @param string $numberOfEmployees
     * @return $this
     */
    public function setNumberOfEmployees(int $numberOfEmployees);

    /**
     * Get Postcode
     *
     * @return string
     */
    public function getPostcode();

    /**
     * Set Postcode
     *
     * @param string $postcode
     * @return $this
     */
    public function setPostcode($postcode);

    /**
     * Get Telephone
     *
     * @return string
     */
    public function getTelephone();

    /**
     * Set Telephone
     *
     * @param string $telephone
     * @return $this
     */
    public function setTelephone($telephone);

    /**
     * Get Refill Reminder Status
     *
     * @return int
     */
    public function getRefillReminderStatus();

    /**
     * Set Refill Reminder Status
     *
     * @param int $refillReminderStatus
     * @return $this
     */
    public function setRefillReminderStatus($refillReminderStatus);

    /**
     * Get Refill Reminder Days
     *
     * @return int
     */
    public function getRefillReminderDays();

    /**
     * Set Refill Reminder Days
     *
     * @param int $refillReminderDays
     * @return $this
     */
    public function setRefillReminderDays($refillReminderDays);

    /**
     * Get physical inventory status
     *
     * @return int
     */
    public function getPhysicalInventoryStatus();

    /**
     * Set physical inventory status
     *
     * @param int $physicalInventoryStatus
     * @return $this
     */
    public function setPhysicalInventoryStatus($physicalInventoryStatus);

    /**
     * Get physical inventory days
     *
     * @return int
     */
    public function getPhysicalInventoryDays();

    /**
     * Set physical inventory days
     *
     * @param int $physicalInventoryDays
     * @return $this
     */
    public function setPhysicalInventoryDays($physicalInventoryDays);

    /**
     * Get physical inventory date
     *
     * @return string|null
     */
    public function getPhysicalInventoryDate();

    /**
     * Set physical inventory date
     *
     * @param string $physicalInventoryDate
     * @return $this
     */
    public function setPhysicalInventoryDate($physicalInventoryDate);

    /**
     * Get show physical inventory date
     *
     * @return string
     */
    public function getShowPhysicalInventoryDate();

    /**
     * Set show physical inventory date
     *
     * @param string $showPhysicalInventoryDate
     * @return $this
     */
    public function setShowPhysicalInventoryDate($showPhysicalInventoryDate);

    /**
     * Get expiry reminder status
     *
     * @return int|null
     */
    public function getExpiryReminderStatus();

    /**
     * Set expiry reminder status
     *
     * @param int $expiryReminderStatus
     * @return $this
     */
    public function setExpiryReminderStatus($expiryReminderStatus);

    /**
     * Get expiry reminders days
     *
     * @return int|null
     */
    public function getExpiryReminderDays();

    /**
     * Set expiry reminders days
     *
     * @param int $expiryReminderDays
     * @return $this
     */
    public function setExpiryReminderDays($expiryReminderDays);

    /**
     * Get  expiration date
     *
     * @return string|null
     */
    public function getExpirationDate();

    /**
     * Set expiration date
     *
     * @param string $expirationDate
     * @return $this
     */
    public function setExpirationDate($expirationDate);

    /**
     * Get  battery expiration date
     *
     * @return string|null
     */
    public function getBatteryExpirationDate();

    /**
     * Set battery expiration date
     *
     * @param string $batteryExpirationDate
     * @return $this
     */
    public function setBatteryExpirationDate($batteryExpirationDate);

    /**
     * Get pad expiration date
     *
     * @return string
     */
    public function getPadExpirationDate();

    /**
     * Set pad expiration date
     *
     * @param string $padExpirationDate
     * @return $this
     */
    public function setPadExpirationDate($padExpirationDate);

    /**
     * Get  service due date
     *
     * @return string|null
     */
    public function getServiceDueDate();

    /**
     * Set service due date
     *
     * @param string $serviceDueDate
     * @return $this
     */
    public function setServiceDueDate($serviceDueDate);

    /**
     * Get Is Restock
     *
     * @return int|null
     */
    public function getIsRestock();

    /**
     * Set Is Restock
     *
     * @param int $isRestockStock
     * @return $this
     */
    public function setIsRestock($isRestockStock);

    /**
     * Get  restock type
     *
     * @return string|null
     */
    public function getRestockType();

    /**
     * Set restock type
     *
     * @param string $restockType
     * @return $this
     */
    public function setRestockType($restockType);

    /**
     * Get  restock at
     *
     * @return string|null
     */
    public function getRestockAt();

    /**
     * Set restock at
     *
     * @param string $restockAt
     * @return $this
     */
    public function setRestockAt($restockAt);

    /**
     * Get  restock by
     *
     * @return string|null
     */
    public function getRestockBy();

    /**
     * Set restock by
     *
     * @param string $restockBy
     * @return $this
     */
    public function setRestockBy($restockBy);

    /**
     * Get  last refill reminder sent
     *
     * @return string|null
     */
    public function getLastRefillReminderSent();

    /**
     * Set last refill reminder sent
     *
     * @param string $lastRefillReminderSent
     * @return $this
     */
    public function setLastRefillReminderSent($lastRefillReminderSent);

    /**
     * Get  last battery reminder sent
     *
     * @return string|null
     */
    public function getLastBatteryReminderSent();

    /**
     * Set last battery reminder sent
     *
     * @param string $lastBatteryReminderSent
     * @return $this
     */
    public function setLastBatteryReminderSent($lastBatteryReminderSent);

    /**
     * Get  last pad reminder sent
     *
     * @return string|null
     */
    public function getLastPadReminderSent();

    /**
     * Set last pad reminder sent
     *
     * @param string $lastPadReminderSent
     * @return $this
     */
    public function setLastPadReminderSent($lastPadReminderSent);

    /**
     * Get  last physical reminder sent
     *
     * @return string|null
     */
    public function getLastPhysicalReminderSent();

    /**
     * Set last physical reminder sent
     *
     * @param string $lastPhysicalReminderSent
     * @return $this
     */
    public function setLastPhysicalReminderSent($lastPhysicalReminderSent);

    /**
     * Get created at time
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created at time
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated at time
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated at time
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get Safety Item Detail.
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemsInterface[]|null
     */
    public function getSafetyItem();

    /**
     * Set Safety Item Detail.
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyItemsInterface[] $safetyItem
     * @return $this
     */
    public function setSafetyItem(array $safetyItem = null);

    /**
     * Get Safety Item Associated Products.
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsInterface[]
     */
    public function getAssociatedProducts();

    /**
     * Set Safety Item Associated Products.
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsInterface[] $products
     * @return $this
     */
    public function setAssociatedProducts(array $products = null);

    /**
     * Get Safety Item Associated Products Count.
     *
     * @return int
     */
    public function getProductsCount();

    /**
     * Set Safety Item Associated Products Count.
     *
     * @param int $productsCount
     * @return $this
     */
    public function setProductsCount($productsCount);
}
