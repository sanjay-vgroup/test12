<?php

namespace Vgroup\SafetyHubApp\Block\Adminhtml\Requisitions\Edit;

/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs {

    /**
     * @return void
     */
    protected function _construct() {
	parent::_construct();
	$this->setId('requisitions_tabs');
	$this->setDestElementId('edit_form');
	$this->setTitle(__('Requisitions Information'));
    }

}
