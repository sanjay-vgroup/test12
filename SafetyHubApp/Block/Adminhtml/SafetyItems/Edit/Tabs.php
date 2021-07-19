<?php

namespace Vgroup\SafetyHubApp\Block\Adminhtml\SafetyItems\Edit;

/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs {

    /**
     * @return void
     */
    protected function _construct() {
	parent::_construct();
	$this->setId('safetyhubapp_safetyitems_tabs');
	$this->setDestElementId('edit_form');
	$this->setTitle(__('Safety Item Information'));
    }

    protected function _prepareLayout() {
	
	$this->addTab(
		'safetyitem_edit_tab_main', [
	    'label' => __('General'),
	    'title' => __('General'),
	    'content' => $this->getLayout()->createBlock('Vgroup\SafetyHubApp\Block\Adminhtml\SafetyItems\Edit\Tab\Main')->toHtml(),
	    'active' => true
		]
	);

	$this->addTab('safetyitem_edit_tab_products_grid', array(
	    'label' => __('Products'),
	    'title' => __('Products'),
	    'url' => $this->getUrl('*/*/products', array('id' => $this->getRequest()->getParam('entity_id'), '_current' => true)),
	    'class' => 'ajax'
	));

	$this->addTab('safetyitem_edit_tab_cabinet_serial', array(
	    'label' => __('Serial Numbers'),
	    'title' => __('Serial Numbers'),
	    'url' => $this->getUrl('*/*/serialnumbers', array('id' => $this->getRequest()->getParam('entity_id'), '_current' => true)),
	    'class' => 'ajax'
	));

	 return parent::_prepareLayout();
    }

}
