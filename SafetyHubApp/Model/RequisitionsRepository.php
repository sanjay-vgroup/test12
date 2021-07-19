<?php

namespace Vgroup\SafetyHubApp\Model;

use Vgroup\SafetyHubApp\Api\RequisitionsRepositoryInterface;
use Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface;
use Vgroup\SafetyHubApp\Model\RequisitionsFactory;
use Vgroup\SafetyHubApp\Api\Data\RequisitionsSearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface as ProductCollectionProcessor;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Vgroup\SafetyHubApp\Helper\Data;
use Vgroup\SafetyHubApp\Helper\Email;
use Vgroup\SafetyHubApp\Model\ReportsFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory;
use Vgroup\SafetyHubApp\Api\Data\ResponseInterface;

class RequisitionsRepository implements RequisitionsRepositoryInterface
{

    /**
     * @var RequisitionsFactory
     */
    private $requisitionsFactory;

    /**
     * @var RequisitionsSearchResultsInterfaceFactory
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
     * @var  \Vgroup\SafetyHubApp\Model\Select\Requisitions\Status\Options $requsitionsStatus
     */
    protected $requsitionsStatus;
    /**
     * @var Vgroup\SafetyHubApp\Helper\Data
     */
    protected $helper;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;
    /**
     * @var \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchResultsInterfaceFactory
     */
    protected $productSearchResultsFactory;
    /**
     * @var ProductCollectionProcessor
     */
    private $productCollectionProcessor;
    /**
     * @var Vgroup\SafetyHubApp\Helper\Email
     */
    protected $mailHelper;

    /**
     * @var Vgroup\SafetyHubApp\Model\ReportsFactory
     */
    protected $reportFactory;
    /**
     * @var Vgroup\SafetyHubApp\Model\ReportsFactory
     */
    protected $draftRequisitionId = 0;
    /**
     * @var Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;
    /**
     * @var Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory
     */
    protected $safetyUsersItemsFactory;
    /**
     * @var Vgroup\SafetyHubApp\Model\Data\ResponseFactory
     */
    protected $response;
    /**
     * @param RequisitionsFactory $requisitionsFactory
     * @param SafetyItemsSearchResultsInterfaceFactory $searchResultsFactory
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param CollectionProcessorInterface $collectionProcessor
     * @param Vgroup\SafetyHubApp\Model\Select\Requisitions\Status\Options $requsitionsStatus
     * @param \Vgroup\SafetyHubApp\Helper\Data $helper
     * @param Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchResultsInterfaceFactory $productSearchResultsFactory
     * @param \Vgroup\SafetyHubApp\Helper\Email $mailHelper
     * @param \Vgroup\SafetyHubApp\Model\ReportsFactory $reportFactory
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory $safetyUsersItemsFactory
     * @param \Vgroup\SafetyHubApp\Model\Data\ResponseFactory $response
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(\Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter, RequisitionsFactory $requisitionsFactory, RequisitionsSearchResultsInterfaceFactory $searchResultsFactory, CollectionProcessor $collectionProcessor, ProductCollectionProcessor $productCollectionProcessor = null, \Vgroup\SafetyHubApp\Model\Select\Requisitions\Status\Options $requsitionsStatus, Data $helper, CollectionFactory $collectionFactory,  \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor,  \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchResultsInterfaceFactory $productSearchResultsFactory, Email $mailHelper, ReportsFactory $reportFactory, SearchCriteriaBuilder $searchCriteriaBuilder, SafetyUsersItemsFactory $safetyUsersItemsFactory, \Vgroup\SafetyHubApp\Model\Data\ResponseFactory $response)
    {
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->requisitionsFactory = $requisitionsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->productCollectionProcessor = $productCollectionProcessor ?: $this->getCollectionProcessor();
        $this->searchResultsFactory = $searchResultsFactory;
        $this->requsitionsStatus = $requsitionsStatus;
        $this->helper = $helper;
        $this->collectionFactory = $collectionFactory;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->productSearchResultsFactory = $productSearchResultsFactory;
        $this->mailHelper = $mailHelper;
        $this->reportFactory = $reportFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->safetyUsersItemsFactory = $safetyUsersItemsFactory;
        $this->response = $response;
    }

    /**
     * Retrieve collection processor
     *
     * @deprecated 102.0.0
     * @return CollectionProcessorInterface
     */
    private function getCollectionProcessor()
    {
        if (!$this->productCollectionProcessor) {
            $this->productCollectionProcessor = \Magento\Framework\App\ObjectManager::getInstance()->get(
                // phpstan:ignore "Class Magento\Catalog\Model\Api\SearchCriteria\ProductCollectionProcessor not found."
                \Magento\Catalog\Model\Api\SearchCriteria\ProductCollectionProcessor::class
            );
        }
        return $this->productCollectionProcessor;
    }

