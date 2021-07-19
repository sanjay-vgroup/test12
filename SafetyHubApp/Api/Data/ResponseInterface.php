<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api\Data;

/**
 * Response Interface.
 * @api
 * @since 100.0.2
 */
interface ResponseInterface
{

    /**
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const STATUS = 'status';
    const RESPONSE = 'response';
    const SYNC_DATE = 'sync_date';
    const CHECK_OK_DATE = 'check_ok_date';
    const MESSAGE = 'message';
    const CUSTOMER_ID = 'customer_id';
    const COMPANY_ID = 'company_id';
    const EMAIL = 'email';
    const OTHER_EMAILS = 'other_emails';

    /**
     * Get Status
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set Status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get Response
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\MessageInterface[]
     */
    public function getResponse();

    /**
     * Set Response
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\MessageInterface[] $response
     * @return $this
     */
    public function setResponse(array $response = null);

    /**
     * Get Sync Date
     *
     * @return string
     */
    public function getSyncDate();

    /**
     * Set Sync Date
     *
     * @param string $syncDate
     * @return $this
     */
    public function setSyncDate($syncDate);
    /**
     * Get Check Ok
     *
     * @return string
     */
    public function getCheckOkDate();

    /**
     * Set Check ok
     *
     * @param string $checkOk
     * @return $this
     */
    public function setCheckOkDate($checkOk);
    /**
     * Get Message
     *
     * @return string
     */
    public function getMessage();

    /**
     * Set Message
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message);
    /**
     * Get Customer Id
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set Customer Id
     *
     * @param string $customerId
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
     * @param string $companyId
     * @return $this
     */
    public function setCompanyId($companyId);
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
     * Get Other Emails
     *
     * @return string[]
     */
    public function getOtherEmails();

    /**
     * Set Other Emails
     *
     * @param string[] $otherEmails
     * @return $this
     */
    public function setOtherEmails($otherEmails);
}
