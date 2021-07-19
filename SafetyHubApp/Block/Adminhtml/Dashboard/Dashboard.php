<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Vgroup\SafetyHubApp\Block\Adminhtml\Dashboard;

/**
 * Description of Dashboard
 *
 *
 */
class Dashboard extends \Magento\Backend\Block\Template implements \Magento\Backend\Block\Widget\Tab\TabInterface {

    /**
     * @var string
     */
    protected $_template = 'Vgroup_SafetyHubApp::dashboard/dashboard.phtml';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Sales\Helper\Admin
     */
    private $adminHelper;

    
    /**
     * @var  \Vgroup\Dashboard\Model\Requisitions $requisition
     */
    protected $_requisitionFactory;
	
	 protected $_companyFactory;
	 protected $_customerFactory;
    
  
     protected $formFactory;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Sales\Helper\Admin $adminHelper
     * @param array $data
     */
    public function __construct(
	    \Magento\Backend\Block\Template\Context $context,
	    \Magento\Framework\Registry $registry,
	    \Magento\Sales\Helper\Admin $adminHelper,
        \Vgroup\SafetyHubApp\Model\RequisitionsFactory $requisitionFactory,
		\Vgroup\SafetyHubApp\Model\CompanyFactory $companyFactory,
		\Vgroup\SafetyHubApp\Model\CustomerFactory $customerFactory,
	    array $data = []
    ) {
	$this->_coreRegistry = $registry;
    $this->_requisitionFactory = $requisitionFactory;
	$this->_companyFactory = $companyFactory;
	$this->_customerFactory = $customerFactory;
	parent::__construct($context,$data);
	$this->adminHelper = $adminHelper;
    }

	
    /**
     * @inheritdoc
     */
    public function getTabLabel() {
	return __('Users');
    }

    /**
     * @inheritdoc
     */
    public function getTabTitle() {
	return __('Dashboard');
    }


    /**
     * Get Class
     *
     * @return string
     */
    public function getClass() {
	return $this->getTabClass();
    }
	 /**
     * Generate Export button html
     *
     * @return string
     */
    public function getButtonHtml()
    {
        $button = $this->getLayout()->createBlock(
            'Magento\Backend\Block\Widget\Button'
        )->setData(
            [
                'id' => 'export_button',
                'label' => __('Download Reports'),
            ]
        );
        return $button->toHtml();
    }

	public function getRequisition() {
		
		$model   = $this->_requisitionFactory->create();
		//$requisition = $model->getCollection();
		
		$totalReqItems = $model->getCollection();
		$totalRequisition = $totalReqItems;
		
		// $approvedReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 1);
        // $approvedRequisition = $approvedReqItems;
		
		return $totalRequisition;
    }
	
	public function getApprovedRequisition() {
		
		$model   = $this->_requisitionFactory->create();
		//$requisition = $model->getCollection();
		
		$approvedReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 1);
        $approvedRequisition = $approvedReqItems;
		
		return $approvedRequisition;
    }
	
	public function getRejectedRequisition() {
		
		$model   = $this->_requisitionFactory->create();
		//$requisition = $model->getCollection();
		
		$rejectedReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 3);
        $rejectedRequisition = $rejectedReqItems;
		
		return $rejectedRequisition;
    }
	
	public function getPendingRequisition() {
		$model   = $this->_requisitionFactory->create();
		//$requisition = $model->getCollection();
		
		$pendingReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 2);
        $pendingRequisition = $pendingReqItems;
		
		return $pendingRequisition;
    }
	
	public function getCompany() {
		
		$companyModel = $this->_companyFactory->create();
		
		$totalCompanyCodes = $companyModel->getCollection();
		$companyCodes = $totalCompanyCodes;
		
		return $companyCodes;
    }

	public function getCustomerEnterprise() {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
			$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
			$connection = $resource->getConnection();
			$tableName = $resource->getTableName('employee'); //gives table name with prefix

			//Select Data from table
			$sql = "SELECT count(*) as total_user FROM customer_entity c, safetyhubapp_customer_permission sc where c.group_id=4 and c.entity_id=sc.customer_id and sc.company_id>0";
			$result = $connection->fetchAll($sql); // gives associated array, table fields as key in array.

                       
		
		return $result[0]['total_user'];
    }
    public function getCustomerStandard() {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
			$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
			$connection = $resource->getConnection();
			$tableName = $resource->getTableName('employee'); //gives table name with prefix

			//Select Data from table
			$sql = "SELECT count(*) as total_user FROM customer_entity c where c.group_id=4 ";
			$result = $connection->fetchAll($sql); // gives associated array, table fields as key in array.

                       
		
		return $result[0]['total_user'];
    }
   

    /**
     * @inheritdoc
     */
    public function canShowTab() {
	return true;
    }

    /**
     * @inheritdoc
     */
    public function isHidden() {
	return false;
    }

}
