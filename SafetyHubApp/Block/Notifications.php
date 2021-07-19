<?php

namespace Vgroup\SafetyHubApp\Block;

/**
 * Companies
 */
class Notifications extends \Magento\Backend\Block\Widget\Grid\Container {

    /**
     * Block constructor
     *
     * @return void
     */
    protected function _construct() {

	parent::__construct($context, $data);
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId) {
	return $this->_authorization->isAllowed($resourceId);
    }

}
