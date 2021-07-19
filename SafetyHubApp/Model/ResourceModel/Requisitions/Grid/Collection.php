<?php

namespace Vgroup\SafetyHubApp\Model\ResourceModel\Requisitions\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Search\AggregationInterface;

/**
 * Class Collection
 * Collection for displaying grid of sales documents
 */
class Collection extends \Vgroup\SafetyHubApp\Model\ResourceModel\Requisitions\Collection implements SearchResultInterface {

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
        $joinTable = $this->getTable('safetyhubapp_users_items');
        $this->getSelect()
                ->columns(['model_number' => new \Zend_Db_Expr('su.model_number')
                    , 'serial_number' => new \Zend_Db_Expr('su.serial_number')
                ])
                ->joinLeft($joinTable . ' as su', 'main_table.safety_item_id = su.entity_id', array());
        parent::_renderFiltersBefore();
    }

    protected function _initSelect() {
        $this->addFilterToMap('company', 'main_table.company');
        $this->addFilterToMap('entity_id', 'main_table.entity_id');
        $this->addFilterToMap('email', 'main_table.email');
        $this->addFilterToMap('firstname', 'main_table.firstname');
        $this->addFilterToMap('created_at', 'main_table.created_at');
        $this->addFilterToMap('street1', 'main_table.street1');
        $this->addFilterToMap('postcode', 'main_table.postcode');
        $this->addFilterToMap('city', 'main_table.city');
        $this->addFilterToMap('region', 'main_table.region');
        parent::_initSelect();
    }

}
