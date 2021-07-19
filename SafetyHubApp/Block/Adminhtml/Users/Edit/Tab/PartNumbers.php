<?php

namespace Vgroup\SafetyHubApp\Block\Adminhtml\Users\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magento\Framework\Registry;
use Vgroup\SafetyHubApp\Model\ResourceModel\Companies\PartNumbers\CollectionFactory;
use Vgroup\SafetyHubApp\Model\SafetyItemsUsersFactory;

class PartNumbers extends \Magento\Backend\Block\Widget\Grid\Extended {

    /**
     * @var \Vgroup\SafetyHubApp\Model\ResourceModel\Companies\PartNumbers\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var  \Magento\Framework\Registry
     */
    protected $registry;
    
    protected $_safetyItemsUsers;

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
            \Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory $safetyItemsUsers,
	    array $data = []
    ) {
	$this->_coreRegistry = $coreRegistry;
	$this->_collectionFactory = $partNumbersCollectionFactory;
        $this->_safetyItemsUsers = $safetyItemsUsers;
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

//    protected function _prepareMassaction() {
//        
//	$this->setMassactionIdField('value_id');
//	$this->getMassactionBlock()->setFormFieldName('value_id');
//
//	$this->getMassactionBlock()->addItem('delete', array(
//	    'label' => __('Delete'),
//	    'url' => $this->getUrl('*/*/massPartNumbersDelete', array('entity_id' => $this->getRequest()->getParam('entity_id'))), // public function massDeleteAction() in Mage_Adminhtml_Tax_RateController
//	    'confirm' => __('Are you sure?')
//	));
//
//	$this->getMassactionBlock()->setUseSelectAll(false);
//	return $this;
//    }

    /**
     * prepare collection
     */ 
    protected function _prepareCollection() {
//	$collection = $this->_collectionFactory->create();
//        echo $this->getRequest()->getParam('id');
//        exit;
//	$collection->addFieldToFilter('row_id', array('eq' => $this->getRequest()->getParam('id')));
	//$filters = base64_decode($this->getRequest()->getParam('filter'));
	//print_r($filters);
        
        $collection = $this->_safetyItemsUsers->create();
        //        $collection->load($this->getRequest()->getParam('id'),'customer_id');
        
        $tempCollection = $collection->getCollection()->addFieldToFilter('main_table.customer_id', $this->getRequest()->getParam('id'));
        
//        $collection->getCollection()->addFieldToFilter('main_table.customer_id', $this->getRequest()->getParam('id'));
//      print_r($collection);
//      exit;
       
	$this->setCollection($tempCollection);
	return parent::_prepareCollection();
    }

    
    /**
     * @return $this
     */
    protected function _prepareColumns() {

	$this->addColumn(
		'created_at',
		[
		    'header' => __('Created On'),
		    'index' => 'created_at',
		    'width' => '50px',
		]
	);

	$this->addColumn(
		'updated_at',
		[
		    'header' => __('Update On'),
		    'index' => 'updated_at',
		]
	);
	$this->addColumn(
		'email',
		[
		    'header' => __('Email'),
		    'index' => 'email'
		]
	);
        $this->addColumn(
		'type',
		[
		    'header' => __('Type'),
		    'index' => 'type',
                    'type'      => 'options',
                    'options'   => array(
                        1 => 'Cabinet',
                        2 => 'Fire Exitinguisher',
                        3 => 'AED',
                        4 => 'Eyewash Stations',
                        5 => 'Spill Control',
                        
                       
                    )
		]
	);
        $this->addColumn(
		'model_number',
		[
		    'header' => __('Model#'),
		    'index' => 'model_number'
		]
	);

         $this->addColumn(
		'serial_number',
		[
		    'header' => __('Serial#'),
		    'index' => 'serial_number'
		]
	);

         $this->addColumn(
		'nickname',
		[
		    'header' => __('Nickname'),
		    'index' => 'nickname'
		]
	);
          $this->addColumn(
		'city',
		[
		    'header' => __('City'),
		    'index' => 'city'
		]
	);
           $this->addColumn(
		'region',
		[
		    'header' => __('Region'),
		    'index' => 'region'
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
