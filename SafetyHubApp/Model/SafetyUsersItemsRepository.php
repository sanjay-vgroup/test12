<?php

namespace Vgroup\SafetyHubApp\Model;

use Vgroup\SafetyHubApp\Api\SafetyUsersItemsRepositoryInterface;
use Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface;
use Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory;
use Vgroup\SafetyHubApp\Model\ResourceModel\SafetyUsersItems;
use Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsSearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Vgroup\SafetyHubApp\Model\ReportsFactory;
use Vgroup\SafetyHubApp\Model\SafetyItemsFactory;
use Vgroup\SafetyHubApp\Helper\Data;

class SafetyUsersItemsRepository implements SafetyUsersItemsRepositoryInterface
{

    /**
     * @var SafetyUsersItemsFactory
     */
    private $safetyUsersItemsFactory;

    /**
     * @var SafetyUsersItems
     */
    private $safetyUsersItems;

    /**
     * @var SafetyUsersItemsSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessor
     */
    private $collectionProcessor;

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
    protected $report;

    /**
     * @var Vgroup\SafetyHubApp\Model\Data\ResponseFactory
     */
    protected $response;
    /**
     * @var SafetyItemsFactory
     */
    private $safetyItemsFactory;
    /**
     * @var Data
     */
    private $helper;
    /**
     * @param SafetyUsersItemsFactory $safetyUsersItemsFactory
     * @param SafetyUsersItems $safetyUsersItems
     * @param SafetyUsersItemsSearchResultsInterfaceFactory $searchResultsFactory
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param CollectionProcessorInterface $collectionProcessor
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface
     * @param \Vgroup\SafetyHubApp\Model\ReportsFactory $report
     * @param \Vgroup\SafetyHubApp\Model\Data\ResponseFactory $response
     * @param SafetyItemsFactory $safetyItemsFactory
     */
    public function __construct(\Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter, SafetyUsersItemsFactory $safetyUsersItemsFactory, SafetyUsersItems $safetyUsersItems, SafetyUsersItemsSearchResultsInterfaceFactory $searchResultsFactory, CollectionProcessor $collectionProcessor, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface, ReportsFactory $report, \Vgroup\SafetyHubApp\Model\Data\ResponseFactory $response, SafetyItemsFactory $safetyItemsFactory, Data $helper)
    {
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->safetyUsersItemsFactory = $safetyUsersItemsFactory;
        $this->safetyUsersItems = $safetyUsersItems;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->_timezoneInterface = $timezoneInterface;
        $this->report = $report;
        $this->response = $response;
        $this->safetyItemsFactory = $safetyItemsFactory;
        $this->helper = $helper;
    }

