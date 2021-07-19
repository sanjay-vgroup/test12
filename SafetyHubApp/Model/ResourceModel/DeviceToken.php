<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel;

class DeviceToken extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    public function __construct(
    \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct() {
        $this->_init('safetyhubapp_device_token', 'rel_id');
    }

}
