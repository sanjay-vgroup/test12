<?php
/**
 * VgroupSafetyHubApp
 * 
 * @author Vgroup
 */
namespace Vgroup\SafetyHubApp\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * Class InstallSchema
 */
class InstallSchema implements InstallSchemaInterface {

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {

	$setup->startSetup();
	$this->createSafetyItems($setup);
	$this->createSafetyItemProducts($setup);
	$this->createCompanies($setup);
	$this->createCompaniesPartNumbers($setup);
	$this->createUsersSafetyItems($setup);
	$this->createUsersDeviceTokens($setup);
	$this->createRequsitions($setup);
	$this->createRequsitionsItems($setup);
	$setup->endSetup();
    }

    public function createSafetyItems(\Magento\Framework\Setup\SchemaSetupInterface $setup) {


	$safetyItemsTable = $setup->getConnection()->newTable(
			$setup->getTable('safetyhubapp_items')
		)->addColumn(
			'entity_id',
			TABLE::TYPE_INTEGER,
			null,
			['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
			'Safety Item Id'
		)->addColumn(
			'name',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Name of Safety Item'
		)->addColumn(
			'type',
			TABLE::TYPE_SMALLINT,
			null,
			['nullable' => false],
			'Safety Item Type'
		)->addColumn(
			'model_number',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Model Number of Safety Item'
		)
//		->addColumn(
//			'serial_number',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'Serial Number of Safety Item'
//		)
		->addColumn(
			'sku',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'SKU of Safety Item'
		)->addColumn(
			'upc',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'UPC of Safety Item'
		)->addColumn(
			'description',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Description of Safety Item'
		)->addColumn(
			'image',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Imgae of Safety Item'
		)->addColumn(
			'file',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'file of Safety Item'
		)->addColumn(
			'status',
			TABLE::TYPE_BOOLEAN,
			10,
			['nullable' => false, 'default' => false],
			'Status'
		)->addColumn(
			'created_at',
			TABLE::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => TABLE::TIMESTAMP_INIT],
			'Time Created'
		)->addColumn(
			'updated_at',
			TABLE::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => TABLE::TIMESTAMP_INIT_UPDATE],
			'Time for Updated'
		)->setComment(
		'Safety Items table'
	);

