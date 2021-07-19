<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api\Data;

/**
 * Report Interface.
 * @api
 * @since 100.0.2
 */
interface ReportInterface {

    /**
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const ID = 'id';
    const REPORT_TYPE = 'report_type';
    const USER_ID = 'user_id';
    const ENTITY_IDENTIFIER = 'entity_identifier';
    const MODEL_NUMBER = 'model_number';
    const SENDER_EMAIL = 'sender_email';
    const RECIPIENTS = 'recipients';
    const FILTERS = 'filters';
    const EMAIL_SENT = 'email_sent';
    const SEND_EMAIL = 'send_email';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Get Report Id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set Report Id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get Report Type
     *
     * @return int|null
     */
    public function getReportType();

    /**
     * Set Report Type
     *
     * @param int $reportType
     * @return $this
     */
    public function setReportType($reportType);

    /**
     * Get User Id
     *
     * @return int|null
     */
    public function getUserId();

    /**
     * Set User Id
     *
     * @param int $userId
     * @return $this
     */
    public function setUserId($userId);

    /**
     * Get Entity Identifier
     *
     * @return int|null
     */
    public function getEntityIdentifier();

    /**
     * Set Entity Identifier
     *
     * @param int $entityIdentifier
     * @return $this
     */
    public function setEntityIdentifier($entityIdentifier);

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
     * Get Sender Email
     *
     * @return string|null
     */
    public function getSenderEmail();

    /**
     * Set Sender Email
     *
     * @param string $senderEmail
     * @return $this
     */
    public function setSenderEmail($senderEmail);

    /**
     * Get Recipients
     *
     * @return string[]|null
     */
    public function getRecipients();

    /**
     * Set Recipients
     *
     * @param string[] $recipients
     * @return $this
     */
    public function setRecipients($recipients);

    /**
     * Get Filters
     *
     * @return string[]|null
     */
    public function getFilters();

    /**
     * Set Filters
     *
     * @param string[] $filters
     * @return $this
     */
    public function setFilters($filters);

    /**
     * Get Email Sent
     *
     * @return int|null
     */
    public function getEmailSent();

    /**
     * Set Email Sent
     *
     * @param int $emailSent
     * @return $this
     */
    public function setEmailSent($emailSent);

    /**
     * Get Send Mail
     *
     * @return int|null
     */
    public function getSendMail();

    /**
     * Set Send Mail
     *
     * @param int $sendMail
     * @return $this
     */
    public function setSendMail($sendMail);

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
}
