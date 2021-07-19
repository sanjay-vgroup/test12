<?php

namespace Vgroup\SafetyHubApp\Model\Data;

use \Magento\Framework\Api\AttributeValueFactory;

class Requisitions extends \Magento\Framework\Api\AbstractExtensibleObject implements
    \Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface
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

    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    public function getComment()
    {
        return $this->_get(self::COMMENT);
    }

    public function getCompanyId()
    {
        return $this->_get(self::COMPANY_ID);
    }

    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    public function getCustomerId()
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    public function getIsRestockComplete()
    {
        return $this->_get(self::IS_RESTOCK_COMPLETE);
    }

    public function getOtherEmailAddresses()
    {
        return $this->_get(self::OTHER_EMAIL_ADDRESSES);
    }

    public function getPurchaseOrder()
    {
        return $this->_get(self::PURCHASE_ORDER);
    }

    public function getRequisitionEmailAddress()
    {
        return $this->_get(self::REQUISITIONS_EMAIL_ADDRESS);
    }

    public function getRequisitionMethod()
    {
        return $this->_get(self::REQUIITION_METHOD);
    }

    public function getRequisitionReportType()
    {
        return $this->_get(self::REQUIITION_REPORT_TYPE);
    }

    public function getRequisitionType()
    {
        return $this->_get(self::REQUISITION_TYPE);
    }

    public function getSafetyItemId()
    {
        return $this->_get(self::SAFETY_ITEM_ID);
    }

    public function getSafetyItemType()
    {
        return $this->_get(self::SAFETY_ITEM_TYPE);
    }

    public function getStatus()
    {
        return $this->_get(self::STATUS);
    }

    public function getStatusFulfilledBy()
    {
        return $this->_get(self::STATUS_FULFILLED_BY);
    }

    public function getStatusUpdatedBy()
    {
        return $this->_get(self::STATUS_UPDATED_BY);
    }

    public function getUpdatedAt()
    {
        return $this->_get(self::UPDATED_AT);
    }

    public function setComment($comment)
    {
        return $this->setData(self::COMMENT, $comment);
    }

    public function setCompanyId($companyId)
    {
        return $this->setData(self::COMPANY_ID, $companyId);
    }

    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    public function setIsRestockComplete($isRestockComplete)
    {
        return $this->setData(self::IS_RESTOCK_COMPLETE, $isRestockComplete);
    }

    public function setOtherEmailAddresses($otherEmailAddresses)
    {
        return $this->setData(self::OTHER_EMAIL_ADDRESSES, $otherEmailAddresses);
    }

    public function setPurchaseOrder($purchaseOrder)
    {
        return $this->setData(self::PURCHASE_ORDER, $purchaseOrder);
    }

    public function setRequisitionEmailAddress($requisitionEmailAddress)
    {
        return $this->setData(self::REQUISITIONS_EMAIL_ADDRESS, $requisitionEmailAddress);
    }

    public function setRequisitionMethod($requisitionMethod)
    {
        return $this->setData(self::REQUIITION_METHOD, $requisitionMethod);
    }

    public function setRequisitionReportType($requisitionReportType)
    {
        return $this->setData(self::REQUIITION_REPORT_TYPE, $requisitionReportType);
    }

    public function setRequisitionType($requisitionType)
    {
        return $this->setData(self::REQUISITION_TYPE, $requisitionType);
    }

    public function setSafetyItemId($safetyItemId)
    {
        return $this->setData(self::SAFETY_ITEM_ID, $safetyItemId);
    }

    public function setSafetyItemType($safetyItemType)
    {
        return $this->setData(self::SAFETY_ITEM_TYPE, $safetyItemType);
    }

    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    public function setStatusFulfilledBy($statusFulfilledBy)
    {
        return $this->setData(self::STATUS_FULFILLED_BY, $statusFulfilledBy);
    }

    public function setStatusUpdatedBy($statusUpdatedBy)
    {
        return $this->setData(self::STATUS_UPDATED_BY, $statusUpdatedBy);
    }

    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    public function getStatusUpdatedAt()
    {
        return $this->_get(self::STATUS_UPDATED_AT);
    }

    public function setStatusUpdatedAt($statusUpdatedAt)
    {
        return $this->setData(self::STATUS_UPDATED_AT, $statusUpdatedAt);
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

    public function getFirstname()
    {
        return $this->_get(self::FIRSTNAME);
    }

    public function getLastname()
    {
        return $this->_get(self::LASTNAME);
    }

    public function getEmail()
    {
        return $this->_get(self::EMAIL);
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

    public function setFirstname($firstname)
    {
        return $this->setData(self::FIRSTNAME, $firstname);
    }

    public function setLastname($lastname)
    {
        return $this->setData(self::LASTNAME, $lastname);
    }

    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
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

    public function getModelNumber()
    {
        return $this->_get(self::SAFETY_ITEM_MODEL_NUMBER);
    }

    public function getSafetyItemName()
    {
        return $this->_get(self::SAFETY_ITEM_NAME);
    }

    public function getNickname()
    {
        return $this->_get(self::SAFETY_ITEM_NICKNAME);
    }

    public function getSerialNumber()
    {
        return $this->_get(self::SAFETY_ITEM_NICKNAME);
    }

    public function setModelNumber($safetyItemModelNumber)
    {
        return $this->setData(self::SAFETY_ITEM_MODEL_NUMBER, $safetyItemModelNumber);
    }

    public function setSafetyItemName($safetyItemName)
    {
        return $this->setData(self::SAFETY_ITEM_NAME, $safetyItemName);
    }

    public function setNickname($safetyItemNickname)
    {
        return $this->setData(self::SAFETY_ITEM_NICKNAME, $safetyItemNickname);
    }

    public function setSerialNumber($safetyItemSerialNumber)
    {
        return $this->setData(self::SAFETY_ITEM_SERIAL_NUMBER, $safetyItemSerialNumber);
    }

    public function getSafetyItemImage()
    {
        return $this->_get(self::SAFETY_ITEM_IMAGE);
    }

    public function setSafetyItemImage($safetyItemImage)
    {
        return $this->setData(self::SAFETY_ITEM_IMAGE, $safetyItemImage);
    }

    public function getAssociatedProducts()
    {
        return $this->_get(self::ASSOCIATED_PRODUCTS);
    }

    public function setAssociatedProducts(array $products = null)
    {
        return $this->setData(self::ASSOCIATED_PRODUCTS, $products);
    }

    public function getIsDirectRestock()
    {
        return $this->_get(self::IS_DIRECT_RESTOCK);
    }

    public function setIsDirectRestock($isDirectRestock)
    {
        return $this->setData(self::IS_DIRECT_RESTOCK, $isDirectRestock);
    }

    public function getMessage()
    {
        return $this->_get(self::MESSAGE);
    }

    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }
}
