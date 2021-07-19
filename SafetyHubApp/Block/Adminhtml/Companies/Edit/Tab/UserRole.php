<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Vgroup\SafetyHubApp\Block\Adminhtml\Companies\Edit\Tab;
use Vgroup\SafetyHubApp\Model\CompanyFactory;
/**
 * Description of UserRole
 *
 * @author VIKAS
 */
class UserRole extends \Magento\Backend\Block\Template implements \Magento\Backend\Block\Widget\Tab\TabInterface {

    /**
     * @var string
     */
    protected $_template = 'Vgroup_SafetyHubApp::company/userrole.phtml';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    protected $_companyFactory;
    /**
     * @var \Magento\Sales\Helper\Admin
     */
    private $adminHelper;

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
          CompanyFactory $company,
        array $data = []
    ) {
	$this->_coreRegistry = $registry;
	parent::__construct($context, $data);
	$this->adminHelper = $adminHelper;
        $this->_companyFactory = $company;
    }

    //    /**
    //     * Retrieve order model instance
    //     *
    //     * @return \Magento\Sales\Model\Order
    //     */
    //    public function getOrder()
    //    {
    //        return $this->_coreRegistry->registry('current_order');
    //    }

    /**
     * @inheritdoc
     */
    public function getTabLabel() {
	return __('User Role');
    }

    /**
     * @inheritdoc
     */
    public function getTabTitle() {
	return __('Company');
    }

    /**
     * Get Tab Class
     *
     * @return string
     */
    //    public function getTabClass() {
    //	return 'ajax only';
    //    }

    /**
     * Get Class
     *
     * @return string
     */
    public function getClass() {
	return $this->getTabClass();
    }

    /**
     * Get Tab Url
     *
     * @return string
     */
    //    public function getTabUrl() {
    //	return $this->getUrl('safetyhubapp/*/commentsHistory', ['_current' => true]);
    //    }

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
    
    public function getCompanyData() { 
        $id = $this->getRequest()->getParam('entity_id');
        $company = $this->_companyFactory->create();
        $company->load($id, 'entity_id');
        return $company->getData();
    }
}
