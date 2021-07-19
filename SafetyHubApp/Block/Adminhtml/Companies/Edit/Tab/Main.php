<?php

namespace Vgroup\SafetyHubApp\Block\Adminhtml\Companies\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface {

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $store;
    protected $itemtype;

    /**
     * @var \Vgroup\SafetyHubApp\Helper\Data $helper
     */
    protected $helper;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
	    \Magento\Backend\Block\Template\Context $context,
	    \Magento\Framework\Registry $registry,
	    \Magento\Framework\Data\FormFactory $formFactory,
	    \Vgroup\SafetyHubApp\Helper\Data $helper,
	    \Vgroup\SafetyHubApp\Model\Select\SafetyItemsTypes\Options $itemtype,
	    array $data = []
    ) {
	$this->helper = $helper;
	$this->itemtype = $itemtype;
	parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm() {
	/* @var $model \Vgroup\SafetyHubApp\Model\SafetyItems */
	$model = $this->_coreRegistry->registry('safetyhubapp_company');
//        print_r($model->getData());
//        exit;
	/** @var \Magento\Framework\Data\Form $form */
	$form = $this->_formFactory->create();

	$form->setHtmlIdPrefix('company_');
	$form->setFieldNameSuffix('company');
	$fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Company Details')]);

	if ($model->getId()) {
	    $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
	}

	$fieldset->addField(
		'name',
		'text',
		[
		    'name' => 'name',
		    'label' => __('Name'),
		    'title' => __('Name'),
		    'required' => true,
		]
	);

	$fieldset->addField(
		'phone',
		'text',
		[
		    'name' => 'phone',
		    'label' => __('Phone'),
		    'title' => __('Phone'),
		    'required' => true,
		]
	);

	$fieldset->addField(
		'email',
		'text',
		[
		    'name' => 'email',
		    'label' => __('Email'),
		    'title' => __('Email'),
		    'required' => true,
		]
	);
	$fieldset->addField(
		'company_requisition_email',
		'text',
		[
		    'name' => 'company_requisition_email',
		    'label' => __('Requisition Receipent Email'),
		    'title' => __('Requisition Receipent Email'),
		    'required' => true,
		]
	);
	$fieldset->addField(
		'url',
		'text',
		[
		    'name' => 'url',
		    'label' => __('Url'),
		    'title' => __('Url'),
		    'required' => true,
		]
	);

	$fieldset->addField(
		'hours',
		'text',
		[
		    'name' => 'hours',
		    'label' => __('Store Hours'),
		    'title' => __('Store Hours'),
		    'required' => true,
		]
	);


	$fieldset->addField(
		'codes',
		'text',
		[
		    'name' => 'codes',
		    'label' => __('Group Codes'),
		    'title' => __('Group Codes'),
		    'required' => true,
		    'note' => __('To add multiple codes use ","')
		]
	);


	$approvalModeField = $fieldset->addField(
		'approval_mode',
		'select',
		[
		    'name' => 'approval_mode',
		    'label' => __('Requition Approval Mode'),
		    'id' => 'approval_mode',
		    'title' => __('Requition Approval Mode'),
		    'class' => 'input-select',
		    'options' => [
			1 => __('Auto-approve Requisitions'),
			2 => __('Enable Requisition Approval')
		    ],
		    'required' => true
		]
	);

	$frequeancyOption = $fieldset->addField(
		'interval',
		'select',
		[
		    'name' => 'interval',
		    'label' => __('Mail Transfer Interval'),
		    'id' => 'mail_transfer',
		    'title' => __('Mail Transfer Interval'),
		    'class' => 'input-select',
		    'options' => [
			'0' => __('Immediately'),
			'1' => __('Daily'),
			'2' => __('Weekly')
		    ],
		]
	);

//	$fieldset->addField(
//		'permission_type',
//		'select',
//		[
//		    'name' => 'permission_type',
//		    'label' => __('Select Default User Permission'),
//		    'id' => 'permission_type',
//		    'title' => __('Select Default User Permission'),
//		    'class' => 'input-select',
//		    'options' => [
//			'0' => __('Select One'),
//			'1' => __('Specific Permissions'),
//			'2' => __('Admin Group'),
//			'3' => __('All Permissions')
//		    ],
//		]
//	);
//
//
//	$fieldset->addField(
//		'permissions',
//		'multiselect',
//		[
//		    'name' => 'permissions[]',
//		    'label' => __('Set Default User Permission'),
//		    'id' => 'user_permission',
//		    'title' => __('Set Default User Permission'),
//		    'class' => 'input-select',
//		    'values' => $this->getPermissions(),
//		]
//	);

	$fieldset->addField(
		'is_preferred_distributor',
		'select',
		[
		    'name' => 'is_preferred_distributor',
		    'label' => __('Set Preferred distributor'),
		    'id' => 'preferred_distributor',
		    'title' => __('Set Preferred distributor'),
		    'class' => 'input-select',
		    'options' => [
			'0' => __('Disable'),
			'1' => __('Enable')
		    ],
		]
	);

	$fieldset->addField(
		'preferred_distributors',
		'multiselect',
		[
		    'name' => 'preferred_distributors[]',
		    'label' => __('Preferred Distributors'),
		    'id' => 'preferred_distributors',
		    'title' => __('Preferred Distributors'),
		    'class' => 'input-select',
		    'values' => $this->getPreferredDistributors(),
		]
	);

	$fieldset->addField(
		'partnumber_preference',
		'select',
		[
		    'name' => 'partnumber_preference',
		    'label' => __('Part Number Reference'),
		    'id' => 'num_ref',
		    'title' => __('Part Number Reference'),
		    'class' => 'input-select',
		    'options' => [
			'2' => __('Show my part number in app, use my part numbers in requisitions'),
			'1' => __('Show FAO part number in app, use my part numbers in requisitions'),
			'3' => __('Show both part numbers in app, use my part numbers in requisitions')
		    ],
		]
	);

	$fieldset->addField(
		'restock_req_status',
		'select',
		[
		    'name' => 'restock_req_status',
		    'label' => __('Restock Against Requition'),
		    'id' => 'restock_req',
		    'title' => __('Restock Against Requition'),
		    'class' => 'input-select',
		    'options' => [
			2 => __('Disable'),
			1 => __('Enable')
		    ],
		]
	);
	$fieldset->addField(
		'status',
		'select',
		[
		    'name' => 'status',
		    'label' => __('Status'),
		    'id' => 'status',
		    'title' => __('Status'),
		    'class' => 'input-select',
		    'options' => [
			1 => __('Active'),
			0 => __('Inactive')
		    ],
		]
	);

	$this->setChild(
		'form_after',
		$this->getLayout()->createBlock('\Magento\Backend\Block\Widget\Form\Element\Dependence')
			->addFieldMap('company_approval_mode', 'approval_mode')
			->addFieldMap('company_interval', 'interval')
			->addFieldMap('company_is_preferred_distributor', 'is_preferred_distributor')
			->addFieldMap('company_preferred_distributors', 'preferred_distributors')
			->addFieldDependence('interval', 'approval_mode', 2)
			->addFieldDependence('preferred_distributors', 'is_preferred_distributor', 1)
	);

	$form->setValues($model->getData());
	$this->setForm($form);

	return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel() {
	return __('General');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle() {
	return __('General');
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

    public function getPermissions() {

	$permissions = [
	    ['label' => __('Manage Requisitions'), 'value' => 1],
	    ['label' => __('Manage Safety Items'), 'value' => 2],
	    ['label' => __('Manage Staff'), 'value' => 3],
	    ['label' => __('Reports Requisition Reports'), 'value' => 4],
	    ['label' => __('Requisition Reports'), 'value' => 41],
	    ['label' => __('Physical Inventory Check Reports'), 'value' => 42],
	    ['label' => __('Personalization'), 'value' => 5],
	    ['label' => __('Manage Company Labels'), 'value' => 51],
	    ['label' => __('Welcome Email Template'), 'value' => 52],
	    ['label' => __('Requisition Approval'), 'value' => 10],
	];

	return $permissions;
    }

    public function getPreferredDistributors() {
	$distributors = [
	    ['label' => __('Amazon'), 'value' => 1]
	];

	return $distributors;
    }

}
