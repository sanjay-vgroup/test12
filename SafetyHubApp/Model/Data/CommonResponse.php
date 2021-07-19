<?php

namespace Vgroup\SafetyHubApp\Model\Data;

class CommonResponse implements \Vgroup\SafetyHubApp\Api\Data\CommonResponseInterface {

    public $status;
    public $message;

    public function setStatus($status) {
        $this->status = $status;
        return $this;
        //$this->setData(self::STATUS, $status);
    }

    public function getStatus() {
        return $this->status;
        //$this->_get(self::STATUS);
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
        //$this->setData(self::MESSAGE, $message);
    }

    public function getMessage() {
        return $this->message;
        // $this->_get(self::MESSAGE);
    }

}
