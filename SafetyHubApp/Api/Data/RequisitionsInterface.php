<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api\Data;

/**
 * Requisition interface.
 * @api
 * @since 100.0.2
 */
interface RequisitionsInterface
{

    /**
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const ID = 'entity_id';
    const REQUISITION_TYPE = 'requisition_type';
    const SAFETY_ITEM_ID = 'safety_item_id';
    const SAFETY_ITEM_TYPE = 'safety_item_type';
    const CUSTOMER_ID = 'customer_id';
    const COMPANY_ID = 'company_id';
    const FIRSTNAME = 'firstname';
    const LASTNAME = 'lastname';
    const EMAIL = 'email';
    const STREET1 = 'street1';
    const STREET2 = 'street2';
    const CITY = 'city';
    const REGION = 'region';
    const REGION_ID = 'region_id';
    const POSTCODE = 'postcode';
    const FAX = 'fax';
    const TELEPHONE = 'telephone';
    const COMPANY = 'company';
    const COUNTRY_ID = 'country_id';
    const REQUISITIONS_EMAIL_ADDRESS = 'requisition_email_address';
    const OTHER_EMAIL_ADDRESSES = 'other_email_addresses';
    const PURCHASE_ORDER = 'purchase_order';
    const COMMENT = 'comment';
    const STATUS = 'status';
    const IS_RESTOCK_COMPLETE = 'is_restock_complete';
    const IS_DIRECT_RESTOCK = 'is_direct_restock';
    const REQUIITION_METHOD = 'requisition_method';
    const REQUIITION_REPORT_TYPE = 'requisition_report_type';
    const STATUS_UPDATED_BY = 'status_updated_by';
    const STATUS_FULFILLED_BY = 'status_fulfilled_by';
    const STATUS_UPDATED_AT = 'status_updated_at';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const SAFETY_ITEM_NAME = 'safety_item_name';
    const SAFETY_ITEM_IMAGE = 'safety_item_image';
    const SAFETY_ITEM_MODEL_NUMBER = 'safety_item_model_number';
    const SAFETY_ITEM_SERIAL_NUMBER = 'safety_item_serial_number';
    const SAFETY_ITEM_NICKNAME = 'safety_item_nickname';
    const ASSOCIATED_PRODUCTS = 'associated_products';
    const MESSAGE = 'message';

    /**
     * Get Requisition Id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set Requisition Id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get Requisition Type	
     *
     * @return int|null
     */
    public function getRequisitionType();

    /**
     * Set Requisition Type
     *
     * @param string $requisitionType
     * @return $this
     */
    public function setRequisitionType($requisitionType);

    /**
     * Get Safety Item Id 	
     *
     * @return int|null
     */
    public function getSafetyItemId();

    /**
     * Set Safety Item Id
     *
     * @param string $safetyItemId
     * @return $this
     */
    public function setSafetyItemId($safetyItemId);

    /**
     * Get Requisition Type	
     *
     * @return int|null
     */
    public function getSafetyItemType();

    /**
     * Set Safety Item Type
     *
     * @param string $safetyItemType
     * @return $this
     */
    public function setSafetyItemType($safetyItemType);

    /**
     * Get Customer Id
     *
     * @return int|null
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
     * @return int|null
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
     * @return string
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
     * @return string
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
     * @return string
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
     * @return string
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
     * @return string
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
     * @return string
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
     * Get Requisition Email Address
     *
     * @return string|null
     */
    public function getRequisitionEmailAddress();

    /**
     * Set Requisition Email Address
     *
     * @param string $requisitionEmailAddress
     * @return $this
     */
    public function setRequisitionEmailAddress($requisitionEmailAddress);

    /**
     * Get Other Email Addresses
     *
     * @return string|null
     */
    public function getOtherEmailAddresses();

    /**
     * Set Other Email Addresses
     *
     * @param string $otherEmailAddresses
     * @return $this
     */
    public function setOtherEmailAddresses($otherEmailAddresses);

    /**
     * Get Purchase Order
     *
     * @return string
     */
    public function getPurchaseOrder();

    /**
     * Set Purchase Order
     *
     * @param string $purchaseOrder
     * @return $this
     */
    public function setPurchaseOrder($purchaseOrder);

