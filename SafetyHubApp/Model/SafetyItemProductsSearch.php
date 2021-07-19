<?php

namespace Vgroup\SafetyHubApp\Model;

use Magento\Framework\DataObject\IdentityInterface;

class SafetyItemProductsSearch extends \Magento\Framework\Model\AbstractModel implements IdentityInterface {

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'catalog_product_entity';

    /**
     * @var string
     */
    protected $_cacheTag = 'catalog_product_entity';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'catalog_product_entity';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct() {

	$this->_init('Vgroup\SafetyHubApp\Model\ResourceModel\SafetyItemProductsSearch');
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
