<?php

namespace Vgroup\SafetyHubApp\Model\Data;

use \Magento\Framework\Api\AttributeValueFactory;

class SafetyItemProductsSearch extends \Magento\Framework\Api\AbstractExtensibleObject implements \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchInterface
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

    public function getSafetyItemName()
    {
        return $this->_get(self::NAME);
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

    public function getStreet1()
    {
        return $this->_get(self::STREET1);
    }

    public function getStreet2()
    {
        return $this->_get(self::STREET2);
    }

    public function getCity()
    {
        return $this->_get(self::CITY);
    }

    public function getRegionId()
    {
        return $this->_get(self::REGION_ID);
    }

    public function getRegionCode()
    {
        return $this->_get(self::REGION_CODE);
    }

    public function getProductId()
    {
        return $this->_get(self::PRODUCT_ID);
    }

    public function getItemName()
    {
        return $this->_get(self::ITEM_NAME);
    }

    public function getQty()
    {
        return $this->_get(self::QTY);
    }

    public function getFaoPart()
    {
        return $this->_get(self::FAO_PART);
    }

    public function getUpc()
    {
        return $this->_get(self::UPC);
    }

    public function getIsAnsiRefillPack()
    {
        return $this->_get(self::IS_ANSI_REFILL_PACK);
    }

    public function setSafetyItemName($name)
    {
        return $this->setData(self::NAME, $name);
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

    public function setStreet1($street1)
    {
        return $this->setData(self::STREET1, $street1);
    }

    public function setStreet2($street2)
    {
        return $this->setData(self::STREET2, $street2);
    }

    public function setCity($city)
    {
        return $this->setData(self::CITY, $city);
    }

    public function setRegionId($regionId)
    {
        return $this->setData(self::REGION_ID, $regionId);
    }

    public function setRegionCode($regionCode)
    {
        return $this->setData(self::REGION_CODE, $regionCode);
    }

    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    public function setItemName($itemName)
    {
        return $this->setData(self::ITEM_NAME, $itemName);
    }

    public function setQty($qty)
    {
        return $this->setData(self::QTY, $qty);
    }

    public function setFaoPart($faoPart)
    {
        return $this->setData(self::FAO_PART, $faoPart);
    }

    public function setUpc($upc)
    {
        return $this->setData(self::UPC, $upc);
    }

    public function setIsAnsiRefillPack($isAnsiRefillPack)
    {
        return $this->setData(self::IS_ANSI_REFILL_PACK, $isAnsiRefillPack);
    }

    public function getSafetyItemUpc()
    {
        return $this->_get(self::SAFETY_ITEM_UPC);
    }

    public function setSafetyItemUpc($safetyItemUpc)
    {
        return $this->setData(self::SAFETY_ITEM_UPC, $safetyItemUpc);
    }

    public function getRegion()
    {
        return $this->_get(self::REGION);
    }

    public function setRegion($region)
    {
        return $this->setData(self::REGION, $region);
    }

    public function getCompanyName()
    {
        return $this->_get(self::COMPANY_NAME);
    }

    public function getCompanySku()
    {
        return $this->_get(self::COMPANY_SKU);
    }

    public function setCompanyName($companyName)
    {
        return $this->setData(self::COMPANY_NAME, $companyName);
    }

    public function setCompanySku($companySku)
    {
        return $this->setData(self::COMPANY_SKU, $companySku);
    }

    public function getUserSafetyItemId()
    {
        return $this->_get(self::USER_SAFETY_ITEM_ID);
    }

    public function setUserSafetyItemId($userSafetyItemId)
    {
        return $this->setData(self::USER_SAFETY_ITEM_ID, $userSafetyItemId);
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

    public function getSafetyItemType()
    {
        return $this->_get(self::SAFETY_ITEM_TYPE);
    }

    public function setSafetyItemType($safetyItemType)
    {
        return $this->setData(self::SAFETY_ITEM_TYPE, $safetyItemType);
    }

    public function getRequisitionId()
    {
        return $this->_get(self::REQUISITION_ID);
    }

    public function setRequisitionId($requisitionId)
    {
        return $this->setData(self::REQUISITION_ID, $requisitionId);
    }

    public function getIsApi()
    {
        return $this->_get(self::IS_API);
    }

    public function setIsApi($isApi)
    {
        return $this->setData(self::IS_API, $isApi);
    }
}