    /**
     * Retrieve Requisitions List which match a specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Vgroup\SafetyHubApp\Api\Data\RequisitionsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {

        $safetyItemTypes = $this->helper->getSafetyItemTypes();
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        /** @var \Vgroup\SafetyHubApp\Model\ResourceModel\Requisitions\Collection $collection */
        $collection = $this->requisitionsFactory->create()->getCollection()->addFieldToSelect(['entity_id', 'status', 'created_at', 'updated_at', 'safety_item_type', "firstname", "lastname", "street1", "street2", 'city', "region_id", 'region', 'postcode', 'telephone', 'company', 'status_updated_at', 'status_updated_by', 'status_fulfilled_by']);

        $collection->addFilterToMap('entity_id', 'main_table.entity_id');
        $collection->addFilterToMap('name', new \Zend_Db_Expr("CONCAT(main_table.firstname, ' ',main_table.lastname)"));
        $collection->addFilterToMap('street', new \Zend_Db_Expr("CONCAT(main_table.street1, ' ',IFNULL(main_table.street2,''))"));
        $collection->addFilterToMap('customer_id', 'main_table.customer_id');
        $collection->addFilterToMap('created_at', 'main_table.created_at');
        $collection->addFilterToMap('updated_at', 'main_table.updated_at');
        $collection->addFilterToMap('safety_item_type', 'main_table.safety_item_type');
        $collection->addFilterToMap('sku', 'requisition_items.sku');
        $collection->addFilterToMap('description', 'requisition_items.name');
        $collection->addFilterToMap('company_sku', 'requisition_items.company_sku');
        $collection->addFilterToMap('city', 'main_table.city');
        $collection->addFilterToMap('region', 'main_table.region');
        $collection->addFilterToMap('postcode', 'main_table.postcode');
        $collection->addFilterToMap('status', 'main_table.status');
        //$collection->addFilterToMap('company_name', 'requisition_items.company_name');

        $collection->getSelect()
            // ->columns(new \Zend_Db_Expr("CONCAT(main_table.firstname, ' ',main_table.lastname) AS name"))
            // ->columns(new \Zend_Db_Expr("CONCAT(main_table.street1, ' ',IFNULL(main_table.street2,'')) AS street"))
            ->joinLeft(
                ["requisition_items" => 'safetyhubapp_requisitions_items'],
                "requisition_items.requisition_id  = main_table.entity_id",
                [
                    'sku' => 'sku',
                    'description' => 'name',
                    'company_sku' => 'company_sku',
                    'company_name' => 'company_name'
                ]
            )
            ->joinLeft(
                ['safetyhubapp_users_items' => 'safetyhubapp_users_items'],
                'main_table.safety_item_id = safetyhubapp_users_items.entity_id',
                [
                    'safetyitem_id' => 'safetyhubapp_users_items.entity_id',
                    'serial_number' => 'safetyhubapp_users_items.serial_number',
                    'model_number' => 'safetyhubapp_users_items.model_number',
                    'nickname' => 'safetyhubapp_users_items.nickname'
                ]
            )
            ->joinLeft(
                ['safetyhubapp_items' => 'safetyhubapp_items'],
                'safetyhubapp_users_items.model_number = safetyhubapp_items.model_number',
                [
                    'safetyitem_name' => 'safetyhubapp_items.title',
                    'safetyitem_image' => 'safetyhubapp_items.image'
                ]
            );

        $collection->getSelect()->group('main_table.entity_id');
        $collection->getSelect()->order('main_table.entity_id DESC');

        $this->collectionProcessor->process($searchCriteria, $collection);

        //echo $collection->getSelect();exit; 

