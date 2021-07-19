<?php

namespace Vgroup\SafetyHubApp\Model;

use Vgroup\SafetyHubApp\Api\OfflineSyncRepositoryInterface;
use Vgroup\SafetyHubApp\Api\Data\OfflineSyncInterface;
use Vgroup\SafetyHubApp\Api\Data\ResponseInterfaceFactory;
use Vgroup\SafetyHubApp\Api\Data\MessageInterfaceFactory;
use Vgroup\SafetyHubApp\Helper\Email;
use Vgroup\SafetyHubApp\Helper\Data;
use Magento\Framework\App\ResourceConnection;
use Vgroup\SafetyHubApp\Api\Data\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Customer\Model\AddressFactory;

class OfflineSyncRepository implements OfflineSyncRepositoryInterface
{

	/**
	 * SafetyItems Table
	 */
	const SAFETYITEMS_TABLE = 'safetyhubapp_items';
	/**
	 * User SafetyItem Table
	 */
	const USER_SAFETYITEMS_TABLE = 'safetyhubapp_users_items';
	/**
	 * Requisition Table
	 */
	const REQUISITION_TABLE = 'safetyhubapp_requisitions';
	/**
	 * Requisition Table
	 */
	const REQUISITION_ITEMS_TABLE = 'safetyhubapp_requisitions_items';
	/**
	 * Report Table
	 */
	const REPORTS_TABLE = 'safetyhubapp_reports';
	/**
	 * @var ExtensibleDataObjectConverter
	 */
	protected $extensibleDataObjectConverter;
	/**
	 * @var Magento\Framework\Stdlib\DateTime\TimezoneInterface
	 */
	protected $_timezoneInterface;
	/**
	 * @var Vgroup\SafetyHubApp\Model\ReportsFactory
	 */
	protected $reportFactory;
	/**
	 * @var Vgroup\SafetyHubApp\Helper\Email
	 */
	protected $mailHelper;
	/**
	 * @var Vgroup\SafetyHubApp\Helper\Data
	 */
	protected $helper;
	/**
	 * @var Vgroup\SafetyHubApp\Model\Data\ResponseFactory
	 */
	protected $response;
	/**
	 * @var \Magento\Framework\DB\Adapter\AdapterInterface
	 */
	protected $connection;

	/**
	 * @var Resource
	 */
	protected $resource;
	/**
	 * @var Resource
	 */
	protected $responseMessages = [];
	/**
	 * @var Resource
	 */
	protected $safetyItemsValidation = [];
	/**
	 * @var Vgroup\SafetyHubApp\Model\Data\MessageInterfaceFactory
	 */
	protected $syncMessages;
	/**
	 * @var SearchResultsInterface
	 */
	private $searchResultsFactory;
	/**
	 * @var int
	 */
	private $requestId = 0;
	/**
	 * @var CustomerFactory
	 */
	protected $customerFactory;
	/**
	 * AddressFactory
	 */
	protected $addressFactory;
	/**
	 *  Constructor.
	 * 
	 * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
	 * @param TimezoneInterface $timezoneInterface
	 * @param Email $mailHelper
	 * @param Data $helper
	 * @param ResponseInterfaceFactory $response
	 * @param ResourceConnection $resource
	 * @param SearchResultsInterface $searchResultsFactory
	 * @param CustomerFactory $customerFactory
	 * @param AddressFactory $addressFactory
	 */
	public function __construct(
		ExtensibleDataObjectConverter $extensibleDataObjectConverter,
		TimezoneInterface $timezoneInterface,
		Email $mailHelper,
		Data $helper,
		ResponseInterfaceFactory $response,
		ResourceConnection $resource,
		MessageInterfaceFactory $syncMessages,
		SearchResultsInterfaceFactory $searchResultsFactory,
		CustomerFactory $customerFactory,
		AddressFactory $addressFactory
	) {
		$this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
		$this->_timezoneInterface = $timezoneInterface;
		$this->mailHelper = $mailHelper;
		$this->helper = $helper;
		$this->response = $response;
		$this->connection = $resource->getConnection();
		$this->resource = $resource;
		$this->safetyItemsValidation = $this->safetyItemsModelTypesValidationa();
		$this->syncMessages = $syncMessages;
		$this->searchResultsFactory = $searchResultsFactory;
		$this->customerFactory = $customerFactory;
		$this->addressFactory = $addressFactory;
	}

