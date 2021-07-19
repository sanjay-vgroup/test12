<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel;

class SafetyItemProductsSearch extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct() {
	$this->_init('catalog_product_entity', 'entity_id');
    }

}
