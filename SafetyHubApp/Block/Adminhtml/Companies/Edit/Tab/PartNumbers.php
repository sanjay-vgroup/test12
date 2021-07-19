<?php

namespace Vgroup\SafetyHubApp\Block\Adminhtml\Companies\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magento\Framework\Registry;
use Vgroup\SafetyHubApp\Model\ResourceModel\Companies\PartNumbers\CollectionFactory;

class PartNumbers extends \Magento\Backend\Block\Widget\Grid\Extended {

    /**
     * @var \Vgroup\SafetyHubApp\Model\ResourceModel\Companies\PartNumbers\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var  \Magento\Framework\Registry
     */
    protected $registry;

    /**
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Framework\Registry $registry
     * @param SafetyitemFactory $attachmentFactory
     * @param \Vgroup\SafetyHubApp\Model\ResourceModel\Companies\PartNumbers\CollectionFactory $partNumbersCollectionFactory
     * @param array $data
     */
    public function __construct(
	    Context $context,
	    Data $backendHelper,
	    Registry$coreRegistry,
	    CollectionFactory $partNumbersCollectionFactory,
	    array $data = []
    ) {
	$this->_coreRegistry = $coreRegistry;
	$this->_collectionFactory = $partNumbersCollectionFactory;
	parent::__construct($context, $backendHelper, $data);
    }

    /**
     * _construct
     * @return void
     */
    protected function _construct() {
	parent::_construct();
	$this->setId('partnumbersGrid');
	$this->setDefaultSort('value_id');
	$this->setDefaultLimit(200);
	$this->setDefaultDir('DESC');
	$this->setSaveParametersInSession(true);
	$this->setUseAjax(true);
    }

    protected function _prepareMassaction() {
	$this->setMassactionIdField('value_id');
	$this->getMassactionBlock()->setFormFieldName('value_id');

	$this->getMassactionBlock()->addItem('delete', array(
	    'label' => __('Delete'),
	    'url' => $this->getUrl('*/*/massPartNumbersDelete', array('entity_id' => $this->getRequest()->getParam('entity_id'))), // public function massDeleteAction() in Mage_Adminhtml_Tax_RateController
	    'confirm' => __('Are you sure?')
	));

	$this->getMassactionBlock()->setUseSelectAll(false);
	return $this;
    }

    /**
     * prepare collection
     */
    protected function _prepareCollection() {
	$collection = $this->_collectionFactory->create();
	$collection->addFieldToFilter('row_id', array('eq' => $this->getRequest()->getParam('entity_id')));
	//$filters = base64_decode($this->getRequest()->getParam('filter'));
	//print_r($filters);
	$this->setCollection($collection);
	return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns() {

	$this->addColumn(
		'default_sku',
		[
		    'header' => __('Default SKU'),
		    'index' => 'default_sku',
		    'width' => '50px',
		]
	);

	$this->addColumn(
		'company_sku',
		[
		    'header' => __('Company SKU'),
		    'index' => 'company_sku',
		]
	);
	$this->addColumn(
		'title',
		[
		    'header' => __('Title'),
		    'index' => 'title'
		]
	);


	return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl() {
	return $this->getUrl('*/*/partnumbersgrid', ['_current' => true]);
    }

    /**
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row) {
	return '';
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
