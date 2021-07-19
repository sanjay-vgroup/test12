<?php

namespace Vgroup\SafetyHubApp\Model\Data;

use Vgroup\SafetyHubApp\Api\Data\ResponseInterface;

class Response implements ResponseInterface
{


    public $response;
    public $status;
    public $message;
    public $syncDate;
    public $checkOkDate;
    public $customerId;
    public $companyId;
    public $email;
    public $otherEmails;

    /**
     * {@inheritDoc}
     */
    public function getResponse()
    {
        return $this->response;
        //return $this->_get(self::RESPONSE);
    }
    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {
        return $this->status;
        //return $this->_get(self::STATUS);
    }
    /**
     * {@inheritDoc}
     */
    public function getSyncDate()
    {
        return $this->syncDate;
        //return $this->_get(self::SYNC_DATE);
    }
    /**
     * {@inheritDoc}
     */
    public function getCheckOkDate()
    {
        return $this->checkOkDate;
        //return $this->_get(self::CHECK_OK_DATE);
    }
    /**
     * {@inheritDoc}
     */
    public function getMessage()
    {
        return $this->message;
        //return $this->_get(self::MESSAGE);
    }
    /**
     * {@inheritDoc}
     */
    public function setResponse(array $response = null)
    {
        $this->response = $response;
        return $this;
        //return $this->setData(self::RESPONSE, $response);
    }
    /**
     * {@inheritDoc}
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
        //return $this->setData(self::STATUS, $status);
    }
    /**
     * {@inheritDoc}
     */
    public function setSyncDate($syncDate)
    {
        $this->syncDate = $syncDate;
        return $this;
        //return $this->setData(self::SYNC_DATE, $syncDate);
    }
    /**
     * {@inheritDoc}
     */
    public function setCheckOkDate($checkOk)
    {
        $this->checkOkDate = $checkOk;
        return $this;
        //$this->setData(self::CHECK_OK_DATE, $checkOk);
    }
    /**
     * {@inheritDoc}
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
        //$this->setData(self::MESSAGE, $message);
    }
    /**
     * {@inheritDoc}
     */
    public function getCustomerId()
    {
        return $this->customerId;
        //return $this->_get(self::CUSTOMER_ID);
    }
    /**
     * {@inheritdoc}
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
        return $this;
        //return $this->setData(self::CUSTOMER_ID, $customerId);
    }
    /**
     * {@inheritdoc}
     */
    public function getCompanyId()
    {
        return $this->companyId;
        //return $this->_get(self::COMPANY_ID);
    }
    /**
     * {@inheritdoc}
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
        return $this;
        //return $this->setData(self::COMPANY_ID, $companyId);
    }
    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
        //return $this->_get(self::EMAIL);
    }
    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
        //return $this->setData(self::EMAIL, $email);
    }
    /**
     * {@inheritdoc}
     */
    public function getOtherEmails()
    {
        return $this->otherEmails;
        //return $this->_get(self::OTHER_EMAILS);
    }
    /**
     * {@inheritdoc}
     */
    public function setOtherEmails($otherEmails)
    {
        $this->otherEmails = $otherEmails;
        return $this;
        //return $this->setData(self::OTHER_EMAILS, $otherEmails);
    }
}
