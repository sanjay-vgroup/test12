<?php

namespace Vgroup\SafetyHubApp\Block\Adminhtml\Requisitions\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface {

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $store;
    protected $_template = 'Vgroup_SafetyHubApp::requisitions/requisition.phtml';
    protected $itemtype;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Vgroup\SafetyHubApp\Helper\Data $helper
     */
    protected $helper;

    /**
     * @var \Vgroup\SafetyHubApp\Block\Adminhtml\Requisitions\Edit $requistion
     */
    protected $requisition;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
	    \Magento\Backend\Block\Template\Context $context,
	    \Magento\Framework\Data\FormFactory $formFactory,
	    \Vgroup\SafetyHubApp\Helper\Data $helper,
	    \Magento\Framework\Registry $registry,
	    \Vgroup\SafetyHubApp\Block\Adminhtml\Requisitions\Edit $requistion,
	    array $data = []
    ) {
	$this->helper = $helper;
	$this->_coreRegistry = $registry;
	$this->requisition = $requistion;
	parent::__construct($context, $registry, $formFactory, $data);
    }

   
    public function getRequisition() {
	$requisition = $this->_coreRegistry->registry('current_requisition');
	return $requisition;
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel() {
	return __('Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle() {
	return __('Information');
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
	return false;
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
