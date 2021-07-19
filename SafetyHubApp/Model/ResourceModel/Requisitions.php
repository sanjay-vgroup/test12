<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel;

/**
 * ProductsGrid mysql resource
 */
class Requisitions extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    const TBL_REQUISITION_ITEMS = 'safetyhubapp_requisitions_items';
    const TBL_REQUISITION_USER_SAFETYITEM = 'safetyhubapp_users_items';

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * @var  \Magento\Customer\Api\CustomerRepositoryInterfaceFactory $customerRepositoryFactory
     */
    protected $customerRepository;

    /**
     * @var  \Magento\Customer\Model\AddressFactory $addresses
     */
    protected $addresses;

    /**
     * @var  \Vgroup\SafetyHubApp\Model\Select\Requisitions\Status\Options $requsitionsStatus
     */
    protected $requsitionsStatus;

    /**
     * @var  \Magento\Customer\Api\GroupRepositoryInterface $groupRepository
     */
    protected $groupRepository;
    /** 
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory 
     */
    protected $productCollectionFactory;
    /** 
     * @var array
     */
    protected $productIds;
    /** 
     * @var array
     */
    protected $requestProductData;
    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Magento\Customer\Api\CustomerRepositoryInterfaceFactory $customerRepositoryFactory
     * @param \Magento\Customer\Model\AddressFactory $addresses
     * @param \Vgroup\SafetyHubApp\Model\Select\Requisitions\Status\Options $requsitionsStatus
     * @param \Magento\Customer\Api\GroupRepositoryInterface $groupRepository
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param string|null $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Customer\Api\CustomerRepositoryInterfaceFactory $customerRepositoryFactory,
        \Magento\Customer\Model\AddressFactory $addresses,
        \Vgroup\SafetyHubApp\Model\Select\Requisitions\Status\Options $requsitionsStatus,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->_date = $date;
        $this->customerRepository = $customerRepositoryFactory;
        $this->requsitionsStatus = $requsitionsStatus;
        $this->addresses = $addresses;
        $this->groupRepository = $groupRepository;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('safetyhubapp_requisitions', 'entity_id');
    }

    /**
     * Process post data before saving
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {

        $this->productIds = [];
        $this->requestProductData = [];
        if ($object->isObjectNew() && !$object->hasCreatedAt()) {
            $object->setCreatedAt($this->_date->gmtDate());
        }
        $object->setUpdatedAt($this->_date->gmtDate());
        $connection = $this->getConnection();
        $requisitionItemsTable = $this->getTable(self::TBL_REQUISITION_ITEMS);
        $requisitionProductsData = $object->getAssociatedProducts();
        $updateRestockQty = '';
        if (is_array($requisitionProductsData) && count($requisitionProductsData) > 0) :
            foreach ($requisitionProductsData as $product) :
                $this->productIds[] = (int)$product['product_id'];
                $this->requestProductData[$product['product_id']] = $product;
                if ($object->getIsDirectRestock() == 3) :
                    $updateRestockQty = "UPDATE " . $requisitionItemsTable . " SET `restock_qty` = `restock_qty` + '" . $product['restock_qty'] . "' WHERE `item_id` = '" . (int)$product['product_id'] . "' AND `requisition_id` ='" . (int)$object->getId() . "';";
                    $connection->query($updateRestockQty);
                endif;
            endforeach;
        endif;

        if ($object->getIsDirectRestock() == 3) {
            $setStatusQry = $connection->select()->from($requisitionItemsTable, 'COUNT(entity_id) AS totalCount')->where('requisition_id = ?', (int)$object->getId())->where('(qty-restock_qty) != ?', 0);
            $remainingItemsCount = (int)$connection->fetchOne($setStatusQry);
            if ($remainingItemsCount == 0)
                $object->setStatus(5)->setIsRestockComplete(1);
        }
        return parent::_beforeSave($object);
    }

    /**
     * Unserialize additional_information in each item
     *
     * @return $this
     */
    protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object)
    {

        $connection = $this->getConnection();
        $userSafetyItem = $this->getTable('safetyhubapp_users_items');
        $safetyItem = $this->getTable('safetyhubapp_items');
        $customerAddress = [];
        $requistionsStatus = $this->requsitionsStatus->toOptionArray();

        //$customer = $this->customerRepository->create()->getById($object->getCustomerId());
        //$shippingAddress = $this->addresses->create()->load($customer->getDefaultShipping());
        //$billingAddress = $shippingAddress;
        //if ($customer->getDefaultShipping() != $customer->getDefaultBilling())
        // $billingAddress = $this->addresses->create()->load($customer->getDefaultBilling());
        //$customerGroups = $this->groupRepository->getById($customer->getGroupId());
        $object->setRequisitionStatusLabel($requistionsStatus[$object->getStatus()]);
        $object->setCustomerName($object->getFirstname() . " " . $object->getLastname());
        //$object->setEmail($customer->getEmail());
        //$object->setFirstname($customer->getFirstname());
        //$object->setLastname($customer->getLastname());
        //$object->setCustomerGroup($customerGroups->getCode());
        //	$object->setShippingStreet($shippingAddress->getStreet());
        //	$object->setShippingCity($shippingAddress->getCity());
        //	$object->setShippingRegion($shippingAddress->getRegion());
        //	$object->setShippingTelephone($shippingAddress->getTelephone());
        //	$object->setShippingCompany($shippingAddress->getCompany());
        //	$object->setShippingPostcode($shippingAddress->getPostcode());
        //	$object->setShippingCountryId($shippingAddress->getCountryId());
        //	$object->setBillingStreet($billingAddress->getStreet());
        //	$object->setBillingCity($billingAddress->getCity());
        //	$object->setBillingRegion($billingAddress->getRegion());
        //	$object->setBillingTelephone($billingAddress->getTelephone());
        //	$object->setBillingCompany($billingAddress->getCompany());
        //	$object->setBillingPostcode($billingAddress->getPostcode());
        //	$object->setBillingCountryId($billingAddress->getCountryId());

        $select = $connection->select()->from(
            $userSafetyItem,
            ['model_number', 'serial_number', 'nickname']
        )->where(
            $userSafetyItem . '.entity_id = ?',
            (int) $object->getSafetyItemId()
        );

        $select->joinLeft(
            ['safetyhubapp_items' => $safetyItem],
            'safetyhubapp_items.model_number = ' . $userSafetyItem . '.model_number',
            ['safety_item_name' => 'safetyhubapp_items.title', 'image' => 'image']
        );

        //echo $select;
        $safetyItemDetail = $connection->fetchRow($select);
        $object->setSafetyItemName($safetyItemDetail['safety_item_name']);
        $object->setSafetyItemImage($safetyItemDetail['image']);
        $object->setModelNumber($safetyItemDetail['model_number']);
        $object->setSerialNumber($safetyItemDetail['serial_number']);
        $object->setNickname($safetyItemDetail['nickname']);
        //	print_r($safetyItemDetail);
        //	exit;
        return parent::_afterLoad($object);
    }


    /**
     * Process post data after saving
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {

        $productsData = [];
        if ($object->getIsDirectRestock() != 3) :
            $productIds = $this->productIds;
            $requestProductData = $this->requestProductData;
            $connection = $this->getConnection();
            $requisitionItemsTable = $this->getTable(self::TBL_REQUISITION_ITEMS);
            $connection->delete($requisitionItemsTable, [$requisitionItemsTable . '.requisition_id = ?' => (int)$object->getId(), $requisitionItemsTable . '.item_id IN (?)' => $productIds]);
            if ($object->getRequisitionType() == 3)
                return parent::_afterSave($object);
            $collection = $this->productCollectionFactory->create();
            $collection->addAttributeToSelect(['name', 'sku'])->addAttributeToFilter('entity_id', array('in' => $productIds));
            if ($object->getCompanyId() != null) {
                $collection->getSelect()->joinLeft(
                    ['companies_items' => $this->getTable('safetyhubapp_companies_partnumbers')],
                    'companies_items.default_sku = e.sku AND companies_items.row_id =' . (int) $object->getCompanyId(),
                    ['companies_items.company_sku', 'companies_items.title']
                );
            }
            if ($collection->getSize() > 0) {
                foreach ($collection as $product) {
                    if (isset($requestProductData[$product['entity_id']]))
                        $productRequestData = $requestProductData[$product['entity_id']];
                    $productsData[] = [
                        'requisition_id' => (int) $object->getId(),
                        'safetyitem_id' => (int) $object->getSafetyItemId(),
                        'item_id' => (int) $productRequestData['product_id'],
                        'sku' => $product->getSku(),
                        'company_sku' => $product->getCompanySku(),
                        'name' => $product->getName(),
                        'company_name' => $product->getTitle(),
                        'qty' => (int) $productRequestData['qty'],
                        'restock_qty' => $productRequestData['restock_qty'] ?? 0,
                        'price' => $productRequestData['unit_price']
                    ];
                }
            }
            if (count($productsData) > 0) {
                $connection->insertMultiple($requisitionItemsTable, $productsData);
            }
            return parent::_afterSave($object);
        endif;
    }
}
