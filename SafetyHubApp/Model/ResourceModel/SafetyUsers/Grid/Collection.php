<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel\SafetyUsers\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Search\AggregationInterface;

/**
 * Class Collection
 * Collection for displaying grid of sales documents
 */
class Collection extends \Vgroup\SafetyHubApp\Model\ResourceModel\SafetyUsers\Collection implements SearchResultInterface {

    /**
     * @var AggregationInterface
     */
    protected $aggregations;

    /**
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param mixed|null $mainTable
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb $eventPrefix
     * @param mixed $eventObject
     * @param mixed $resourceModel
     * @param string $model
     * @param null $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null $resource
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
    \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Store\Model\StoreManagerInterface $storeManager, $mainTable, $eventPrefix, $eventObject, $resourceModel, $model = 'Magento\Framework\View\Element\UiComponent\DataProvider\Document', $connection = null, \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }

    /**
     * @return AggregationInterface
     */
    public function getAggregations() {
        return $this->aggregations;
    }

    /**
     * @param AggregationInterface $aggregations
     * @return $this
     */
    public function setAggregations($aggregations) {
        $this->aggregations = $aggregations;
    }

    /**
     * Retrieve all ids for collection
     * Backward compatibility with EAV collection
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllIds($limit = null, $offset = null) {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }

    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria() {
        return null;
    }

    /**
     * Set search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null) {
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount() {
        return $this->getSize();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount) {
        return $this;
    }

    /**
     * Set items list.
     *
     * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setItems(array $items = null) {
        return $this;
    }

    protected function _renderFiltersBefore() {
        $joinTable = $this->getTable('customer_address_entity');
        $joinSecondTable = $this->getTable('safetyhubapp_companies');

        $joinuserItemTable = $this->getTable('safetyhubapp_customer_permission');
        $attributeId = 146;

        $this->getSelect()
                ->columns([
                    'telephone' => new \Zend_Db_Expr('su.telephone'),
                    'postcode' => new \Zend_Db_Expr('su.postcode'),
                    'country_id' => new \Zend_Db_Expr('su.country_id'),
                    'region' => new \Zend_Db_Expr('su.region'),
                    'req_email' => new \Zend_Db_Expr('sc.email'),
                    'permission_type' => new \Zend_Db_Expr('scu.permission_type'),
                    'company' => new \Zend_Db_Expr('su.company'),
                    'user_permission' => new \Zend_Db_Expr('scu.permission_type'),
                    'requisition_email_address' => new \Zend_Db_Expr('ce1.value')
                ])
                ->joinLeft(
                        array('ce1' => 'customer_entity_varchar'), 'ce1.entity_id=main_table.entity_id and ce1.attribute_id=146'
                        , array('requisition_email_address' => 'value')
                )
//                ->where('ce1.attribute_id=' . $attributeId)
//                ->columns(new \Zend_Db_Expr("`ce1`.`value` AS req_email"))
                ->joinLeft($joinTable . ' as su', 'main_table.default_shipping = su.entity_id', array())
                ->joinLeft($joinSecondTable . ' as sc', 'su.company = sc.name', array())
                ->joinLeft($joinuserItemTable . ' as scu', 'main_table.entity_id = scu.customer_id', array())
                ->where('main_table.website_id=' . 2)
                ->where('main_table.group_id=' . 4);
//        echo $this->getSelect();
//        exit;
        $this->addFilterToMap('permission_type', new \Zend_Db_Expr('scu.permission_type'));
        $this->addFilterToMap('ce1.requisition_email_address', new \Zend_Db_Expr('ce1.value'));
        //echo $this->getSelect(); 
        parent::_renderFiltersBefore();
    }

    protected function _initSelect() {
        $this->addFilterToMap('email', 'main_table.email');
        $this->addFilterToMap('entity_id', 'main_table.entity_id');
        $this->addFilterToMap('firstname', 'main_table.firstname');
        $this->addFilterToMap('lastname', 'main_table.lastname');
        $this->addFilterToMap('created_at', 'main_table.created_at');
        $this->addFilterToMap('permission_type', 'scu.permission_type');
        $this->addFilterToMap('requisition_email_address', 'ce1.value');
        parent::_initSelect();
    }

}