    /**
     * Get Comment
     *
     * @return string
     */
    public function getComment();

    /**
     * Set Comment
     *
     * @param string $comment
     * @return $this
     */
    public function setComment($comment);

    /**
     * Get Status
     *
     * @return int
     */
    public function getStatus();

    /**
     * Set Status
     *
     * @param int $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get Is Restock Complete
     *
     * @return int|null
     */
    public function getIsRestockComplete();

    /**
     * Set Is Restock Complete
     *
     * @param int $isRestockComplete
     * @return $this
     */
    public function setIsRestockComplete($isRestockComplete);
    /**
     * Get Is Direct Restock
     *
     * @return int|null
     */
    public function getIsDirectRestock();

    /**
     * SetIs Direct Restock
     *
     * @param int $isDirectRestock
     * @return $this
     */
    public function setIsDirectRestock($isDirectRestock);

    /**
     * Get Requisition Method
     *
     * @return int|null
     */
    public function getRequisitionMethod();

    /**
     * Set Requisition Method
     *
     * @param int $requisitionMethod
     * @return $this
     */
    public function setRequisitionMethod($requisitionMethod);

    /**
     * Get Requisition Report Type
     *
     * @return int|null
     */
    public function getRequisitionReportType();

    /**
     * Set Requisition Report Type
     *
     * @param int $requisitionReportType
     * @return $this
     */
    public function setRequisitionReportType($requisitionReportType);

    /**
     * Get  Status Fulfilled By
     *
     * @return string|null
     */
    public function getStatusFulfilledBy();

    /**
     * Set Status Fulfilled By
     *
     * @param string $statusFulfilledBy
     * @return $this
     */
    public function setStatusFulfilledBy($statusFulfilledBy);

    /**
     * Get  Status Updated By
     *
     * @return string|null
     */
    public function getStatusUpdatedBy();

    /**
     * Set Status Updated By
     *
     * @param string $statusUpdatedBy
     * @return $this
     */
    public function setStatusUpdatedBy($statusUpdatedBy);

    /**
     * Get  Status Updated At
     *
     * @return string|null
     */
    public function getStatusUpdatedAt();

    /**
     * Set Status Updated At
     *
     * @param string $statusUpdatedAt
     * @return $this
     */
    public function setStatusUpdatedAt($statusUpdatedAt);

    /**
     * Get  Created At
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set  Created At
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get Update At
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set Update At
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get Safety Item Name
     *
     * @return string|null
     */
    public function getSafetyItemName();

    /**
     * Set Safety Item Name
     *
     * @param string $safetyItemName
     * @return $this
     */
    public function setSafetyItemName($safetyItemName);

    /**
     * Get Safety Item Image
     *
     * @return string|null
     */
    public function getSafetyItemImage();

    /**
     * Set Safety Item Image
     *
     * @param string $safetyItemImage
     * @return $this
     */
    public function setSafetyItemImage($safetyItemImage);

    /**
     * Get Safety Item Model Number
     *
     * @return string|null
     */
    public function getModelNumber();

    /**
     * Set Safety Item Model Number
     *
     * @param string $safetyItemModelNumber
     * @return $this
     */
    public function setModelNumber($safetyItemModelNumber);

    /**
     * Get Safety Item Serial Number
     *
     * @return string|null
     */
    public function getSerialNumber();

    /**
     * Set Safety Item Serial Number
     *
     * @param string $safetyItemSerialNumber
     * @return $this
     */
    public function setSerialNumber($safetyItemSerialNumber);

    /**
     * Get Safety Item Nickname
     *
     * @return string|null
     */
    public function getNickname();

    /**
     * Set Safety Item Nickname
     *
     * @param string $safetyItemNickname
     * @return $this
     */
    public function setNickname($safetyItemNickname);
    /**
     * Get Requisition Associated Products.
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsInterface[]
     */
    public function getAssociatedProducts();

    /**
     * Set Requisition Associated Products.
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsInterface[] $products
     * @return $this
     */
    public function setAssociatedProducts(array $products = null);
    /**
     * Get Message
     *
     * @return string|null
     */
    public function getMessage();

    /**
     * Set Message
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message);
}
