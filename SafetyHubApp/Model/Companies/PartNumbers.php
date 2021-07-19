<?php

namespace Vgroup\SafetyHubApp\Model\Companies;

use Magento\Framework\DataObject\IdentityInterface;

class PartNumbers extends \Magento\Framework\Model\AbstractModel implements IdentityInterface {

    
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'safetyhubapp_companies_partnumbers';

    protected function _construct() {

	$this->_init('Vgroup\SafetyHubApp\Model\ResourceModel\Companies\PartNumbers');
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities() {
	return [self::CACHE_TAG . '_' . $this->getId()];
    }

}