	$isSafetyItemsTable = $setup->getConnection()->createTable($safetyItemsTable);
    }

    public function createSafetyItemProducts(\Magento\Framework\Setup\SchemaSetupInterface $setup) {

	//safetyhubapp_items_products
	//if ($setup->getConnection()->isTableExists($safetyItemsTable) != true) {

	$safetyItemsProductTable = $setup->getConnection()
		->newTable('safetyhubapp_items_products')
		->addColumn(
			'value_id',
			Table::TYPE_INTEGER,
			null,
			['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
			'Increment ID'
		)
		->addColumn(
			'product_id',
			Table::TYPE_INTEGER,
			10,
			['unsigned' => true, 'nullable' => false, 'default' => '0'],
			'Product Id'
		)
		->addColumn(
			'qty',
			Table::TYPE_INTEGER,
			null,
			['unsigned' => true, 'nullable' => false, 'default' => '0'],
			'Safety Item Quantity'
		)
		->addColumn(
			'row_id',
			Table::TYPE_INTEGER,
			10,
			['unsigned' => true, 'nullable' => false, 'default' => '0'],
			'Safety Item Id'
		)
		->addIndex(
			$setup->getIdxName(
				'safetyhubapp_items_products',
				['row_id', 'product_id'],
				AdapterInterface::INDEX_TYPE_UNIQUE
			),
			['row_id', 'product_id'],
			AdapterInterface::INDEX_TYPE_UNIQUE
		)
		->addForeignKey(// Add foreign key for table entity
			$setup->getFkName(
				'safetyhubapp_items_products', // New table
				'row_id', // Column in New Table
				'safetyhubapp_items', // Reference Table
				'entity_id' // Column in Reference table
			),
			'row_id', // New table column
			$setup->getTable('safetyhubapp_items'), // Reference Table
			'entity_id', // Reference Table Column
			// When the parent is deleted, delete the row with foreign key
			Table::ACTION_CASCADE
		)
		->addForeignKey(// Add foreign key for table entity
			$setup->getFkName(
				'safetyhubapp_items_product', // New table
				'product_id', // Column in New Table
				'catalog_product_entity', // Reference Table
				'entity_id' // Column in Reference table
			),
			'product_id', // New table column
			$setup->getTable('catalog_product_entity'), // Reference Table
			'entity_id', // Reference Table Column
			// When the parent is deleted, delete the row with foreign key
			Table::ACTION_CASCADE
		)
		->setComment('SafetyHubApp Items Product');

	$setup->getConnection()->createTable($safetyItemsProductTable);
	//}
    }

    public function createCompanies(\Magento\Framework\Setup\SchemaSetupInterface $setup) {
	//safetyhubapp_companies
	$companiesTable = $setup->getConnection()->newTable(
				$setup->getTable('safetyhubapp_companies')
			)->addColumn(
				'entity_id',
				TABLE::TYPE_INTEGER,
				10,
				['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
				'Company Id'
			)->addColumn(
				'name',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => false],
				'Name of Safety Item'
			)->addColumn(
				'email',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => false],
				'Company Email'
			)->addColumn(
				'company_requisition_email',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Company Requisition Email'
			)->addColumn(
				'phone',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Company Phone'
			)->addColumn(
				'url',
				TABLE::TYPE_TEXT,
				null,
				['nullable' => true],
				'Company Url'
			)->addColumn(
				'hours',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Company Hours'
			)
			->addColumn(
				'logo',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Company Logo'
			)
			->addColumn(
				'panel_bg_color',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Portal Background Color'
			)
			->addColumn(
				'panel_font_color',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Portal Font Color'
			)
			->addColumn(
				'large_action_button1_bg_color',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Company Logo'
			)
			->addColumn(
				'large_action_button1_font_color',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Larege Button Font Color'
			)
			->addColumn(
				'large_action_button2_bg_color',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Large Button 2 Bacground Logo'
			)
			->addColumn(
				'large_action_button2_font_color',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Large Button 2 Font Logo'
			)
			->addColumn(
				'small_buttons_bg_color',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Small Buttons Background Color'
			)
			->addColumn(
				'small_buttons_font_color',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Small Buttons Font Color'
			)
			->addColumn(
				'heading_font_color',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Heading Font Color'
			)
			->addColumn(
				'cms_bg_color',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'CMS Background Color'
			)
			->addColumn(
				'cms_font_color',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'CMS font Color'
			)
			->addColumn(
				'email_template_subject',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Comapny Email Template Subject'
			)
			->addColumn(
				'email_template_content',
				TABLE::TYPE_TEXT,
				'64k',
				['nullable' => true],
				'Comapny Email Template Content'
			)
			->addColumn(
				'email_template_style',
				TABLE::TYPE_TEXT,
				'64k',
				['nullable' => true],
				'Comapny Email Template Style'
			)
			->addColumn(
				'api_user',
				TABLE::TYPE_INTEGER,
				10,
				['nullable' => false, 'default' => 0],
				'Company API user'
			)
			->addColumn(
				'api_username',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Company API username'
			)
			->addColumn(
				'api_password',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Company API password'
			)
			->addColumn(
				'default_paging',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Listing Default Paging'
			)
			->addColumn(
				'requisitions_default_paging',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Company API password'
			)
			->addColumn(
				'safetyitems_default_paging',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Company API password'
			)
			->addColumn(
				'users_default_paging',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => true],
				'Company API password'
			)
			->addColumn(
				'codes',
				TABLE::TYPE_TEXT,
				255,
				['nullable' => false],
				'Company Codes'
			)->addColumn(
			'approval_mode',
			TABLE::TYPE_SMALLINT,
			null,
			['nullable' => false, 'default' => 1],
			'Company Requisition Approval Model'
		)->addColumn(
			    'interval',
			TABLE::TYPE_SMALLINT,
			null,
			['nullable' => false, 'default' => 0],
			'Company Requisition Mail Transfer Interval'
		)->addColumn(
			'is_preferred_distributor',
			TABLE::TYPE_BOOLEAN,
			null,
			['nullable' => false, 'default' => false],
			'Enable/Disable Company Preferred Distributor'
		)->addColumn(
			'preferred_distributors',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Company Preferred Distributor'
		)->addColumn(
			'permission_type',
			TABLE::TYPE_SMALLINT,
			null,
			['nullable' => true, 'default' => 0],
			'Company Permission Type'
		)->addColumn(
			'permissions',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Company Permission Users Permissions'
		)->addColumn(
			'partnumber_preference',
			TABLE::TYPE_SMALLINT,
			null,
			['nullable' => true, 'default' => 0],
			'Company Part Number Preference'
		)->addColumn(
			'restock',
			TABLE::TYPE_SMALLINT,
			null,
			['nullable' => true, 'default' => 0],
			'Company Restock Against Requisition'
		)->addColumn(
			'status',
			TABLE::TYPE_BOOLEAN,
			10,
			['nullable' => false, 'default' => false],
			'Status'
		)->addColumn(
			'created_at',
			TABLE::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => TABLE::TIMESTAMP_INIT],
			'Time Created'
		)->addColumn(
			'updated_at',
			TABLE::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => TABLE::TIMESTAMP_INIT_UPDATE],
			'Time for Updated'
		)->setComment('SafetyHubApp Companies table');

	$isCompaniesTable = $setup->getConnection()->createTable($companiesTable);
    }

    public function createCompaniesPartNumbers(\Magento\Framework\Setup\SchemaSetupInterface $setup) {

	$companiesPartNumbersTable = $setup->getConnection()
		->newTable('safetyhubapp_companies_partnumbers')
		->addColumn(
			'value_id',
			Table::TYPE_INTEGER,
			null,
			['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
			'Increment ID'
		)
		->addColumn(
			'product_id',
			Table::TYPE_INTEGER,
			10,
			['unsigned' => true, 'nullable' => false, 'default' => '0'],
			'Product Id'
		)
		->addColumn(
			'default_sku',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Product Sku'
		)
		->addColumn(
			'company_sku',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Company Part Number'
		)
		->addColumn(
			'title',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Company Title'
		)
		->addColumn(
			'row_id',
			Table::TYPE_INTEGER,
			10,
			['unsigned' => true, 'nullable' => false, 'default' => '0'],
			    'Company Id'
		)
		->addIndex(
			$setup->getIdxName(
				'safetyhubapp_companies_partnumbers',
				['row_id', 'product_id'],
				AdapterInterface::INDEX_TYPE_UNIQUE
			),
			['row_id', 'product_id'],
			AdapterInterface::INDEX_TYPE_UNIQUE
		)
		->addForeignKey(// Add foreign key for table entity
			$setup->getFkName(
				'safetyhubapp_companies_partnumbers', // New table
				'row_id', // Column in New Table
				'safetyhubapp_companies', // Reference Table
				'entity_id' // Column in Reference table
			),
			'row_id', // New table column
			$setup->getTable('safetyhubapp_companies'), // Reference Table
			'entity_id', // Reference Table Column
			// When the parent is deleted, delete the row with foreign key
			Table::ACTION_CASCADE
		)
		->addForeignKey(// Add foreign key for table entity
			$setup->getFkName(
				'safetyhubapp_companies_partnumbers', // New table
				'product_id', // Column in New Table
				'catalog_product_entity', // Reference Table
				'entity_id' // Column in Reference table
			),
			'product_id', // New table column
			$setup->getTable('catalog_product_entity'), // Reference Table
			'entity_id', // Reference Table Column
			// When the parent is deleted, delete the row with foreign key
			Table::ACTION_CASCADE
		)
		->setComment('SafetyHubApp Companies Part Numbers');

	$setup->getConnection()->createTable($companiesPartNumbersTable);
    }

    public function createUsersSafetyItems(\Magento\Framework\Setup\SchemaSetupInterface $setup) {

	$usersSafetyItemsTable = $setup->getConnection()->newTable(
			$setup->getTable('safetyhubapp_users_items')
		)->addColumn(
			'entity_id',
			TABLE::TYPE_INTEGER,
			null,
			['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
			'Safety Item Id'
		)->addColumn(
			'type',
			TABLE::TYPE_SMALLINT,
			null,
			['nullable' => false],
			'Safety Item Type'
		)->addColumn(
			'model_number',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Model Number of Safety Item'
		)->addColumn(
			'serial_number',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Serial Number of Safety Item'
		)->addColumn(
			'nickname',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Nickname of Safety Item'
		)->addColumn(
			'customer_id',
			TABLE::TYPE_INTEGER,
			10,
			['nullable' => true, 'unsigned' => true],
			'Customer Id'
		)
		->addColumn(
			'company_id',
			TABLE::TYPE_INTEGER,
			10,
			['nullable' => true, 'unsigned' => false, 'default' => 0],
			'Company Id'
		)
		->addColumn(
			'refill_reminder_status',
			TABLE::TYPE_BOOLEAN,
			10,
			['nullable' => false, 'default' => false],
			'Reminder Status 1=Normal,2=Physical,3=Expiry'
		)
		->addColumn(
			'refill_reminder_days',
			TABLE::TYPE_INTEGER,
			10,
			['nullable' => true, 'unsigned' => false, 'default' => 0],
			'Reminder Days'
		)
		->addColumn(
			'physical_inventory_status',
			TABLE::TYPE_BOOLEAN,
			10,
			['nullable' => false, 'default' => false],
			'Do Physical inventory of safety item'
		)
		->addColumn(
			'physical_inventory_days',
			TABLE::TYPE_INTEGER,
			10,
			['nullable' => true, 'unsigned' => false, 'default' => 0],
			'Do Physical inventory of safety item days'
		)
		->addColumn(
			'expiration_date',
			TABLE::TYPE_DATE,
			null,
			['nullable' => false],
			'Expiration Date of SafetyItem'
		)
		->addColumn(
			'battery_expiration_date',
			TABLE::TYPE_DATE,
			null,
			['nullable' => false],
			'Battery Expiration Date of SafetyItem/AED'
		)
		->addColumn(
			'pad_expiration_date',
			TABLE::TYPE_DATE,
			null,
			['nullable' => false],
			'Pad Expiration Date of SafetyItem/AED'
		)
		->addColumn(
			'service_due_date',
			TABLE::TYPE_DATE,
			null,
			['nullable' => false],
			'Serivce Due Date of SafetyItem'
		)
		->addColumn(
			'is_restock',
			TABLE::TYPE_BOOLEAN,
			10,
			['nullable' => false, 'default' => false],
			'Safety item Restock or not'
		)
		->addColumn(
			'restock_type',
			TABLE::TYPE_INTEGER,
			2,
			['nullable' => true, 'default' => 0],
			'Restock Type Direct or Non-direct'
		)
		->addColumn(
			'restock_at',
			TABLE::TYPE_DATE,
			null,
			['nullable' => false],
			'Restock of SafetyItem'
		)
		->addColumn(
			'restock_by',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Restock Person SafetyItem'
		)
		->addColumn(
			'last_refill_reminder_sent',
			TABLE::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => TABLE::TIMESTAMP_INIT],
			'Last Refill Reminder sent of Safety Item'
		)
		->addColumn(
			'last_battery_reminder_sent',
			TABLE::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => TABLE::TIMESTAMP_INIT],
			'Last Battery Reminder sent of Safety Item'
		)
		->addColumn(
			'last_pad_reminder_sent',
			TABLE::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => TABLE::TIMESTAMP_INIT],
			'Last Pad Reminder sent of Safety Item'
		)
		->addColumn(
			'last_physical_reminder_sent',
			TABLE::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => TABLE::TIMESTAMP_INIT],
			'Last Physical Inventory Reminder sent of Safety Item'
		)
		->addColumn(
			'created_at',
			TABLE::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => TABLE::TIMESTAMP_INIT],
			'Time Created'
		)->addColumn(
			'updated_at',
			TABLE::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => TABLE::TIMESTAMP_INIT_UPDATE],
			'Time for Updated'
		)
		->addIndex(
			$setup->getIdxName(
				'safetyhubapp_users_items',
				['customer_id'],
				AdapterInterface::INDEX_TYPE_UNIQUE
			),
			['customer_id'],
			AdapterInterface::INDEX_TYPE_UNIQUE
		)
		->addForeignKey(// Add foreign key for table entity
			$setup->getFkName(
				'safetyhubapp_users_items', // New table
				'customer_id', // Column in New Table
				'customer_entity', // Reference Table
				'entity_id' // Column in Reference table
			),
			'customer_id', // New table column
			$setup->getTable('customer_entity'), // Reference Table
			'entity_id', // Reference Table Column
			// When the parent is deleted, delete the row with foreign key
			Table::ACTION_CASCADE
		)
		->setComment('Users SafetyHubApp Items');

	$isUsersSafetyItemsTableTable = $setup->getConnection()->createTable($usersSafetyItemsTable);
    }

    public function createUsersDeviceTokens(\Magento\Framework\Setup\SchemaSetupInterface $setup) {


	$usersTokenTable = $setup->getConnection()->newTable(
			$setup->getTable('safetyhubapp_users_tokens')
		)->addColumn(
			'entity_id',
			TABLE::TYPE_INTEGER,
			null,
			['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
			'Id'
		)->addColumn(
			'customer_id',
			TABLE::TYPE_INTEGER,
			10,
			['nullable' => true, 'unsigned' => true, 'default' => 0],
			'Customer Id'
		)
		->addColumn(
			'token',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Token'
		)
		->addColumn(
			'device',
			TABLE::TYPE_TEXT,
			100,
			['nullable' => true],
			'Customer Device'
		)
		->addColumn(
			'app_id',
			TABLE::TYPE_INTEGER,
			10,
			['nullable' => true],
			'App Id'
		)
		->addIndex(
			$setup->getIdxName(
				'safetyhubapp_users_tokens',
				['customer_id'],
				AdapterInterface::INDEX_TYPE_UNIQUE
			),
			['customer_id'],
			AdapterInterface::INDEX_TYPE_UNIQUE
		)
		->addForeignKey(// Add foreign key for table entity
			$setup->getFkName(
				'safetyhubapp_users_tokens', // New table
				'customer_id', // Column in New Table
				'customer_entity', // Reference Table
				'entity_id' // Column in Reference table
			),
			'customer_id', // New table column
			$setup->getTable('customer_entity'), // Reference Table
			'entity_id', // Reference Table Column
			// When the parent is deleted, delete the row with foreign key
			Table::ACTION_CASCADE
		)
		->setComment('SafetyHubApp Users Token');

	$setup->getConnection()->createTable($usersTokenTable);
    }

    public function createRequsitions(\Magento\Framework\Setup\SchemaSetupInterface $setup) {


	$requisitionsTable = $setup->getConnection()->newTable(
			$setup->getTable('safetyhubapp_requisitions')
		)->addColumn(
			'entity_id',
			TABLE::TYPE_INTEGER,
			null,
			['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
			'Requisition Id'
		)->addColumn(
			'safetyitem_id',
			TABLE::TYPE_INTEGER,
			null,
			['unsigned' => true, 'nullable' => false, 'default' => 0],
			'Safety Item Id'
		)->addColumn(
			'customer_id',
			TABLE::TYPE_INTEGER,
			10,
			['unsigned' => true, 'nullable' => false, 'default' => 0],
			'Customer Id'
		)
		->addColumn(
			'company_id',
			TABLE::TYPE_INTEGER,
			10,
			['nullable' => true, 'unsigned' => false, 'default' => 0],
			'Company Id'
		)
//		->addColumn(
//			'model_number',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'Model Number of Safety Item'
//		)->addColumn(
//			'serial_number',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'Serial Number of Safety Item'
//		)->addColumn(
//			'nickname',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'Nickname of Safety Item'
//		)->addColumn(
//			'type',
//			TABLE::TYPE_SMALLINT,
//			null,
//			['nullable' => false],
//			'Safety Item Type'
//		)->addColumn(
//			'firstname',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'User first Name'
//		)->addColumn(
//			'lastname',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'User Last Name'
//		)->addColumn(
//			'email',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'User Email'
//		)
		->addColumn(
			'requisition_email_address',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'User Email'
		)
		->addColumn(
			'other_email_addresses',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Reorder Request Email'
		)
//		->addColumn(
//			'street1',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'Street 1'
//		)->addColumn(
//			'street2',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'Street 2'
//		)->addColumn(
//			'city',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'City'
//		)->addColumn(
//			'region',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'Region'
//		)->addColumn(
//			'country_id',
//			TABLE::TYPE_TEXT,
//			10,
//			['nullable' => true],
//			'Coutnry Id'
//		)->addColumn(
//			'postcode',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'Post Code'
//		)->addColumn(
//			'telephone',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'Telephone'
//		)
//		->addColumn(
//			'fax',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'Fax'
//		)
//		->addColumn(
//			'job_title',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'Job Title'
//		)->addColumn(
//			'company',
//			TABLE::TYPE_TEXT,
//			255,
//			['nullable' => true],
//			'Company'
//		)
		->addColumn(
			'purchase_order',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Purchase Order'
		)
		->addColumn(
			'comment',
			TABLE::TYPE_TEXT,
			'2M',
			['nullable' => true],
			'Requisition Comment'
		)
		->addColumn(
			'status',
			TABLE::TYPE_SMALLINT,
			2,
			['nullable' => false, 'default' => false],
			'Requisition Status 1-Done,2-Pending,3-Rejected,4=Draft'
		)
		->addColumn(
			'is_restock_complete',
			TABLE::TYPE_SMALLINT,
			2,
			['nullable' => false, 'default' => false],
			'Check Items remaning to restock or not'
		)
		->addColumn(
			'requisition_method',
			TABLE::TYPE_SMALLINT,
			2,
			['nullable' => false, 'default' => false],
			'Requisition Method 1=Norma1,2= With Report'
		)
		->addColumn(
			'requisition_report_type',
			TABLE::TYPE_SMALLINT,
			2,
			['nullable' => false, 'default' => false],
			'Requisition Report Type 1=Full Report,2 = Part Numbers'
		)
		->addColumn(
			'status_updated_by',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Requisition Status Updated By'
		)
		->addColumn(
			'status_fulfilled_by',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Requisition Status Fulfilled By'
		)
		->addColumn(
			'status_updated_at',
			TABLE::TYPE_DATE,
			null,
			['nullable' => true],
			'Status Updated At'
		)
		->addColumn(
			'created_at',
			TABLE::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => TABLE::TIMESTAMP_INIT],
			'Time Created'
		)->addColumn(
			'updated_at',
			TABLE::TYPE_TIMESTAMP,
			null,
			['nullable' => false, 'default' => TABLE::TIMESTAMP_INIT_UPDATE],
			'Time for Updated'
		)
		->addIndex(
			$setup->getIdxName(
				'safetyhubapp_requisitions',
				['customer_id'],
				AdapterInterface::INDEX_TYPE_UNIQUE
			),
			['customer_id'],
			AdapterInterface::INDEX_TYPE_UNIQUE
		)
		->addForeignKey(// Add foreign key for table entity
			$setup->getFkName(
				'safetyhubapp_requisitions', // New table
				'customer_id', // Column in New Table
				'customer_entity', // Reference Table
				'entity_id' // Column in Reference table
			),
			'customer_id', // New table column
			$setup->getTable('customer_entity'), // Reference Table
			'entity_id', // Reference Table Column
			// When the parent is deleted, delete the row with foreign key
			Table::ACTION_CASCADE
		)
		->setComment('Users Placed Requisitions');

	$setup->getConnection()->createTable($requisitionsTable);
    }

    public function createRequsitionsItems(\Magento\Framework\Setup\SchemaSetupInterface $setup) {


	$requisitionsTable = $setup->getConnection()->newTable(
			$setup->getTable('safetyhubapp_requisitions_items')
		)->addColumn(
			'entity_id',
			TABLE::TYPE_INTEGER,
			null,
			['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
			'Requisition Item Id'
		)
		->addColumn(
			'requisition_id',
			TABLE::TYPE_INTEGER,
			10,
			['unsigned' => true, 'nullable' => false],
			'Requisition Item Id'
		)
		->addColumn(
			'safetyitem_id',
			TABLE::TYPE_INTEGER,
			10,
			['unsigned' => true, 'nullable' => false, 'default' => 0],
			'Requisition Safety Item Id'
		)->addColumn(
			'item_id',
			TABLE::TYPE_INTEGER,
			10,
			['unsigned' => true, 'nullable' => false, 'default' => 0],
			'Customer Id'
		)
		->addColumn(
			'sku',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Item Sku'
		)
		->addColumn(
			'company_sku',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Company Item Sku'
		)->addColumn(
			'name',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Item Name'
		)->addColumn(
			'company_name',
			TABLE::TYPE_TEXT,
			255,
			['nullable' => true],
			'Company Item Name'
		)
		->addColumn(
			'qty',
			TABLE::TYPE_INTEGER,
			10,
			['unsigned' => false, 'nullable' => false, 'default' => 0],
			'Requisition Quantity'
		)
		->addColumn(
			'restock_qty',
			TABLE::TYPE_INTEGER,
			10,
			['unsigned' => false, 'nullable' => false, 'default' => 0],
			'Restock Quantity'
		)
		->addColumn(
			'price',
			TABLE::TYPE_DECIMAL,
			'10,2',
			['nullable' => false, 'default' => '0.00'],
			'Item Price'
		)
		->addIndex(
			$setup->getIdxName(
				'safetyhubapp_requisitions_items',
				['requisition_id','safetyitem_id'],
				AdapterInterface::INDEX_TYPE_UNIQUE
			),
			['requisition_id','safetyitem_id'],
			AdapterInterface::INDEX_TYPE_UNIQUE
		)
		->addForeignKey(// Add foreign key for table entity
			$setup->getFkName(
				'safetyhubapp_requisitions_items', // New table
				'requisition_id', // Column in New Table
				'safetyhubapp_requisitions', // Reference Table
				'entity_id' // Column in Reference table
			),
			'requisition_id', // New table column
			$setup->getTable('safetyhubapp_requisitions'), // Reference Table
			'entity_id', // Reference Table Column
			// When the parent is deleted, delete the row with foreign key
			Table::ACTION_CASCADE
		)
		->addForeignKey(// Add foreign key for table entity
			$setup->getFkName(
				'safetyhubapp_requisitions_items', // New table
				'safetyitem_id', // Column in New Table
				'safetyhubapp_users_items', // Reference Table
				'entity_id' // Column in Reference table
			),
			'safetyitem_id', // New table column
			$setup->getTable('safetyhubapp_users_items'), // Reference Table
			'entity_id', // Reference Table Column
			// When the parent is deleted, delete the row with foreign key
			Table::ACTION_CASCADE
		)
		->setComment('Requisitions Items');

	$setup->getConnection()->createTable($requisitionsTable);
    }

}
