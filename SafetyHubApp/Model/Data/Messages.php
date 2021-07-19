<?php

namespace Vgroup\SafetyHubApp\Model\Data;

use Vgroup\SafetyHubApp\Api\Data\MessageInterface;

class Messages implements MessageInterface
{


    public $status;
    public $message;
    public $requestId;
    public $type;
    /**
     * {@inheritDoc}
     */
    public function getMsg()
    {
        return $this->message;
        //return $this->_get(self::MSG);
    }
    /**
     * {@inheritDoc}
     */
    public function getRequestId()
    {
        return $this->requestId;
        //return $this->_get(self::REQUEST_ID);
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
    public function getType()
    {
        return $this->type;
        //return $this->_get(self::TYPE);
    }
    /**
     * {@inheritDoc}
     */
    public function setMsg($message)
    {
        $this->message = $message;
        return $this;
        //return $this->setData(self::MSG, $msg);
    }
    /**
     * {@inheritDoc}
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
        return $this;
        //return $this->setData(self::REQUEST_ID, $requestId);
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
    public function setType($type)
    {
        $this->type = $type;
        return $this;
        //return $this->setData(self::TYPE, $type);
    }
}
