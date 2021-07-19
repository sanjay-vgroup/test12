<?php

namespace Vgroup\SafetyHubApp\Block\Adminhtml\Requisitions;

class Edit extends \Magento\Backend\Block\Widget\Form\Container {

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
	    \Magento\Backend\Block\Widget\Context $context,
	    \Magento\Framework\Registry $registry,
	    array $data = []
    ) {
	$this->_coreRegistry = $registry;
	parent::__construct($context, $data);
    }

    /**
     *
     * @return void
     */
    protected function _construct() {
	$this->_objectId = 'entity_id';
	$this->_blockGroup = 'Vgroup_SafetyHubApp';
	$this->_controller = 'adminhtml_requisitions';

	parent::_construct();

	$this->buttonList->remove('save');
	$this->buttonList->remove('saveandcontinue');
	$this->buttonList->remove('delete');
	$this->buttonList->remove('reset');
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
