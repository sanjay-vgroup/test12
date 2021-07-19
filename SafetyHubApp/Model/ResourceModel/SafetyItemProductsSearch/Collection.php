<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel\SafetyItemProductsSearch;

use Vgroup\SafetyHubApp\Helper\Data;
use Magento\Framework\Data\Collection\EntityFactory;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Psr\Log\LoggerInterface as Logger;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

	/**
	 * @var Vgroup\SafetyHubApp\Helper\Data
	 */
	protected $helper;

	/**
	 * @var string
	 */
	protected $_idFieldName = 'entity_id';

	/**
	 * 
	 */

	/**
	 * @param \Magento\Framework\Data\Collection\EntityFactory $entityFactory
	 * @param Logger $logger
	 * @param FetchStrategyInterface $fetchStrategy
	 * @param ManagerInterface $eventManager
	 * @param \Vgroup\SafetyHubApp\Helper\Data $helper
	 * @param \Magento\Framework\DB\Adapter\AdapterInterface $connection
	 * @param AbstractDb $resource
	 */
	public function __construct(
		EntityFactory $entityFactory,
		Logger $logger,
		FetchStrategyInterface $fetchStrategy,
		ManagerInterface $eventManager,
		Data $helper,
		\Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
		AbstractDb $resource = null
	) {
		$this->helper = $helper;
		parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
	}

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Vgroup\SafetyHubApp\Model\SafetyItemProductsSearch', 'Vgroup\SafetyHubApp\Model\ResourceModel\SafetyItemProductsSearch');
	}

	// protected function _initSelect()
	// {

	// 	////$storeDetail = $this->helper->getStoreManagerData();
	// 	//$mediaUrl = $storeDetail['media_url'];
	// 	parent::_initSelect();

	// 	$this->addFilterToMap('name', 'safetyhubapp_items.title');
	// 	$this->addFilterToMap('user_safety_item_id', 'usersafetyitems_table.entity_id');
	// 	$this->addFilterToMap('model_number', 'usersafetyitems_table.model_number');
	// 	$this->addFilterToMap('serial_number', 'usersafetyitems_table.serial_number');
	// 	$this->addFilterToMap('nickname', 'usersafetyitems_table.nickname');
	// 	$this->addFilterToMap('safety_item_upc', 'usersafetyitems_table.upc');
	// 	$this->addFilterToMap('street1', 'usersafetyitems_table.street1');
	// 	$this->addFilterToMap('street2', 'usersafetyitems_table.street2');
	// 	$this->addFilterToMap('city', 'usersafetyitems_table.city');
	// 	$this->addFilterToMap('region_id', 'usersafetyitems_table.region_id');
	// 	$this->addFilterToMap('region_code', 'usersafetyitems_table.region');
	// 	$this->addFilterToMap('region', 'region_table.default_name');
	// 	$this->addFilterToMap('product_id', 'main_table.entity_id');
	// 	// $this->addFilterToMap('item_name', 'catalog_product_entity_name.value');
	// 	$this->addFilterToMap('qty', 'products_table.qty');
	// 	//$this->addFilterToMap('product_sku', 'main_table.sku');
	// 	$this->addFilterToMap('fao_part', 'main_table.sku');
	// 	// $this->addFilterToMap('upc', 'upc_table.value');
	// 	// $this->addFilterToMap('is_ansi_refill_pack', 'catalog_product_upc.value');
	// 	$this->addFilterToMap('part_number_preference', 'companies.partnumber_preference');
	// 	$this->addFilterToMap('company_product_name', 'companies_partnumbers.title');
	// 	$this->addFilterToMap('company_product_number', 'companies_partnumbers.company_sku');
	// 	//$this->addFilterToMap('image_url', new \Zend_Db_Expr("CONCAT('https://m2.cudabrand.com/pub/media/catalog/product',image_table.value)"));

	// 	$this->getSelect()
	// 		->join(
	// 			['products_table' => $this->getTable('safetyhubapp_items_products')],
	// 			'products_table.product_id = main_table.entity_id',
	// 			['qty' => 'products_table.qty']
	// 		)
	// 		->joinLeft(
	// 			['safetyitems_table' => $this->getTable('safetyhubapp_items')],
	// 			'safetyitems_table.entity_id = products_table.row_id',
	// 			['name' => 'safetyitems_table.title', 'safety_item_upc' => 'safetyitems_table.upc']
	// 		)
	// 		->joinLeft(
	// 			['usersafetyitems_table' => $this->getTable('safetyhubapp_users_items')],
	// 			'usersafetyitems_table.model_number = safetyitems_table.model_number',
	// 			[
	// 				'user_safety_item_id' => 'usersafetyitems_table.entity_id',
	// 				'model_number' => 'usersafetyitems_table.model_number',
	// 				'serial_number' => 'usersafetyitems_table.serial_number',
	// 				'nickname' => 'usersafetyitems_table.nickname',
	// 				'street1' => 'usersafetyitems_table.street1',
	// 				'street2' => 'usersafetyitems_table.street2',
	// 				'city' => 'usersafetyitems_table.city',
	// 				'region_id' => 'usersafetyitems_table.region_id',
	// 				'region_code' => 'usersafetyitems_table.region',
	// 			]
	// 		)
	// 		->joinLeft(
	// 			['region_table' => $this->getTable('directory_country_region')],
	// 			'usersafetyitems_table.region_id = region_table.region_id AND region_table.country_id="US"',
	// 			['region' => 'region_table.default_name']
	// 		)
	// 		->joinLeft(
	// 			['companies_table' => $this->getTable('safetyhubapp_companies')],
	// 			'usersafetyitems_table.company_id = companies_table.entity_id',
	// 			['partnumber_preference' => 'companies_table.partnumber_preference']
	// 		)
	// 		->joinLeft(
	// 			['companies_partnumbers' => $this->getTable('safetyhubapp_companies_partnumbers')],
	// 			'usersafetyitems_table.company_id = companies_partnumbers.row_id AND main_table.sku = companies_partnumbers.default_sku',
	// 			['company_product_name' => 'companies_partnumbers.title', 'company_product_number' => 'companies_partnumbers.company_sku']
	// 		)
	// 		->joinLeft(
	// 			['inventory' => 'safetyhubapp_physicalinventory'],
	// 			'products_table.product_id = inventory.product_id AND inventory.row_id = usersafetyitems_table.entity_id',
	// 			['physical_inventory_status' => 'IFNULL(`inventory`.`status`,1)']
	// 		)
	// 		->joinLeft(
	// 			['description_table' => 'catalog_product_entity_text'],
	// 			'products_table.product_id = description_table.row_id AND description_table.attribute_id = 72 AND description_table.store_id = 0',
	// 			['description' => 'description_table.value']
	// 		)
	// 		->joinLeft(
	// 			['upc_table' => $this->getTable('catalog_product_entity_varchar')],
	// 			'products_table.product_id = upc_table.row_id AND upc_table.attribute_id = 134 AND upc_table.store_id = 2',
	// 			['upc' => 'upc_table.value']
	// 		)
	// 		->joinLeft(
	// 			['image_table' => 'catalog_product_entity_varchar'],
	// 			'products_table.product_id = image_table.row_id AND image_table.attribute_id = 85 AND image_table.store_id = 2',
	// 			['image_url' => new \Zend_Db_Expr("CONCAT('https://m2.cudabrand.com/pub/media/catalog/product',image_table.value)")]
	// 		)
	// 		->joinLeft(
	// 			['name_table' => $this->getTable('catalog_product_entity_varchar')],
	// 			'products_table.product_id = name_table.row_id AND name_table.attribute_id = 71 AND name_table.store_id = 2',
	// 			['item_name' => 'name_table.value']
	// 		)
	// 		->joinLeft(
	// 			['is_ansi_table' => $this->getTable('catalog_product_entity_int')],
	// 			'products_table.product_id = is_ansi_table.row_id AND is_ansi_table.attribute_id = 187 AND is_ansi_table.store_id = 2',
	// 			['is_ansi_refill_pack' => 'is_ansi_table.value']
	// 		)
	// 		->joinLeft(
	// 			['asin_table' => 'catalog_product_entity_varchar'],
	// 			'products_table.product_id = asin_table.row_id AND asin_table.attribute_id = 147 AND asin_table.store_id = 2',
	// 			['asin' => 'asin_table.value']
	// 		)
	// 		->joinLeft(
	// 			['cpn_table' => 'catalog_product_entity_varchar'],
	// 			'products_table.product_id = cpn_table.row_id AND cpn_table.attribute_id = 179 AND cpn_table.store_id = 2',
	// 			['customer_part_number' => 'cpn_table.value']
	// 		)
	// 		->joinLeft(
	// 			['disable_editing_table' => 'catalog_product_entity_varchar'],
	// 			'products_table.product_id = disable_editing_table.row_id AND disable_editing_table.attribute_id = 221 AND disable_editing_table.store_id = 2',
	// 			['disable_editing' => 'IFNULL(disable_editing_table.value,0)']
	// 		)
	// 		->joinLeft(
	// 			['price_table' => 'catalog_product_entity_decimal'],
	// 			'products_table.product_id = price_table.row_id AND price_table.attribute_id = 75 AND price_table.store_id = 0',
	// 			['unit_price' => 'price_table.value']
	// 		)
	// 		->joinLeft(
	// 			['description_table' => 'catalog_product_entity_text'],
	// 			'products_table.product_id = description_table.row_id AND description_table.attribute_id = 72 AND description_table.store_id = 0',
	// 			['description' => 'description_table.value']
	// 		);

	// 	$this->getSelect()->group('main_table.entity_id');

	// 	return $this;
	// }
}
