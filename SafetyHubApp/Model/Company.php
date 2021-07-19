<?php
namespace Vgroup\SafetyHubApp\Model;
class Company extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'vgroup_safetyhubapp_company';

	protected $_cacheTag = 'vgroup_safetyhubapp_company';

	protected $_eventPrefix = 'vgroup_safetyhubapp_company';

	protected function _construct()
	{
		$this->_init('Vgroup\SafetyHubApp\Model\ResourceModel\Company');
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