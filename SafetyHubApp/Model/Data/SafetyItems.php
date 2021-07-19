<?php

namespace Vgroup\SafetyHubApp\Model\Data;

use \Magento\Framework\Api\AttributeValueFactory;

class SafetyItems extends \Magento\Framework\Api\AbstractExtensibleObject implements \Vgroup\SafetyHubApp\Api\Data\SafetyItemsInterface {

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

    public function getId() {
	return $this->_get(self::ID);
    }

    public function getName() {
	return $this->_get(self::NAME);
    }

    public function getType() {
	return $this->_get(self::TYPE);
    }

    public function getModelNumber() {
	return $this->_get(self::MODEL_NUMBER);
    }


    public function getSku() {
	return $this->_get(self::SKU);
    }

    public function getUpc() {
	return $this->_get(self::UPC);
    }

    public function getDescription() {
	return $this->_get(self::TYPE);
    }

    public function getImage() {
	return $this->_get(self::IMAGE);
    }

    public function getFile() {
	return $this->_get(self::FILE);
    }

    public function getStatus() {
	return $this->_get(self::STATUS);
    }

    public function getCreatedAt() {
	return $this->_get(self::CREATED_AT);
    }

    public function getUpdatedAt() {
	return $this->_get(self::UPDATED_AT);
    }

    public function setId($id) {
	return $this->setData(self::ID, $id);
    }

    public function setType($type) {
	return $this->setData(self::TYPE, $type);
    }

    public function setName($name) {
	return $this->setData(self::NAME, $name);
    }

    public function setDescription($description) {
	return $this->setData(self::DESCRIPTION, $description);
    }

    public function setModelNumber($modelNumber) {
	return $this->setData(self::MODEL_NUMBER, $modelNumber);
    }

    public function setSku($sku) {
	return $this->setData(self::SKU, $sku);
    }

    public function setUpc($upc) {
	return $this->setData(self::UPC, $upc);
    }

    public function setImage($image) {
	return $this->setData(self::IMAGE, $image);
    }

    public function setFile($file) {
	return $this->setData(self::FILE, $file);
    }

    public function setStatus($status) {
	return $this->setData(self::STATUS, $status);
    }

    public function setCreatedAt($createdAt) {
	return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function setUpdatedAt($updatedAt) {
	return $this->setData(self::UPDATED_AT, $updatedAt);
    }

}
