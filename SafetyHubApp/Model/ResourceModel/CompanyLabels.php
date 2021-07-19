<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel;

/**
 * ProductsGrid mysql resource
 */
class CompanyLabels extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

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
	    \Magento\Framework\Model\ResourceModel\Db\Context $context, \Magento\Framework\Stdlib\DateTime\DateTime $date, $resourcePrefix = null
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
	$this->_init('safetyhubapp_companies_labels', 'id');
    }

    protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object) {
	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	$companyFactory = $objectManager->get('\Vgroup\SafetyHubApp\Model\CompanyLabelsFactory');
	$company = $companyFactory->create()->getCollection();
	foreach ($company as $label):
	    $companyLabels[$label->getIdentifier()] = $label->getCompanyLabel();
	endforeach;
//        $object->setCompanyLabels(array($companyLabels));
	return parent::_afterLoad($object);
    }

}
