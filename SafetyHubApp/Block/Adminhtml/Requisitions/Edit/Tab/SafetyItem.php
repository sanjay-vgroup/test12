<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Vgroup\SafetyHubApp\Block\Adminhtml\Requisitions\Edit\Tab;

class SafetyItem extends \Magento\Backend\Block\Template implements \Magento\Backend\Block\Widget\Tab\TabInterface {

    /**
     * @var string
     */
    protected $_template = 'Vgroup_SafetyHubApp::requisitions/safetyitem.phtml';

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
     * @var \Vgroup\SafetyHubApp\Model\Select\SafetyItemsTypes\Options $itemtype
     */
    protected $safetyItemTypes;

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
	    \Vgroup\SafetyHubApp\Model\Select\SafetyItemsTypes\Options $safetyItemTypes,
	    array $data = []
    ) {
	$this->_coreRegistry = $registry;
	$this->adminHelper = $adminHelper;
	$this->safetyItemTypes = $safetyItemTypes;
	parent::__construct($context, $data);
    }

    public function getRequisition() {
	$requisition = $this->_coreRegistry->registry('current_requisition');
	return $requisition;
    }

    public function getRequisitionSafetyItem() {
	$requisitionSafetyItem = $this->_coreRegistry->registry('current_requisition_safetyitem');
	return $requisitionSafetyItem;
    }

    public function getRequisitionItems() {
	$requisitionItems = $this->_coreRegistry->registry('current_requisition_items');
	return $requisitionItems;
    }

    public function getSafetyItemType($option) {
	$safetyItemTypeOptions = $this->safetyItemTypes->toOptionArray();
	return $safetyItemTypeOptions[$option];
    }

    /**
     * @inheritdoc
     */
    public function getTabLabel() {
	return __('Safety Item Information');
    }

    /**
     * @inheritdoc
     */
    public function getTabTitle() {
	return __('Safety Item Information');
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
