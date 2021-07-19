<?php
namespace Vgroup\SafetyHubApp\Model;
class Customer extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'vgroup_dashboard_customer';

	protected $_cacheTag = 'vgroup_dashboard_customer';

	protected $_eventPrefix = 'vgroup_dashboard_customer';

	protected function _construct()
	{
		$this->_init('Vgroup\SafetyHubApp\Model\ResourceModel\Customer');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}