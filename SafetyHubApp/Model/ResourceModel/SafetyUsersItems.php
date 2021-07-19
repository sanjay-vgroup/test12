<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel;

class SafetyUsersItems extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

	const TBL_SAFETYITEM_PRODUCTS = 'safetyhubapp_items_products';

	/**
	 * @var  \Vgroup\SafetyHubApp\Model\SafetyItemsFactory $safetyItemFactory
	 *
	 * @var SafetyitemFactory
	 */
	protected $safetyItemFactory;

	/**
	 * Construct
	 *
	 * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
	 * @param  \Vgroup\SafetyHubApp\Model\ResourceModel\SafetyItems\CollectionFactory $safetyItemsCollectionFactory
	 * @param string|null $resourcePrefix
	 */
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context,
		\Vgroup\SafetyHubApp\Model\SafetyItemsFactory $safetyItemFactory,
		$resourcePrefix = null
	) {
		parent::__construct($context, $resourcePrefix);
		$this->safetyItemFactory = $safetyItemFactory;
	}

	protected function _construct()
	{
		$this->_init('safetyhubapp_users_items', 'entity_id');
	}

	/**
	 * Add Safety Item and Associated Products
	 *
	 * @return $this
	 */
	protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object)
	{

		$object->setPhysicalInventoryDate(date("m-d-Y", strtotime($object->getPhysicalInventoryDate())));
		$safetyItem = $this->safetyItemFactory->create()->load($object->getModelNumber(), 'model_number');
		$associatedProducts = $safetyItem->getProducts($safetyItem, ['product_id', 'qty'], $object->getId());
		$safetyItemData[] = $safetyItem->getData();
		$object->setSafetyItem($safetyItemData);
		$object->setProductsCount(count($associatedProducts));
		$object->setAssociatedProducts($associatedProducts);
		return parent::_afterLoad($object);
	}

	/**
	 * After Save Inventory
	 * @param  \Magento\Framework\Model\AbstractModel $object
	 */
	protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
	{


		$productsInventory = [];
		$inventoryHistoryData = [];
		$deleteProductsInventory = [];
		$table = $this->getTable('safetyhubapp_physicalinventory');
		$inventoryHistoryTable = $this->getTable('safetyhubapp_physicalinventory_history');
		$connection = $this->getConnection();
		//	$inCond = $connection->prepareSqlCondition($table . '.row_id', ['eq' => $object->getId()]);
		//	$query = $connection->select()
		//		->from($table, ['COUNT(id)'])
		//		->where($table . '.row_id = ?', $object->getId());
		//	echo $query;
		//	$totalCount = $connection->fetchOne($query);
		if (is_array($object->getAssociatedProducts()) && count($object->getAssociatedProducts()) > 0) {
			foreach ($object->getAssociatedProducts() as $productInventory) :

				$deleteProductsInventory[] = $productInventory['product_id'];

				$productsInventory[] = [
					'row_id' => (int) $object->getId(),
					'product_id' => (int) $productInventory['product_id'],
					'status' => (int) $productInventory['physical_inventory_status']
				];

				$inventoryHistoryData[] = [
					'row_id' => (int) $object->getId(),
					'user_id' => (int) $object->getUserId(),
					'product_id' => (int) $productInventory['product_id'],
					'status' => (int) $productInventory['physical_inventory_status'],
					'check_date' => $object->getPhysicalInventoryDate()
				];

			endforeach;

			$connection->delete($table, [$table . '.row_id = ?' => $object->getId(), $table . '.product_id IN(?)' => $deleteProductsInventory]);
			$connection->insertMultiple($table, $productsInventory);
			$connection->insertMultiple($inventoryHistoryTable, $inventoryHistoryData);
		}

		return parent::_afterSave($object);
	}


	public function addCheckOk($data)
	{

		$table = $this->getTable('safetyhubapp_status');
		$connection = $this->getConnection();
		$query = $connection->select()
			->from($table, ['id', 'safetyitem_ok_date'])
			->where($table . '.row_id = ?', $data['row_id'])
			->where($table . '.safetyitem_ok_date = ?', $data['safetyitem_ok_date'])
			->where($table . '.customer_id = ?', $data['customer_id']);

		$result = $connection->fetchRow($query);
		if (!isset($result['id'])) {
			$connection->insert($table, $data);
			return array('status' => 1, 'id' => $connection->lastInsertId(), 'date' => $data['safetyitem_ok_date']);
		} else {
			return array('status' => 2, 'id' => $result['id'], 'date' => $result['safetyitem_ok_date']);
		}
	}

	/**
	 * @param array $userSafetyItemData
	 * @return array $result
	 */
	public function getPhysicalInventoryData($userSafetyItemData)
	{
		$connection = $this->getConnection();
		// $table = $this->getTable('safetyhubapp_physicalinventory');
		// $query = $connection->select()
		// 	->from($table, ['product_id', 'status'])
		// 	->where($table . '.row_id = ?', $userSafetyItemData['id']);
		$query = "SELECT `safetyhubapp_items_products`.`product_id` AS `product_id`, IFNULL(`safetyhubapp_physicalinventory`.`status`,1) AS `status` FROM `safetyhubapp_users_items` AS `main_table` LEFT JOIN `safetyhubapp_items` AS `protypes` ON protypes.model_number=main_table.model_number 
		LEFT JOIN `safetyhubapp_items_products` ON protypes.entity_id=safetyhubapp_items_products.row_id 
		LEFT JOIN `safetyhubapp_physicalinventory` ON safetyhubapp_physicalinventory.row_id = main_table.entity_id AND safetyhubapp_physicalinventory.product_id = safetyhubapp_items_products.product_id 
		WHERE (`main_table`.`entity_id` = '" . $userSafetyItemData['id'] . "') GROUP BY `safetyhubapp_items_products`.`product_id` ORDER BY `main_table`.`entity_id` DESC";
		$result = $connection->fetchAll($query);
		return $result;
	}
}
