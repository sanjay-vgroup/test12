<?php

namespace Vgroup\SafetyHubApp\Model\Data;

use \Magento\Framework\Api\AttributeValueFactory;

class SafetyItemProducts extends \Magento\Framework\Api\AbstractExtensibleObject implements \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsInterface
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

    public function getProductId()
    {
        return $this->_get(self::PRODUCT_ID);
    }

    public function getName()
    {
        return $this->_get(self::NAME);
    }

    public function getQty()
    {
        return $this->_get(self::QTY);
    }

    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    public function setQty($qty)
    {
        return $this->setData(self::QTY, $qty);
    }

    public function getIsAnsiRefillPack()
    {
        return $this->_get(self::IS_ANSI_REFILL_PACK);
    }

    public function setIsAnsiRefillPack($isAnsiRefillPack)
    {
        return $this->setData(self::IS_ANSI_REFILL_PACK, $isAnsiRefillPack);
    }

    public function getPhysicalInventoryStatus()
    {
        return $this->_get(self::PHYSICAL_INVENTORY_STATUS);
    }

    public function setPhysicalInventoryStatus($physicalInventoryStatus)
    {
        return $this->setData(self::PHYSICAL_INVENTORY_STATUS, $physicalInventoryStatus);
    }

    public function getAsin()
    {
        return $this->_get(self::ASIN);
    }

    public function getCustomerPartNumber()
    {
        return $this->_get(self::CUSTOMER_PART_NUMBER);
    }

    public function getDisableEditing()
    {
        return $this->_get(self::DISABLE_EDITING);
    }

    public function getFaoPart()
    {
        return $this->_get(self::FAO_PART);
    }

    public function getMaxQty()
    {
        return $this->_get(self::MAX_QTY);
    }

    public function getUnitPrice()
    {
        return $this->_get(self::UNIT_PRICE);
    }

    public function getUpc()
    {
        return $this->_get(self::UPC);
    }

    public function setAsin($asin)
    {
        return $this->setData(self::ASIN, $asin);
    }

    public function setCustomerPartNumber($customerPartNumber)
    {
        return $this->setData(self::CUSTOMER_PART_NUMBER, $customerPartNumber);
    }

    public function setDisableEditing($disableEditing)
    {
        return $this->setData(self::DISABLE_EDITING, $disableEditing);
    }

    public function setFaoPart($faoPart)
    {
        return $this->setData(self::FAO_PART, $faoPart);
    }

    public function setMaxQty($maxQty)
    {
        return $this->setData(self::MAX_QTY, $maxQty);
    }

    public function setUnitPrice($unitPrice)
    {
        return $this->setData(self::UNIT_PRICE, $unitPrice);
    }

    public function setUpc($upc)
    {
        return $this->setData(self::UPC, $upc);
    }

    public function getImageUrl()
    {
        return $this->_get(self::IMAGE_URL);
    }

    public function setImageUrl($imageUrl)
    {
        return $this->setData(self::IMAGE_URL, $imageUrl);
    }

    public function getRestockQty()
    {
        return $this->_get(self::RESTOCK_QTY);
    }

    public function setRestockQty($restockQty)
    {
        return $this->setData(self::RESTOCK_QTY, $restockQty);
    }
}
