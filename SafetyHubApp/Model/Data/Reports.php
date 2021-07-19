<?php

namespace Vgroup\SafetyHubApp\Model\Data;

use \Magento\Framework\Api\AttributeValueFactory;

class Reports extends \Magento\Framework\Api\AbstractExtensibleObject implements \Vgroup\SafetyHubApp\Api\Data\ReportInterface {

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

    public function getCreatedAt() {
	return $this->_get(self::CREATED_AT);
    }

    public function getEmailSent() {
	return $this->_get(self::EMAIL_SENT);
    }

    public function getEntityIdentifier() {
	return $this->_get(self::ENTITY_IDENTIFIER);
    }

    public function getFilters() {
	return $this->_get(self::FILTERS);
    }

    public function getId() {
	return $this->_get(self::ID);
    }

    public function getModelNumber() {
	return $this->_get(self::MODEL_NUMBER);
    }

    public function getRecipients() {
	return $this->_get(self::RECIPIENTS);
    }

    public function getReportType() {
	return $this->_get(self::REPORT_TYPE);
    }

    public function getSendMail() {
	return $this->_get(self::SEND_EMAIL);
    }

    public function getSenderEmail() {
	return $this->_get(self::SENDER_EMAIL);
    }

    public function getUpdatedAt() {
	return $this->_get(self::UPDATED_AT);
    }

    public function getUserId() {
	return $this->_get(self::USER_ID);
    }

    public function setCreatedAt($createdAt) {
	return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function setEmailSent($emailSent) {
	return $this->setData(self::EMAIL_SENT, $emailSent);
    }

    public function setEntityIdentifier($entityIdentifier) {
	return $this->setData(self::ENTITY_IDENTIFIER, $entityIdentifier);
    }

    public function setFilters($filters) {
	return $this->setData(self::FILTERS, $filters);
    }

    public function setId($id) {
	return $this->setData(self::ID, $id);
    }

    public function setModelNumber($modelNumber) {
	return $this->setData(self::MODEL_NUMBER, $modelNumber);
    }

    public function setRecipients($recipients) {
	return $this->setData(self::RECIPIENTS, $recipients);
    }

    public function setReportType($reportType) {
	return $this->setData(self::REPORT_TYPE, $reportType);
    }

    public function setSendMail($sendMail) {
	return $this->setData(self::SEND_EMAIL, $sendMail);
    }

    public function setSenderEmail($senderEmail) {
	return $this->setData(self::SENDER_EMAIL, $senderEmail);
    }

    public function setUpdatedAt($updatedAt) {
	return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    public function setUserId($userId) {
	return $this->setData(self::USER_ID, $userId);
    }

}
