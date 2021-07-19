<?php

namespace Vgroup\SafetyHubApp\Block\Adminhtml\SafetyItems\Edit\Tab;

use Vgroup\SafetyHubApp\Model\SafetyItemsFactory;

class SerialNumbers extends \Magento\Backend\Block\Widget\Grid\Extended {

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var \Vgroup\SafetyHubApp\Model\ResourceModel\CabinetSerialNumbers\CollectionFactory
     */
    protected $cabinetSerialFactory;

    /**
     * Safetyitem factory
     *
     * @var SafetyitemFactory
     */
    protected $safetyItemFactory;

    /**
     * @var  \Magento\Framework\Registry
     */
    protected $registry;
    protected $_objectManager = null;

    /**
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Framework\Registry $registry
     * @param SafetyitemFactory $attachmentFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Vgroup\SafetyHubApp\Model\ResourceModel\CabinetSerialNumbers\CollectionFactory $cabinetSerialFactory
     * @param array $data
     */
    public function __construct(
    \Magento\Backend\Block\Template\Context $context, \Magento\Backend\Helper\Data $backendHelper, \Magento\Framework\Registry $registry, \Magento\Framework\ObjectManagerInterface $objectManager, SafetyItemsFactory $safetyitemFactory, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory, \Vgroup\SafetyHubApp\Model\ResourceModel\CabinetSerialNumbers\CollectionFactory $cabinetSerialFactory, array $data = []
    ) {
        $this->safetyItemFactory = $safetyitemFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->cabinetSerialFactory = $cabinetSerialFactory;
        $this->_objectManager = $objectManager;
        $this->registry = $registry;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * _construct
     * @return void
     */
    protected function _construct() {
        parent::_construct();
        $this->setId('serialnumbersGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('entity_id')) {
            $this->setDefaultFilter(array('in_serial' => 1));
        }
    }

    /**
     * add Column Filter To Collection
     */
    protected function _addColumnFilterToCollection($column) {
        if ($column->getId() == 'in_serial') {
            $productIds = $this->_getSelectedSerialNumbers();

            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('id', array('in' => $productIds));
            } else {
                if ($productIds) {
                    $this->getCollection()->addFieldToFilter('id', array('nin' => $productIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    /**
     * prepare collection
     */
    protected function _prepareCollection() {
        //echo "Yes 2";exit;
        $collection = $this->cabinetSerialFactory->create();
        $collection->addFieldToSelect('id');
        $collection->addFieldToSelect('serial_number');
        if ($this->getRequest()->getParam('entity_id')) {
            $collection->addFieldToFilter('row_id', $this->getRequest()->getParam('entity_id'));
        } else {
            $collection->addFieldToFilter('row_id', 0);
        }
        $this->setCollection($collection);
//        echo $collection->getSelect()->__toString();
//        exit;
        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns() {


        $this->addColumn(
                'in_serial', [
            'header_css_class' => 'a-center',
            'field_name' => 'serial_id[]',
            'type' => 'checkbox',
            'name' => 'in_serial',
            'align' => 'center',
            'index' => 'id',
            'values' => $this->_getSelectedSerialNumbers(),
                ]
        );

        $this->addColumn(
                'serial_number', [
            'header' => __('Serial Number'),
            'type' => 'text',
            'index' => 'serial_number',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id',
                ]
        );
        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl() {
        return $this->getUrl('*/*/serialnumbersgrid', ['_current' => true]);
    }

    /**
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row) {
        return '';
    }

    protected function _getSelectedProducts() {
        $products = array_keys($this->getSelectedProducts());
        return $products;
    }

    protected function _getSelectedSerialNumbers() {
        $products = array_keys($this->getSelectedSerialNumbers());
        return $products;
    }

    /**
     * Retrieve selected products
     *
     * @return array
     */
    public function getSelectedProducts() {

        $products = $this->getSafetyItems()->getProductsOnly($this->getSafetyItems());
        $proIds = [];
        if (is_array($products) && count($products) > 0) {
            foreach ($products as $product) {
                $proIds[$product['product_id']] = array('qty' => $product['qty']);
            }
        }
        return $proIds;
    }

    /**
     * Retrieve selected Serial Numbers
     *
     * @return array
     */
    public function getSelectedSerialNumbers() {

        $products = $this->getSafetyItems()->getCabinetSerials($this->getSafetyItems());
//        echo '<pre>';
//        print_r($products); 
//        exit; 
        $proIds = [];
        if (is_array($products) && count($products) > 0) {
            foreach ($products as $product) {
                $proIds[$product['id']] = array('serial_number' => $product['serial_number']);
            }
        }
        return $proIds;
    }

    protected function getSafetyItems() {
        $safetyitemId = $this->getRequest()->getParam('entity_id');
        $safetyitem = $this->safetyItemFactory->create();
        if ($safetyitemId) {
            $safetyitem->load($safetyitemId);
        }
        return $safetyitem;
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab() {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden() {
        return true;
    }

}
