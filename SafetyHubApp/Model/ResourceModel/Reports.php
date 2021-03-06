<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel;

/**
 * Reports Resource
 */
class Reports extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param string|null $resourcePrefix
     */
    public function __construct(
	    \Magento\Framework\Model\ResourceModel\Db\Context $context,
	    \Magento\Framework\Stdlib\DateTime\DateTime $date,
	    $resourcePrefix = null
    ) {
	parent::__construct($context, $resourcePrefix);
	$this->_date = $date;
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct() {
	$this->_init('safetyhubapp_reports', 'id');
    }

    /**
     * Process post data before saving
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object) {
	if ($object->isObjectNew() && !$object->hasCreatedAt()) {
	    $object->setCreatedAt($this->_date->gmtDate());
	}

	$object->setUpdatedAt($this->_date->gmtDate());

	return parent::_beforeSave($object);
    }

}
