<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Vgroup\SafetyHubApp\Block\Adminhtml\Requisitions\Edit\Tab;

/**
 * Description of UserRole
 *
 * @author VIKAS
 */
class Customer extends \Magento\Backend\Block\Template implements \Magento\Backend\Block\Widget\Tab\TabInterface {

    /**
     * @var string
     */
    protected $_template = 'Vgroup_SafetyHubApp::requisitions/customer.phtml';

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
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Sales\Helper\Admin $adminHelper
     * @param array $data
     */
    public function __construct(
	    \Magento\Backend\Block\Template\Context $context,
	    \Magento\Framework\Registry $registry,
	    \Magento\Sales\Helper\Admin $adminHelper,
	    array $data = []
    ) {
	$this->_coreRegistry = $registry;
	parent::__construct($context, $data);
	$this->adminHelper = $adminHelper;
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
	return __('Customer Information');
    }

    /**
     * @inheritdoc
     */
    public function getTabTitle() {
	return __('Customer Information');
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

}
