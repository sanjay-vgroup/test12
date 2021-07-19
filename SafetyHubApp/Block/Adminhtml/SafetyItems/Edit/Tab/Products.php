<?php

namespace Vgroup\SafetyHubApp\Block\Adminhtml\SafetyItems\Edit\Tab;

use Vgroup\SafetyHubApp\Model\SafetyItemsFactory;

class Products extends \Magento\Backend\Block\Widget\Grid\Extended {

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollectionFactory;

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
     * @param array $data
     */
    public function __construct(
    \Magento\Backend\Block\Template\Context $context, \Magento\Backend\Helper\Data $backendHelper, \Magento\Framework\Registry $registry, \Magento\Framework\ObjectManagerInterface $objectManager, SafetyItemsFactory $safetyitemFactory, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory, array $data = []
    ) {
        $this->safetyItemFactory = $safetyitemFactory;
        $this->productCollectionFactory = $productCollectionFactory;
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
        $this->setId('productsGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('entity_id')) {
            $this->setDefaultFilter(array('in_product' => 1));
        }
    }

    /**
     * add Column Filter To Collection
     */
    protected function _addColumnFilterToCollection($column) {
        if ($column->getId() == 'in_product') {
            $productIds = $this->_getSelectedProducts();

            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in' => $productIds));
            } else {
                if ($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin' => $productIds));
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
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToSelect('sku');
        $collection->addAttributeToSelect('price');
        if ($this->getRequest()->getParam('entity_id')) {
            $constraint = '{{table}}.row_id=' . $this->getRequest()->getParam('entity_id');
        } else {
            $constraint = '{{table}}.row_id=0';
        }
        $collection->joinField('qty', 'safetyhubapp_items_products', 'qty', 'product_id = entity_id', $constraint, 'left'
        );
        $this->setCollection($collection);
//	echo $collection->getSelect()->__toString();
//        exit;

        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns() {


        $this->addColumn(
                'in_product', [
            'header_css_class' => 'a-center',
            'field_name' => 'products_id[]',
            'type' => 'checkbox',
            'name' => 'in_product',
            'align' => 'center',
            'index' => 'entity_id',
            'values' => $this->_getSelectedProducts(),
                ]
        );

        $this->addColumn(
                'entity_id', [
            'header' => __('Product ID'),
            'type' => 'number',
            'index' => 'entity_id',
            'header_css_class' => 'col-id',
            'column_css_class' => 'col-id',
                ]
        );
        $this->addColumn(
                'name', [
            'header' => __('Name'),
            'index' => 'name',
            'class' => 'xxx',
            'width' => '50px',
                ]
        );
        $this->addColumn(
                'sku', [
            'header' => __('Sku'),
            'index' => 'sku',
            'class' => 'xxx',
            'width' => '50px',
                ]
        );

        $this->addColumn(
                'price', [
            'header' => __('Price'),
            'type' => 'currency',
            'index' => 'price',
            'width' => '50px',
                ]
        );

        $this->addColumn(
                'qty', [
            'header' => __('Quantity'),
            'width' => '100',
            'type' => 'input',
            'field' => 'products_id',
            'class' => 'qty',
            'column_css_class' => 'qty-container',
            'index' => 'qty',
            'field_name' => 'qty[]',
            'editable' => true,
            'filter' => false
                ]
        );

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl() {
        return $this->getUrl('*/*/productsgrid', ['_current' => true]);
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
