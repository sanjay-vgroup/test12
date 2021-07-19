<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel;

/**
 * ProductsGrid mysql resource
 */
class Companies extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

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
	$this->_init('safetyhubapp_companies', 'entity_id');
    }

    /**
     * Process post data before saving
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object) {
	if ($object->isObjectNew() && !$object->hasCreationTime()) {
	    $object->setCreationTime($this->_date->gmtDate());
	}

	$object->setUpdateTime($this->_date->gmtDate());

	return parent::_beforeSave($object);
    }
    
     /**
     * Unserialize additional_information in each item
     *
     * @return $this
     */
    protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object) {
	
	$preferredDistributors = @explode(",",$object->getPreferredDistributors());
	$object->setPreferredDistributors($preferredDistributors);
	return parent::_beforeSave($object);
    }

}