    /**
     * Retrieve User SafetyItems List which match a specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param int $customerId
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria, $customerId)
    {
        $userSafetyItem = $this->safetyUsersItemsFactory->create();
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        /** @var \Vgroup\SafetyHubApp\Model\ResourceModel\SafetyUsersItems\Collection $collection */
        $collection = $this->safetyUsersItemsFactory->create()->getCollection()->addFieldToSelect(['type', 'model_number', 'serial_number', 'nickname', 'customer_id', 'firstname', 'lastname', 'email', 'street1', 'street2', 'city', 'region_id', 'company', 'number_of_employees', 'postcode', 'telephone', 'refill_reminder_status', 'refill_reminder_days', 'show_physical_inventory_date', 'physical_inventory_status', 'physical_inventory_days', 'physical_inventory_date', 'expiry_reminder_status', 'expiry_reminder_days', 'expiration_date', 'service_due_date', 'battery_expiration_date', 'pad_expiration_date', 'is_restock', 'restock_type', 'restock_at', 'restock_by', 'last_reminder_sent', 'last_battery_reminder_sent', 'last_pad_reminder_sent', 'last_physical_reminder_sent', 'created_at', 'updated_at']);
        $collection->addFilterToMap('type', 'main_table.type');
        $collection->addFilterToMap('model_number', 'main_table.model_number');
        $collection->addFilterToMap('serial_number', 'main_table.serial_number');
        $collection->addFilterToMap('street1', 'main_table.street1');
        $collection->addFilterToMap('street2', 'main_table.street2');
        $collection->addFilterToMap('city', 'main_table.city');
        $collection->addFilterToMap('region', 'directory_country_region.default_name');
        $collection->addFilterToMap('nickname', 'main_table.nickname');
        $this->collectionProcessor->process($searchCriteria, $collection);
        $collection->getSelect()
            ->joinLeft(array("safetyhubapp_items" => 'safetyhubapp_items'), "safetyhubapp_items.model_number = main_table.model_number", array('safety_item_name' => 'title', 'safety_item_image' => 'image', 'safety_item_file' => 'file'))
            ->joinLeft(array("directory_country_region" => 'directory_country_region'), "(main_table.region_id = directory_country_region.region_id OR main_table.region_id = directory_country_region.code) AND directory_country_region.country_id = 'US'", array('region' => 'default_name'))
            ->joinLeft(array("cu" => 'safetyhubapp_assigned_users_items'), "cu.entity_id = main_table.entity_id", array('assigned_customer_id' => 'customer_id'))->where("(cu.customer_id = " . $customerId . " OR main_table.customer_id = " . $customerId . ")");
        $collection->getSelect()->group('main_table.entity_id');
        $collection->getSelect()->order('main_table.entity_id DESC');
        $searchResults->setTotalCount($collection->getSize());
        $usersSafetyItems = [];
        /** @var \Vgroup\SafetyHubApp\Model\SafetyUsersItems $usersSafetyItemsModel */
        $typesAry = array(1, 4, 5);
        foreach ($collection as $usersSafetyItemsModel) {
            $notficationData = $this->notificatinMsg($usersSafetyItemsModel->getData());
            $safetyItemData = array_merge($usersSafetyItemsModel->getData(), $notficationData);
            if (in_array($usersSafetyItemsModel->getType(), $typesAry)) {
        //         $query = "SELECT `safetyhubapp_items_products`.`product_id` AS `product_id`, IFNULL(`safetyhubapp_physicalinventory`.`status`,1) AS `status` FROM `safetyhubapp_users_items` AS `main_table` LEFT JOIN `safetyhubapp_items` AS `protypes` ON protypes.model_number=main_table.model_number 
		// LEFT JOIN `safetyhubapp_items_products` ON protypes.entity_id=safetyhubapp_items_products.row_id 
		// LEFT JOIN `safetyhubapp_physicalinventory` ON safetyhubapp_physicalinventory.row_id = main_table.entity_id AND safetyhubapp_physicalinventory.product_id = safetyhubapp_items_products.product_id 
		// WHERE (`main_table`.`entity_id` = '" . $usersSafetyItemsModel->getEntityId() . "') GROUP BY `safetyhubapp_items_products`.`product_id` ORDER BY `main_table`.`entity_id` DESC";
        //         echo $query;exit;
                $physicalInventoryData =  $userSafetyItem->getPhysicalInventoryData(['id' => $usersSafetyItemsModel->getEntityId()]);
                $safetyItemData['phyical_inventory_data'] = $physicalInventoryData;
            }
            $usersSafetyItems[] = $safetyItemData;
        }
        $searchResults->setItems($usersSafetyItems);
        return $searchResults;
        
    }

    /**
     * Get User SafetyItem by SafetyItem ID.
     * @param int $id 
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If SafetyItem with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id)
    {
        $safetyUserItem = $this->safetyUsersItemsFactory->create()->load($id);
        $safetyItemData = $safetyUserItem->getData();
        $street1 = $safetyItemData['street1'] ?? "";
        $street2 = $safetyItemData['street2'] ?? "";
        if (!$safetyUserItem->getId()) {
            throw new NoSuchEntityException(__('Unable to find Safety Item with ID "%1"', $id));
        }

        $safetyUserItem->setStreet1($street1);
        $safetyUserItem->setStreet2($street2);
        return $safetyUserItem;
    }

    /**
     * Save User Safety Item
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface $safetyUserItem 
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface
     * @throws CouldNotSaveException
     */
    public function save(SafetyUsersItemsInterface $safetyUserItem)
    {

        try {
            $safetyItem = $this->safetyItemsFactory->create()->load($safetyUserItem->getModelNumber(), 'model_number');
            if ($safetyItem->getId() == null || $safetyItem->getType() != $safetyUserItem->getType()) {
                throw new \Magento\Framework\Webapi\Exception(
                    __('Safety Item Model Number does not exist.'),
                    101
                );
            }
            $safetyItemData = $this->extensibleDataObjectConverter->toNestedArray(
                $safetyUserItem,
                [],
                '\Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface'
            );
            $safetyItemModel = $this->safetyUsersItemsFactory->create(['data' => $safetyItemData]);
            $safetyItemModel->setId($safetyUserItem->getId());
            if (!$safetyUserItem->getId()) {
                $safetyItemModel->setPhysicalInventoryDate($this->helper->getDate("Y-m-d"));
                $safetyItemModel->setShowPhysicalInventoryDate(1);
            }
            $safetyItemModel->save();

            $safetyItemData = $safetyItemModel->getData();
            $street1 = $safetyItemData['street1'] ?? "";
            $street2 = $safetyItemData['street2'] ?? "";
            $safetyItemModel->setStreet1($street1);
            $safetyItemModel->setStreet2($street2);
        } catch (\Exception $exception) {

            throw new CouldNotSaveException(
                __('Could not save the safety item: %1', $exception->getMessage()),
                $exception
            );
        }
        return $safetyItemModel;
    }

    /**
     * Delete Users Safety Item Id.
     *
     * @param int $id
     * @return bool true on success
     */
    public function deleteById($id)
    {

        try {
            $safetyUserItem = $this->safetyUsersItemsFactory->create();
            $safetyUserItem->load($id)->delete();
            return true;
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Could not delete the safety item: %1', $exception->getMessage()), $exception);
        }
    }

    /**
     * Save Inventory and Save Inventory/Place Requisition .
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface $safetyUserItem
     * @param int $id
     * @param int $customerId
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided email is already used
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function saveInventory(SafetyUsersItemsInterface $safetyUserItem, $id, $customerId)
    {


        try {
            $safetyUserItemData = $this->extensibleDataObjectConverter->toNestedArray(
                $safetyUserItem,
                [],
                '\Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface'
            );
            $safetyItemData['physical_inventory_date'] = $this->_timezoneInterface->date()->format('Y-m-d');
            $safetyItemData['show_physical_inventory_date'] = 1;
            $safetyItemModel = $this->safetyUsersItemsFactory->create(['data' => $safetyItemData]);
            $safetyItemModel->setId($id);
            if (isset($safetyUserItemData['associated_products']))
                $safetyItemModel->setAssociatedProducts($safetyUserItemData['associated_products']);

            $safetyItemModel->setUserId($customerId);
            $safetyItemModel->save();
        } catch (\Exception $exception) {

            throw new CouldNotSaveException(
                __('Could not update physical inventory: %1', $exception->getMessage()),
                $exception
            );
        }
        return $safetyItemModel;
    }

    /**
     * Save User Safety Item
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface $safetyUserItem 
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface
     * @throws CouldNotSaveException
     */
    public function reserveSafetyUser(SafetyUsersItemsInterface $safetyUserItem)
    {
        try {
            $safetyItemData = $this->extensibleDataObjectConverter->toNestedArray(
                $safetyUserItem,
                [],
                '\Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface'
            );
            $safetyItemModel = $this->safetyUsersItemsFactory->create(['data' => $safetyItemData]);
            $safetyItemModel->setId($safetyUserItem->getId());
            $safetyItemModel->save();
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the safety item: %1', $exception->getMessage()),
                $exception
            );
        }
        return $safetyItemModel;
    }

    /**
     * Save Inventory and Save Inventory/Place Requisition .
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface $safetyUserItem
     * @return \Vgroup\SafetyHubApp\Api\Data\ResponseInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided email is already used
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function checkOk(SafetyUsersItemsInterface $safetyUserItem)
    {


        try {

            $safetyUserItemData = $this->extensibleDataObjectConverter->toNestedArray(
                $safetyUserItem,
                [],
                '\Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface'
            );

            $safetyItemModel = $this->safetyUsersItemsFactory->create();
            $checkOkData['row_id'] = $safetyUserItemData['id'];
            $checkOkData['customer_id'] = $safetyUserItemData['customer_id'];
            $checkOkData['safetyitem_ok_date'] = $this->_timezoneInterface->date()->format('Y-m-d');
            $result = $safetyItemModel->addCheckOk($checkOkData);
            $safetyItemModel->setId($safetyUserItemData['id']);
            $safetyItemModel->setPhysicalInventoryDate($checkOkData['safetyitem_ok_date']);
            $safetyItemModel->setShowPhysicalInventoryDate(1);
            $safetyItemModel->save();
            $response = $this->response->create();

            if (count($result) > 0) {
                $responsedata = [
                    'status' => (string) "success",
                    'message' => (string) "Inventory checked successfully.",
                    'check_ok_date' => date('m/d/Y', strtotime($result['date']))
                ];
            } else {

                $responsedata = [
                    'status' => (string) "failed",
                    'message' => (string) "Inventory checked failed.",
                    'check_ok_date' => 'null'
                ];
            }

            $response->setStatus($responsedata['status']);
            $response->setMessage($responsedata['message']);
            $response->setCheckOkDate($responsedata['check_ok_date']);

            return $response;
        } catch (\Exception $exception) {

            throw new CouldNotSaveException(
                __('Could not update Safety Item Check Ok Date : %1', $exception->getMessage()),
                $exception
            );
        }
    }

    public function notificatinMsg($data = array())
    {
        $notficationData = array('expired' => 0, 'unitExpired' => 0, 'serviceExpired' => 0, 'expiredMessage' => '');
        $currentDate = strtotime($this->_timezoneInterface->date()->format('Y-m-d'));
        $expirydate = strtotime($data['expiration_date']);
        $serviceDueDate = strtotime($data['service_due_date']);
        $battertExp = strtotime($data['battery_expiration_date']);
        $padExp = strtotime($data['pad_expiration_date']);
        $msgStr = '';
        //	$notficationData['current_date'] = $this->_timezoneInterface->date()->format('Y-m-d');
        //	$notficationData['expiry_date'] = $data['expiration_date'];
        //	$notficationData['service_date'] = $data['service_due_date'];
        //	$notficationData['batery_date'] = $data['battery_expiration_date'];
        //	$notficationData['pad_date'] = $data['pad_expiration_date'];
        //	$notficationData['current_date_t'] = $currentDate;
        //	$notficationData['expiry_date_t'] = $expirydate;
        //	$notficationData['service_date_t'] = $serviceDueDate;
        //	$notficationData['batery_date_t'] = $battertExp;
        //	$notficationData['pad_date_t'] = $padExp;

        if ($data['type'] == 1 && !empty($data['expiration_date']) && $currentDate > $expirydate) {
            $notficationData['expired'] = 1;
            $notficationData['expiredMessage'] = 'Cabinet expired on ' . date('m/d/Y', $expirydate);
        }
        if ($data['type'] == 2 && !empty($data['expiration_date']) && $currentDate > $expirydate) {
            $notficationData['unitExpired'] = 1;
            $notficationData['expiredMessage'] = 'Fire Extinguisher expired on ' . date('m/d/Y', $expirydate);
        }
        if ($data['type'] == 2 && !empty($data['service_due_date']) && $currentDate > $serviceDueDate) {
            $notficationData['serviceExpired'] = 1;
            if (!empty($notficationData['expiredMessage']))
                $notficationData['expiredMessage'] .= ' - ';
            $notficationData['expiredMessage'] .= 'Fire Extinguisher service due on ' . date('m/d/Y', $serviceDueDate);
        }
        if ($data['type'] == 3 && !empty($data['battery_expiration_date']) && $currentDate > $battertExp) {
            $notficationData['unitExpired'] = 1;
            $notficationData['expiredMessage'] = 'AED battery expired on ' . date('m/d/Y', $battertExp);
        }
        if ($data['type'] == 3 && !empty($data['pad_expiration_date']) && $currentDate > $padExp) {
            $notficationData['unitExpired'] = 1;
            if (!empty($notficationData['expiredMessage']))
                $notficationData['expiredMessage'] .= ' - ';
            $notficationData['expiredMessage'] .= 'AED pad expired on ' . date('m/d/Y', $padExp);
        }
        if ($data['type'] == 3 && !empty($data['service_due_date']) && $currentDate > $serviceDueDate) {
            $notficationData['serviceExpired'] = 1;
            if (!empty($notficationData['expiredMessage']))
                $notficationData['expiredMessage'] .= ' - ';
            $notficationData['expiredMessage'] .= 'AED service due on ' . date('m/d/Y', $serviceDueDate);
        }

        return $notficationData;
    }
}
