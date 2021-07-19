<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel\Requisitions;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct() {
	$this->_init('Vgroup\SafetyHubApp\Model\Requisitions', 'Vgroup\SafetyHubApp\Model\ResourceModel\Requisitions');
    }

//     protected function _initSelect() {
// 	parent::_initSelect();
// 	$this->addFilterToMap('entity_id', 'main_table.entity_id');
// 	$this->addFilterToMap('requisition_email_address', 'main_table.requisition_email_address');
// 	$this->addFilterToMap('name', new \Zend_Db_Expr("CONCAT(main_table.firstname, ' ',main_table.lastname)"));
// 	$this->addFilterToMap('street', new \Zend_Db_Expr("CONCAT(main_table.street1, ' ',IFNULL(main_table.street2,''))"));
// //	$this->addFilterToMap('street', 'customer_grid_flat.billing_street');
// //	$this->addFilterToMap('city', 'customer_grid_flat.billing_city');
// //	$this->addFilterToMap('region', 'customer_grid_flat.billing_region');
// //	$this->addFilterToMap('postcode', 'customer_grid_flat.billing_postcode');
// //	$this->addFilterToMap('company', 'safetyhubapp_companies.name');
// 	$this->getSelect()
// 		->columns(new \Zend_Db_Expr("CONCAT(main_table.firstname, ' ',main_table.lastname) AS name"))
// 		->columns(new \Zend_Db_Expr("CONCAT(main_table.street1, ' ',IFNULL(main_table.street2,'')) AS street"))
// 		->joinLeft(['safetyhubapp_users_items' => $this->getTable('safetyhubapp_users_items')],
// 			'main_table.safety_item_id = safetyhubapp_users_items.entity_id',
// 			[
// 			    'serial_number' => 'safetyhubapp_users_items.serial_number',
// 			    'model_number' => 'safetyhubapp_users_items.model_number',
// 			    'nickname' => 'safetyhubapp_users_items.nickname',
// //			    'street1' => 'safetyhubapp_users_items.street1',
// //			    'street2' => 'safetyhubapp_users_items.street2',
// //			    'city' => 'safetyhubapp_users_items.city',
// //			    'region' => 'safetyhubapp_users_items.region'
// 			]
// 		)
// 		->joinLeft(['safetyhubapp_requisitions_items' => 'safetyhubapp_requisitions_items'],
// 			'safetyhubapp_requisitions_items.requisition_id  = main_table.entity_id',
// 			[
// 			    'sku' => 'safetyhubapp_requisitions_items.sku',
// 			    'item_name' => 'safetyhubapp_requisitions_items.name',
// 			    'company_sku' => 'safetyhubapp_requisitions_items.company_sku',
// 			    'company_name' => 'safetyhubapp_requisitions_items.company_name'
// 			]
// 		)
// //		->joinLeft(
// //			['customer_grid_flat' => 'customer_grid_flat'],
// //			'main_table.customer_id = customer_grid_flat.entity_id',
// //			[
// //			    'customer_email' => 'customer_grid_flat.email',
// //			    'customer_name' => 'customer_grid_flat.name',
// //			    'customer_city' => 'customer_grid_flat.billing_city',
// //			    'customer_region' => 'customer_grid_flat.billing_region',
// //			    'customer_telephone' => 'customer_grid_flat.billing_telephone',
// //			    'customer_street' => 'customer_grid_flat.billing_street',
// //			    'customer_postcode' => 'customer_grid_flat.billing_postcode'
// //			]
// //		)
// 		->joinLeft(
// 			['safetyhubapp_companies' => 'safetyhubapp_companies'],
// 			'main_table.company_id = safetyhubapp_companies.entity_id',
// 			[
// 			    'company' => 'safetyhubapp_companies.name',
// 			]
// 	);

// 	$this->getSelect()->group('main_table.entity_id');
// 	$this->getSelect()->order('main_table.entity_id DESC');
// 	//echo $this->getSelect();
// 	return $this;
//     }

}
