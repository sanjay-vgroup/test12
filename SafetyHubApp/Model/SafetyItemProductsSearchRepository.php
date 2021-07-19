<?php

namespace Vgroup\SafetyHubApp\Model;

use Vgroup\SafetyHubApp\Api\SafetyItemProductsSearchRepositoryInterface;
use Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchInterface;
use Vgroup\SafetyHubApp\Model\SafetyItemProductsSearchFactory;
use Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface as ProductCollectionProcessor;
use Vgroup\SafetyHubApp\Model\CompaniesFactory;
use Vgroup\SafetyHubApp\Model\SafetyItemsFactory;

class SafetyItemProductsSearchRepository implements SafetyItemProductsSearchRepositoryInterface
{

    /**
     * @var $safetyItemProductsSearchFactory
     */
    private $safetyItemProductsSearchFactory;

    /**
     * @var $safetyItemProductsSearchResultsInterfaceFactory
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
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var ProductCollectionProcessor
     */
    private $productCollectionProcessor;
    /**
     * @var \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;
    /**
     * @var companiesFactory
     */
    private $companiesFactory;
    /**
     * @var SafetyItemsFactory
     */
    private $safetyItemsFactory;
    /**
     * @param SafetyItemProductsSearchFactory $safetyItemProductsSearchFactory
     * @param SafetyItemProductsSearchResultsInterfaceFactory $searchResultsFactory
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param CollectionProcessorInterface $collectionProcessor
     * @param Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
     * @param Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param  Vgroup\SafetyHubApp\Model\CompaniesFactory $companiesFactory
     * @param SafetyItemsFactory $safetyItemsFactory
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(\Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter, SafetyItemProductsSearchFactory $safetyItemProductsSearchFactory, SafetyItemProductsSearchResultsInterfaceFactory $searchResultsFactory, CollectionProcessor $collectionProcessor, CollectionFactory $collectionFactory, ProductCollectionProcessor $productCollectionProcessor = null,  \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor, \Magento\Framework\Api\FilterBuilder $filterBuilder,  \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder, CompaniesFactory $companiesFactory, SafetyItemsFactory $safetyItemsFactory)
    {
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->safetyItemProductsSearchFactory = $safetyItemProductsSearchFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->productCollectionProcessor = $productCollectionProcessor ?: $this->getCollectionProcessor();
        $this->collectionFactory = $collectionFactory;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->companiesFactory = $companiesFactory;
        $this->safetyItemsFactory = $safetyItemsFactory;
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
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria, SafetyItemProductsSearchInterface $customFilter)
    {
        try {
            $partPreference = 1;
            $joinConditionSafetyItem = '';
            $joinConditionCompany = '';
            $pageSize = $searchCriteria->getPageSize();
            $currentPage = $searchCriteria->getcurrentPage();
            /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
            $collection = $this->collectionFactory->create();
            $collection->addFilterToMap('company_sku', 'companies_partnumbers.company_sku');
            $collection->addFilterToMap('company_name', 'companies_partnumbers.company_name');
            $collection->addFilterToMap('qty', 'products_table.qty');
            $collection->addFilterToMap('entity_id', 'e.entity_id');
            $this->extensionAttributesJoinProcessor->process($collection);
            $collection->addAttributeToSelect('*')->groupByAttribute('entity_id');
            $collection->getSelect()
                ->join(
                    ['products_table' => 'safetyhubapp_items_products'],
                    'products_table.product_id = e.entity_id',
                    ['qty' => 'products_table.qty', 'product_id' => 'products_table.product_id']
                )
                ->joinLeft(
                    ['safetyitems_table' => 'safetyhubapp_items'],
                    'safetyitems_table.entity_id = products_table.row_id',
                    ['item_type' => 'safetyitems_table.type', 'safetyitem_name' => 'safetyitems_table.title', 'safety_item_upc' => 'safetyitems_table.upc']
                );

                if ($customFilter->getCompanyId()) {
                    $company = $this->companiesFactory->create()->load($customFilter->getCompanyId());
                    $partPreference = $company->getPartnumberPreference();
                    $joinConditionSafetyItem = ' AND usersafetyitems_table.company_id=' . $customFilter->getCompanyId();
                    //$joinConditionCompany = ' AND companies_partnumbers.row_id=' . $customFilter->getCompanyId();
                    $collection->getSelect()->joinLeft(
                        ['companies_partnumbers' => 'safetyhubapp_companies_partnumbers'],
                        'e.entity_id = companies_partnumbers.product_id AND companies_partnumbers.row_id =' . $customFilter->getCompanyId(),
                        ['company_name' => 'companies_partnumbers.title', 'company_sku' => 'companies_partnumbers.company_sku']
                    );
                }
                

            if ($customFilter->getRequisitionId()) {
                $collection->getSelect()->join(
                    ['requisition_items' => 'safetyhubapp_requisitions_items'],
                    'e.entity_id = requisition_items.item_id AND requisition_items.requisition_id =' . $customFilter->getRequisitionId(),
                    [
                        'ordered_qty' => 'requisition_items.qty',
                        'restock_qty' =>  'requisition_items.restock_qty',
                        'available_qty' => new \Zend_Db_Expr("(requisition_items.qty - requisition_items.restock_qty)")
                    ]
                );
                $collection->getSelect()->where("safetyitems_table.model_number = ?", $customFilter->getModelNumber());
                $collection->getSelect()->where('(requisition_items.qty - requisition_items.restock_qty) != 0');
            } else if ($customFilter->getUserSafetyItemId()) {
                $collection->addFilterToMap('customer_id', 'usersafetyitems_table.customer_id');
                $collection->getSelect()->joinLeft(
                    ['usersafetyitems_table' => 'safetyhubapp_users_items'],
                    'usersafetyitems_table.model_number = safetyitems_table.model_number' . $joinConditionSafetyItem,
                    [
                        'user_safety_item_id' => 'usersafetyitems_table.entity_id'
                    ]
                )->joinLeft(
                    ['inventory' => 'safetyhubapp_physicalinventory'],
                    'products_table.product_id = inventory.product_id AND inventory.row_id = usersafetyitems_table.entity_id',
                    ['physical_inventory_status' => 'IFNULL(`inventory`.`status`,1)']
                );

                $collection->getSelect()->where("usersafetyitems_table.entity_id = ?", $customFilter->getUserSafetyItemId());
            } else if ($customFilter->getUpc()) {
                $collection->addAttributeToFilter('upc', ['eq' =>  $customFilter->getUpc()]);
            } else {
                if ($customFilter->getSafetyItemType())
                    $collection->getSelect()->where("safetyitems_table.type = ?", $customFilter->getSafetyItemType());
                if ($customFilter->getModelNumber() && !$customFilter->getRequisitionId())
                    $collection->getSelect()->where("safetyitems_table.model_number = ?", $customFilter->getModelNumber());
                if ($customFilter->getFaoPart()) {
                    $collection->addAttributeToFilter(
                        [
                            ['attribute' => 'sku', 'like' => "%" . $customFilter->getFaoPart() . "%"],
                            ['attribute' => 'description', 'like' => "%" . $customFilter->getFaoPart() . "%"]
                        ]
                    );
                    $collection->getSelect()->orWhere("companies_partnumbers.company_sku LIKE ?", "%" . $customFilter->getFaoPart() . "%");
                }
            }
          
            $clone = clone $collection;
            $totalCount =  count($clone->getItems());
            $currentPage = ($currentPage == 1) ? 0 : ($currentPage - 1) * $pageSize;
            $collection->getSelect()->order('e.entity_id ASC');
            $collection->getSelect()->limit($pageSize, $currentPage);
            if ($totalCount == 0 && $customFilter->getRequisitionId())
                throw new \Exception(__('No items of this Cabinet are present in the requisition'));
            $safetyItemProducts = [];
            foreach ($collection->getItems() as $product) {
                $productData = $product->getData();
                $reqProductData['product_id'] = (int)$productData['entity_id'];
                $reqProductData['fao_part'] = (!empty($productData['company_sku'])  && $partPreference != 1) ? $productData['company_sku'] : $productData['sku'];
                $reqProductData['item_name'] = (!empty($productData['company_name'])  && $partPreference != 1) ? $productData['company_name'] : $productData['name'];
                $reqProductData['is_ansi_refill_pack'] = $productData['ansi_refill_pack'] ?? 0;
                $reqProductData['asin'] = $productData['asin'] ?? "";
                $reqProductData['upc'] = $productData['upc'] ?? "";
                $reqProductData['disable_editing'] = $productData['disable_editing'] ?? 0;
                $reqProductData['qty'] = $productData['qty'] ?? 0;
                if ($customFilter->getRequisitionId())
                    $reqProductData['ordered_qty'] = $productData['ordered_qty'];
                if (isset($productData['available_qty']))
                    $reqProductData['available_qty'] = $productData['available_qty'];
                $reqProductData['max_qty'] =  ($customFilter->getRequisitionId()) ?  $productData['qty'] : 999;
                $reqProductData['company_sku'] = $productData['company_sku'] ?? "";
                $reqProductData['company_name'] = $productData['company_name'] ?? "";
                $reqProductData['physical_inventory_status'] = $productData['physical_inventory_status'] ?? 0;
                $reqProductData['unit_price'] = $productData['price'] ?? 0;
                $reqProductData['image_url'] = (isset($productData['small_image'])) ? "https://m2.cudabrand.com/pub/media/catalog/product" . $productData['small_image'] : "";
                if ($customFilter->getIsApi())
                    $reqProductData['model_numbers'] = $this->getAllModelNumbers($reqProductData['product_id']);
                $reqProductData['item_type'] = $productData['item_type'] ?? 0;
                $safetyItemProducts[] = $reqProductData;
            }
            $searchResult = $this->searchResultsFactory->create();
            $searchResult->setSearchCriteria($searchCriteria);
            $searchResult->setTotalCount($totalCount);
            $searchResult->setItems($safetyItemProducts);
            return $searchResult;
        } catch (\Exception $exception) {
            throw new NoSuchEntityException(__($exception->getMessage()));
        }
    }


    public function getAllModelNumbers($productId)
    {
        $modelNumbers = [];
        $collection = $this->safetyItemsFactory->create()->getCollection()
            ->addFieldToSelect('model_number');
        $collection->getSelect()
            ->join(
                ['products_table' => 'safetyhubapp_items_products'],
                'products_table.row_id = main_table.entity_id',
                []
            )->where("products_table.product_id = ?", $productId)
            ->where("main_table.status = ?", 1);
        if ($collection->getSize() > 0) {
            foreach ($collection as $safetyItemData) {
                $modelNumbers[] = $safetyItemData->getModelNumber();
            }
        }
        return $modelNumbers;
    }
}