	/**
	 * Create or update a Safety Item.
	 *
	 * @param \Vgroup\SafetyHubApp\Api\Data\OfflineSyncInterface $offlineSync
	 * @return \Vgroup\SafetyHubApp\Api\Data\ResponseInterface
	 * @throws \Magento\Framework\Exception\InputException If bad input is provided
	 * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided email is already used
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function sync(OfflineSyncInterface $offlineSync)
	{

		try {
			// i will use insert multihere for bulkd update;
			$offlineSyncData = $this->extensibleDataObjectConverter->toNestedArray(
				$offlineSync,
				[],
				'\Vgroup\SafetyHubApp\Api\Data\OfflineSyncInterface'
			);
			if ($offlineSyncData) {
				foreach ($offlineSyncData as $action => $data) {
					if (isset($offlineSyncData[$action]) && count($offlineSyncData[$action]) > 0 && $action != 'update_profile') {
						$this->insertMultiple($action, $data);
					}
					if ($action == 'update_profile') {
						$actionArrary['request_id'] =  ($this->requestId + 1);
						$actionArrary['type'] = "update_profile";
						if (!isset($data['id'])) {
							$actionArrary['status'] = 0;
							$actionArrary['msg'] = __("Please provide Customer Id to update the customer");
							$this->responseMessages[]  = $actionArrary;
							continue;
						} else if (isset($data['id'])) {
							$customerModel =  $this->customerFactory->create()->load($data['id']);
							if (isset($data['addresses'][0]) && !empty($data['addresses'][0])) {
								$addressData = $data['addresses'][0];
								$addressModel = $this->addressFactory->create();
								if ($customerModel->getDefaultBilling() != null) {
									$billingAddressModel = $addressModel->load($customerModel->getDefaultBilling());
									$billingAddressModel->setCustomerId($data['id'])
										->setCountryId($addressData['country_id'])
										->setPostcode($addressData['postcode'])
										->setCity($addressData['city'])
										->setTelephone($addressData['telephone'])
										->setCompany($addressData['company'])
										->setStreet($addressData['street'])
										->setIsDefaultBilling('1');
									$billingAddressModel->save();
								}
								if ($customerModel->getDefaultShipping() != null) {
									$shippingAddressModel = $addressModel->load($customerModel->getDefaultShipping());
									$shippingAddressModel->setCustomerId($data['id'])
										->setCountryId($addressData['country_id'])
										->setPostcode($addressData['postcode'])
										->setCity($addressData['city'])
										->setTelephone($addressData['telephone'])
										->setCompany($addressData['company'])
										->setStreet($addressData['street'])
										->setIsDefaultShipping('1');
									$shippingAddressModel->save();
								}
							}
							$customerModel->setIsAppUser(1)
								->setFirstname($data['firstname'])
								->setLastname($data['lastname']);
							if (!empty($data['custom_attributes'])) {
								foreach ($data['custom_attributes'] as $customAttr) {
									if ($customAttr["attribute_code"] == "job_title") {
										$customerModel->setJobTitle($customAttr["value"]);
									}
									if ($customAttr["attribute_code"] == "number_of_employees") {
										$customerModel->setNumberOfEmployees($customAttr["value"]);
									}
								}
							}
							$result = $customerModel->save();
							if ($result->getId()) {
								$actionArrary['status'] = 1;
								$actionArrary['msg'] = __("Customer Updatde successfully");
								$this->responseMessages[]  = $actionArrary;
							} else {
								$actionArrary['status'] = 1;
								$actionArrary['msg'] = __("Customer Update failed");
								$this->responseMessages[]  = $actionArrary;
							}
						}
					}
				}
			}
			$response = $this->response->create();
			$response->setStatus("success");
			$response->setResponse($this->responseMessages);
			$response->setSyncDate($this->helper->getDate("d-m-Y H:i:s"));
			$response->setMessage(__("offline sync is successfully done."));
			return $response;
		} catch (LocalizedException $exception) {
			throw new LocalizedException(__($exception->getMessage()));
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function sendMail(ResponseInterface $response)
	{
		$response->setStatus(__("success"));
		$response->setMessage(__("sync report mail is sent successfully."));
		return $response;
	}
	/**
	 * @param string $action
	 * @param array $data
	 * @return \Magento\Framework\Api\SearchResultsInterface $searchResultsFactory
	 */
	public function insertMultiple($action, array $data)
	{

		$safetyItemType = '';
		$safetyItemsModelTypesValidations = $this->safetyItemsValidation;
		$row = reset($data);
		// support insert syntaxes
		if (!is_array($row)) {
			$this->responseMessages[]  = [
				'request_id' => $this->requestId,
				'status' => 0,
				'type' => "failed",
				"msg" => __('Invalid data for insert')
			];
			//return $this->connection->insert($table, $data);
		}
		// validate data array
		unset($row['associated_products']);
		unset($row['products_count']);
		$cols = array_keys($row);
		if (isset($cols[0]) && $cols[0] == "id") {
			$cols[0] = "entity_id";
		}
		$insertArray = [];
		$actionArrary = [];
		foreach ($data as $actionKey => $row) {
			$table = "";
			$line = [];
			$deleteIds = [];
			$this->requestId++;
			$actionArrary = ['request_id' => $this->requestId];
			if (array_diff($cols, array_keys($row))) {
				$this->responseMessages[]  = [
					'request_id' => $this->requestId,
					'status' => 0,
					'type' => "failed",
					"msg" => __('cols data for insert')
				];
			}
			if (isset($row['type']))
				$safetyItemType = $this->helper->getSafetyItemTypes($row['type']);
			if (isset($row['model_number']))
				$safetyItemModelNumber = $row['model_number'];
			unset($row['associated_products']);
			unset($row['products_count']);
			switch ($action) {
				case 'save':
					$table = self::USER_SAFETYITEMS_TABLE;
					$actionArrary['type'] = "saved";
					if ($row['type'] != $safetyItemsModelTypesValidations[$safetyItemModelNumber]) {
						$actionArrary['status'] = 0;
						$actionArrary['msg'] = __("Invalid Type %1 for model #%2", $safetyItemType, $safetyItemModelNumber);
						$this->responseMessages[]  = $actionArrary;
						continue;
					} else {
						$actionArrary['status'] = 1;
						$actionArrary['msg'] = __("%1 with model #%2 is saved", $safetyItemType, $safetyItemModelNumber);
						$this->responseMessages[]  = $actionArrary;
					}
					break;
				case 'update':
					$table = self::USER_SAFETYITEMS_TABLE;
					if (isset($row['id']))
						$isUserSafetyItemExist = $this->isUserSafetyItemExist($row);

					$actionArrary['type'] = "updated";
					if (!isset($row['id'])) {
						$actionArrary['status'] = 0;
						$actionArrary['msg'] = __("Please provide Safety Item id to update the safety item with model #%1", $safetyItemModelNumber);
						$this->responseMessages[]  = $actionArrary;
						continue;
					} else if (!$isUserSafetyItemExist) {
						$actionArrary['status'] = 0;
						$actionArrary['msg'] = __("User does not have the safety item with id #%1", $row['id']);
						$this->responseMessages[]  = $actionArrary;
						continue;
					} else if (($row['type'] != $safetyItemsModelTypesValidations[$safetyItemModelNumber])) {
						$actionArrary['status'] = 0;
						$actionArrary['msg'] = __("Invalid Type %1 for model #%2", $safetyItemType, $safetyItemModelNumber);
						$this->responseMessages[]  = $actionArrary;
						continue;
					} else {
						if (isset($row['id'])) {
							$row['entity_id'] = $row['id'];
							unset($row['id']);
						}
						$totalUpdatedCount =  $this->connection->insertOnDuplicate($table, $row);
						$actionArrary['status'] = 1;
						$actionArrary['msg'] = __("%1 with model #%2 is updated", $safetyItemType, $safetyItemModelNumber);
						$this->responseMessages[]  = $actionArrary;
					}
					break;
				case 'delete':
					$table = self::USER_SAFETYITEMS_TABLE;
					$actionArrary['type'] = "deleted";
					if (!isset($row['id'])) {
						$actionArrary['status'] = 0;
						$actionArrary['msg'] = __("Please provide Safety Item id to delete the safety item");
						$this->responseMessages[]  = $actionArrary;
						continue;
					} else {
						$deleteIds[] = $row['id'];
						$actionArrary['status'] = 1;
						$actionArrary['msg'] = __("%1 with model #%2 is deleted", $safetyItemType, $safetyItemModelNumber);
						$this->responseMessages[]  = $actionArrary;
					}
					break;
				case 'save_inventory':
					$table = self::USER_SAFETYITEMS_TABLE;
					if (!isset($row['id'])) {
						$actionArrary['status'] = 0;
						$actionArrary['msg'] = __("Please provide safety item id to save inventory for the safety item");
						$this->responseMessages[]  = $actionArrary;
						continue;
					} else {
						$actionArrary['status'] = 1;
						$actionArrary['msg'] = __("Inventory Update for %1  with model #%2", $safetyItemType, $safetyItemModelNumber);
						$this->responseMessages[]  = $actionArrary;
					}
					break;
				case 'place':
					$table = self::REQUISITION_TABLE;
					$actionArrary['status'] = 1;
					$actionArrary['msg'] = __("Requisition placed successfully.");
					$this->responseMessages[]  = $actionArrary;
					break;
				case 'restock':
					$table = self::USER_SAFETYITEMS_TABLE;
					break;
				default:
					break;
			}
			if (isset($cols['id'])) {
				$cols['entity_id'] = $cols['id'];
				unset($cols['id']);
			}
			foreach ($cols as $field) {
				$line[] = $row[$field];
			}
			$insertArray[] = $line;
		}
		unset($row);
		print_r($cols);
		print_r($insertArray);
		if ($action != "update") {
			return $this->connection->insertArray($table, $cols, $insertArray);
		}
		if ($action == "delete" && !empty($deleteIds)) {
			$whereConditions = [$this->connection->quoteInto('entity_id IN (?)', $deleteIds)];
			$this->connection->delete($table, $whereConditions);
		}


		$searchResult = $this->searchResultsFactory->create();
		$searchResult->setItems($this->responseMessages);
		return $searchResult;
	}

	public function safetyItemsModelTypesValidationa()
	{
		$safetyItemsQry = $this->connection->select()->from(self::SAFETYITEMS_TABLE, ['model_number', 'type']);
		$modelNumberTypesPairs =  $this->connection->fetchPairs($safetyItemsQry);
		return $modelNumberTypesPairs;
	}

	public function isUserSafetyItemExist($userSafetyItemData)
	{

		$select = $this->connection->select()->from(
			['main_table' => self::USER_SAFETYITEMS_TABLE],
			[new \Zend_Db_Expr('COUNT(main_table.entity_id)')]
		)->where(
			'main_table.entity_id = :id'
		)->where(
			'main_table.customer_id = :customer_id'
		);

		$bind = ['id' => (int)$userSafetyItemData['id'], 'customer_id' => (int)$userSafetyItemData['customer_id']];
		$counts = $this->connection->fetchOne($select, $bind);
		return (intval($counts) > 0) ? true : false;
	}
}