        $searchResults->setTotalCount($collection->getSize());
        $requisitions = [];
        /** @var \Vgroup\SafetyHubApp\Model\Requisitions $requisition */
        foreach ($collection as $requisition) {
            $requistionsStatus = $this->requsitionsStatus->toOptionArray();
            // $safetyItemType = (in_array($requisition->getSafetyItemType(), array_keys($safetyItemTypes))) ? $safetyItemTypes[$requisition->getSafetyItemType()] : __('Multiple Safety Items');
            $requisition->setStatusLabel($requistionsStatus[$requisition->getStatus()]);
            // $requisition->setSafetyItemType($safetyItemType);
            $requisitionData = $requisition->getData();
            //array_splice($requisitionData, 14, 4);
            $requisitions[] = $requisitionData;
        }
        $searchResults->setItems($requisitions);
        return $searchResults;
    }


    /**
     * @inheritdoc
     */
    public function getById(SearchCriteriaInterface $searchCriteria, $id, $customerId)
    {

        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFilterToMap('requisition_id', 'requisitions.entity_id');
        $collection->addFilterToMap('customer_id', 'requisitions.customer_id');
        $collection->addFilterToMap('company_sku', 'requisition_items.company_sku');
        $collection->addFilterToMap('company_name', 'requisition_items.company_name');
        $collection->addFilterToMap('qty_ordered', 'requisition_items.qty');
        $collection->addFilterToMap('entity_id', 'e.entity_id');
        $this->extensionAttributesJoinProcessor->process($collection);
        $collection->addAttributeToSelect('*');
        $collection->getSelect()->joinLeft(
            ['requisition_items' => 'safetyhubapp_requisitions_items'],
            'e.entity_id = requisition_items.item_id',
            [
                'company_sku' => 'requisition_items.company_sku',
                'company_name' => 'requisition_items.company_name',
                'ordered_qty' => 'requisition_items.qty',
                'restock_qty' =>  'requisition_items.restock_qty'
            ]
        )->joinLeft(
            ['requisitions' => 'safetyhubapp_requisitions'],
            'requisitions.entity_id = requisition_items.requisition_id',
            [
                'customer_id' => 'requisitions.customer_id',
                'requisition_id' => 'requisitions.entity_id'
            ]
        );
        if ($id != 0)
            $collection->getSelect()->where("requisition_items.requisition_id = ?", $id);
        else
            $collection->getSelect()->where("requisitions.customer_id = ?", $customerId)->where("requisitions.status = ?", 4);
        $this->productCollectionProcessor->process($searchCriteria, $collection);
        $collection->load();
        $searchResult = $this->productSearchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setTotalCount($collection->getSize());
        $safetyItemProducts = [];
        foreach ($collection->getItems() as $product) {
            $productData = $product->getData();
            $reqProductData['product_id'] = (int)$productData['entity_id'];
            $reqProductData['fao_part'] = (!empty($productData['company_sku'])) ? $productData['company_sku'] : $productData['sku'];
            $reqProductData['item_name'] = (!empty($productData['company_name'])) ? $productData['company_name'] : $productData['name'];
            $reqProductData['is_ansi_refill_pack'] = $productData['ansi_refill_pack'] ?? 0;
            $reqProductData['asin'] = $productData['asin'] ?? "null";
            $reqProductData['disable_editing'] = $productData['disable_editing'] ?? 0;
            $reqProductData['qty'] = $productData['ordered_qty'];
            $reqProductData['qty_available'] =  ((int) $productData['ordered_qty'] - (int) $productData['restock_qty']);
            $reqProductData['max_qty'] = 999;
            $reqProductData['company_sku'] = $productData['company_sku'];
            $reqProductData['company_name'] = $productData['company_name'];
            $safetyItemProducts[] = $reqProductData;
        }
        $searchResult->setItems($safetyItemProducts);
        return $searchResult;
    }

    /**
     * @inheritdoc
     */
    public function place(RequisitionsInterface $requisition)
    {

        try {
            /** Saving Requisition */
            $requisitionData = $this->extensibleDataObjectConverter->toNestedArray(
                $requisition,
                [],
                '\Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface'
            );
            $requisitionModel = $this->requisitionsFactory->create();
            /** $requisitionModel = $this->requisitionsFactory->create(['data' => $requisitionData]); */
            unset($requisitionData['id']);
            if ($requisition->getIsDirectRestock() == 3) {
                unset($requisitionData['safety_item_id']);
                unset($requisitionData['safety_item_type']);
            }
            $requisitionData = array_filter($requisitionData);
            $requisitionData['status_updated_at'] = $this->helper->getDate("Y-m-d");
            $requisitionModel->setData($requisitionData);
            if ($requisition->getId())
                $requisitionModel->setEntityId($requisition->getId());
            if (isset($requisitionData['associated_products']))
                $requisitionModel->setAssociatedProducts($requisitionData['associated_products']);
            $requisitionModel->save();
            if ($requisition->getSafetyItemId()) {
                $userSafetyItem = $this->safetyUsersItemsFactory->create()->setId($requisition->getSafetyItemId());
                if ($requisition->getIsDirectRestock() && $requisition->getIsDirectRestock() != 0) {
                    $userSafetyItem->setRestockAt($this->helper->getDate("Y-m-d"))
                        ->setRestockBy($requisition->getEmail())
                        ->setIsRestock(1)
                        ->setRestockType(1);
                }
                $userSafetyItem->setShowPhysicalInventoryDate(0)->save();
            }
            $requisition->getIsDirectRestock() ?? $requisition->setIsDirectRestock(0);
            if ($requisition->getIsDirectRestock() <= 1) {
                $subject = '';
                $storeUrls = $this->helper->getStoreManagerData();
                //** Sendign Requisition Mail */
                $requisitionData['requisition_id'] = $requisitionModel->getId();
                $requisitionData['created_at'] = date("m/d/Y", strtotime($requisitionModel->getCreatedAt()));
                $mailBody = ['user_id' => $requisition->getCustomerId()];
                $body = $this->mailHelper->getTemplateData($mailBody);
                $recipients = explode(",", $requisition->getOtherEmailAddresses());
                array_unshift($recipients, $requisition->getEmail());
                $mailData = ['recipients' => $recipients, 'template_identifier' => 24];
                $mailData['body'] =  array_merge($body, $requisitionData);
                /** Sending Mail to Admins */
                if ($body['approval_mode'] && ($body['interval'] == 0)) {
                    $mailData['body']['is_admin'] = true;
                    $mailData['body']['name_label'] = 'Staff Name';
                    $mailData['body']['view_requisition_link'] = $storeUrls['base_url'] . "customer/account/login/";
                    /** Set Subject */
                    $requistionsStatus = $this->requsitionsStatus->toOptionArray();
                    $subject = "Requisition #" . $requisitionData['requisition_id'] . " is " . $requistionsStatus[$requisition->getStatus()];
                    $mailData['body']['subject'] = $subject;
                    $adminMails = $this->mailHelper->getAdminEmails($requisitionData);
                    if ($adminMails['size'] > 0) {
                        $mailData['recipients'] = $adminMails['email_addersses'];
                        $this->mailHelper->sendMail($mailData);
                    }
                } else {
                    $mailData['body']['is_admin'] = false;
                    $mailData['body']['name_label'] = 'Customer Name';
                    $mailData['body']['approval_mode'] = true;
                    /** Set Subject */
                    $subject = 'New Requisition:';
                    $subject .= !empty($body['company_name']) ? " " . $body['company_name'] : '';
                    $subject .= !empty($requisitionData['nickname']) ? " - " . $requisitionData['nickname'] : '';
                    $subject .= !empty($requisitionData['city']) ? " - " . $requisitionData['city'] : '';
                    $subject .= !empty($requisitionData['region']) ? " - " . $requisitionData['region'] : '';
                    $subject .= !empty($requisitionData['requisition_id']) ? " Req #" . $requisitionData['requisition_id'] : '';
                    $mailData['body']['subject'] = $subject;
                    /** Sending Mail to Login User */
                    $this->mailHelper->sendMail($mailData);
                    /** Sending Mail to Requsition Email Address */
                    $mailData['body']['approval_mode'] = false;
                    $mailData['recipients'] = [$requisition->getRequisitionEmailAddress()];
                    $this->mailHelper->sendMail($mailData);
                }
                //** Saving and Sending Requisiton Report  */
                if (isset($requisitionData['requisition_method']) && $requisitionData['requisition_method'] == 2) :

                    $reportModel = $this->reportFactory->create();
                    $uniqueCode = $this->helper->generateCode();
                    $queryParams = ['report' => $uniqueCode];
                    $storeDetail = $this->helper->getStoreManagerData($queryParams);
                    $reportBody = ['download_link' => $storeDetail['download_link']];
                    $mailData = [
                        'report_type' => $requisition->getRequisitionMethod(),
                        'user_id' => $requisition->getCustomerId(),
                        'recipients' => $recipients,
                        'template_identifier' => 29
                    ];
                    switch($requisition->getRequisitionReportType()):
                        case 3: 
                            $mailData['template_identifier'] = 31; // Requisition History Report
                            break; 
                    endswitch;
                    $mailData['body'] =  array_merge($body, $reportBody);
                    $isReportMailSend = $this->mailHelper->sendMail($mailData);
                    $recipients = @implode(",", $recipients);
                    $reportData = [
                        'report_type' => $requisition->getRequisitionMethod(),
                        'user_id' => $requisition->getCustomerId(),
                        'model_number' => $requisition->getModelNumber(),
                        'sender_email' => $requisition->getEmail(),
                        'recipients' => $recipients,
                        'send_email' => 1,
                        'email_sent' => $isReportMailSend,
                        'unique_code' => $uniqueCode,
                        'filters' => $requisitionModel->getId(),
                        'entity_identifier' => $requisitionModel->getId()
                    ];

                    $reportModel->setData($reportData);
                    $reportModel->save();
                endif;
            }
            $message = "Requisition placed successfully.";
            if ($requisition->getIsDirectRestock() > 0)
                $message =  (string) $this->helper->getSafetyItemTypes($requisition->getSafetyItemType()) . " restocked successfully.";
            $requisitionModel->setMessage($message);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Operation failed : %1', $exception->getMessage()),
                $exception
            );
        }
        return $requisitionModel;
    }

    /**
     * @inheritdoc
     */
    public function deleteById($id)
    {

        try {
            $safetyItem = $this->requisitionsFactory->create();
            $safetyItem->load($id)->delete();
            return true;
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Could not delete the requisition: %1', $exception->getMessage()), $exception);
        }
    }

    /**
     * @inheritdoc
     */
    public function moveToDraft(RequisitionsInterface $requisition)
    {

        try {

            /** Saving Requisition */
            $requisitionData = $this->extensibleDataObjectConverter->toNestedArray(
                $requisition,
                [],
                '\Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface'
            );

            $requisitionModel = $this->requisitionsFactory->create();
            $requisitionModel->setId($requisition->getId());
            $requisitionModel->setData($requisitionData);

            $collection = $requisitionModel->getCollection()->addFieldToSelect(['entity_id'])->addFieldToFilter('status', ['eq' => 4])->addFieldToFilter('customer_id', ['eq' => $requisition->getCustomerId()])->getLastItem();
            $this->draftRequisitionId =  $collection->getId();
            if ($this->draftRequisitionId != 0)
                $requisitionModel->setId($this->draftRequisitionId);

            $requisitionModel->setRequisitionType(2);
            if (isset($requisitionData['associated_products']))
                $requisitionModel->setAssociatedProducts($requisitionData['associated_products']);

            $requisitionModel->save();

            $this->searchCriteriaBuilder->setPageSize(10)->setCurrentPage(1);
            $draftProductsList = $this->searchCriteriaBuilder->create();
            $result = $this->getById($draftProductsList, 0, $requisitionModel->getCustomerId());
        } catch (\Exception $exception) {

            throw new CouldNotSaveException(
                __('Could not move to draft : %1', $exception->getMessage()),
                $exception
            );
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function removeDraftItems(RequisitionsInterface $requisition)
    {

        try {

            /** Saving Requisition */
            $requisitionData = $this->extensibleDataObjectConverter->toNestedArray(
                $requisition,
                [],
                '\Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface'
            );

            $requisitionModel = $this->requisitionsFactory->create();
            $collection = $requisitionModel->getCollection()->addFieldToSelect(['entity_id'])->addFieldToFilter('status', ['eq' => 4])->addFieldToFilter('customer_id', ['eq' => $requisition->getCustomerId()])->getLastItem();
            $this->draftRequisitionId =  $collection->getId();
            $requisitionModel->setId($this->draftRequisitionId);
            $requisitionModel->setRequisitionType(3);
            $requisitionModel->setAssociatedProducts($requisitionData['associated_products']);
            $requisitionModel->save();
            $this->searchCriteriaBuilder->setPageSize(10)->setCurrentPage(1);
            $draftProductsList = $this->searchCriteriaBuilder->create();
            $result = $this->getById($draftProductsList, $this->draftRequisitionId, $requisitionModel->getCustomerId());
        } catch (\Exception $exception) {

            throw new CouldNotSaveException(
                __('Could not remove items from draft : %1', $exception->getMessage()),
                $exception
            );
        }
        return  $result;
    }

    /**
     * @inheritdoc
     */
    public function placetest(SearchCriteriaInterface $searchCriteria, $requisitionId, $modelNumber)
    {

        try {

            // $requisitionModel = $this->requisitionsFactory->create();
            // $collection = $requisitionModel->getCollection()->addFieldToSelect("entity_id")->addFieldToFilter("main_table.entity_id", ['eq' => $requisitionId]);
            // $collection->join(
            //     ["requisition_items" => "safetyhubapp_requisitions_items"],
            //     "requisition_items.requisition_id = main_table.entity_id",
            //     ['item_id' => 'item_id']
            // );
            // echo $collection->getSelect();
            // exit;

            $pageSize = $searchCriteria->getPageSize();
            $currentPage = $searchCriteria->getcurrentPage();
            /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
            $collection = $this->collectionFactory->create();
            $collection->addFilterToMap('company_sku', 'requisition_items.company_sku');
            $collection->addFilterToMap('company_name', 'requisition_items.company_name');
            $collection->addFilterToMap('qty_ordered', 'requisition_items.qty');
            $collection->addFilterToMap('entity_id', 'e.entity_id');
            $this->extensionAttributesJoinProcessor->process($collection);
            $collection->addAttributeToSelect('*')->groupByAttribute('entity_id');
            // $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
            // $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');

            $collection->getSelect()->join(
                ['requisition_items' => 'safetyhubapp_requisitions_items'],
                'e.entity_id = requisition_items.item_id AND requisition_items.requisition_id =' . $requisitionId,
                [
                    'company_sku' => 'requisition_items.company_sku',
                    'company_name' => 'requisition_items.company_name',
                    'ordered_qty' => 'requisition_items.qty',
                    'restock_qty' =>  'requisition_items.restock_qty'
                ]
            )
                ->join(
                    ['safetyitems_products' => 'safetyhubapp_items_products'],
                    'e.entity_id = safetyitems_products.product_id',
                    [
                        'safetyitem_product_qty' => 'safetyitems_products.qty'
                    ]
                )
                ->join(
                    ['safetyitems' => 'safetyhubapp_items'],
                    'safetyitems.entity_id = safetyitems_products.row_id',
                    ['safetyitem_id' => 'safetyitems.entity_id']
                );

            $collection->getSelect()->where("safetyitems.model_number = ?", $modelNumber);
            $clone = clone $collection;
            $totalCount =  count($clone->getItems()); //count($collection);
            $currentPage = ($currentPage == 1) ? 0 : ($currentPage - 1) * $pageSize;
            $collection->getSelect()->order('e.entity_id ASC');
            $collection->getSelect()->limit($pageSize, $currentPage);
            // echo $collection->getSelect();
            // echo $totalCount;
            if ($totalCount == 0)
                throw new \Exception(__('No items of this Cabinet are present in the requisition'));

            $safetyItemProducts = [];
            foreach ($collection->getItems() as $product) {
                $productData = $product->getData();
                $reqProductData['product_id'] = (int)$productData['entity_id'];
                $reqProductData['fao_part'] = (!empty($productData['company_sku'])) ? $productData['company_sku'] : $productData['sku'];
                $reqProductData['item_name'] = (!empty($productData['company_name'])) ? $productData['company_name'] : $productData['name'];
                $reqProductData['is_ansi_refill_pack'] = $productData['ansi_refill_pack'] ?? 0;
                $reqProductData['asin'] = $productData['asin'] ?? "";
                $reqProductData['upc'] = $productData['upc'] ?? "";
                $reqProductData['disable_editing'] = $productData['disable_editing'] ?? 0;
                $reqProductData['qty'] = $productData['qty'] ?? 0;
                $reqProductData['max_qty'] = 999;
                $reqProductData['company_sku'] = $productData['company_sku'];
                $reqProductData['company_name'] = $productData['company_name'];
                $reqProductData['physical_inventory_status'] = $productData['physical_inventory_status'] ?? 0;
                $reqProductData['unit_price'] = $productData['price'];
                $reqProductData['image_url'] = (isset($productData['small_image'])) ? "https://m2.cudabrand.com/pub/media/catalog/product" . $productData['small_image'] : "";
                $safetyItemProducts[] = $reqProductData;
            }
            $searchResult = $this->productSearchResultsFactory->create();
            $searchResult->setSearchCriteria($searchCriteria);
            $searchResult->setTotalCount($totalCount);
            $searchResult->setItems($safetyItemProducts);
        } catch (\Exception $exception) {

            throw new CouldNotSaveException(
                __('Could not place the requisition : %1', $exception->getMessage()),
                $exception
            );
        }
        return $searchResult;
    }
}
