<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Companies;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Vgroup\SafetyHubApp\Model\CompaniesFactory;

class Edit extends \Magento\Backend\App\Action {

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Vgroup\SafetyHubApp\Model\CompaniesFactory
     */
    protected $_companiesFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
	    Context $context,
	    \Magento\Framework\View\Result\PageFactory $resultPageFactory,
	    \Magento\Framework\Registry $registry,
	    CompaniesFactory $companies
    ) {
	$this->resultPageFactory = $resultPageFactory;
	$this->_coreRegistry = $registry;
	$this->_companiesFactory = $companies;
	parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    /* protected function _isAllowed()
      {
      return $this->_authorization->isAllowed('safety_item::attachment_save');
      } */

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction() {
	// load layout, set active menu and breadcrumbs
	/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
	$resultPage = $this->resultPageFactory->create();
	return $resultPage;
    }

    /**
     * Edit Safetyitems
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute() {
	$id = $this->getRequest()->getParam('entity_id');
	$model = $this->_companiesFactory->create();

	if ($id) {
	    $model->load($id);
	    if (!$model->getId()) {
		$this->messageManager->addError(__('This item no longer exists.'));
		/** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
		$resultRedirect = $this->resultRedirectFactory->create();

		return $resultRedirect->setPath('*/*/');
	    }
	}

	$data = $this->_session->getFormData(true);
	if (!empty($data)) {
	    $model->setData($data);
	}

	$this->_coreRegistry->register('safetyhubapp_company', $model);

	/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
	$resultPage = $this->_initAction();
	$resultPage->addBreadcrumb(
		$id ? __('Edit Company') : __('New Company'),
		$id ? __('Edit Company') : __('New Company')
	);
	$resultPage->getConfig()->getTitle()->prepend(__('Add Group Code'));
	$resultPage->getConfig()->getTitle()
		->prepend($model->getId() ? $model->getName() : __('Add Group Code'));

	return $resultPage;
    }

}
