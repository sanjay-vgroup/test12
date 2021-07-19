<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Requisitions;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\NoSuchEntityException;

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
     * @var  \Vgroup\SafetyHubApp\Model\Requisitions $requisition
     */
    protected $requisition;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
	    Action\Context $context,
	    \Magento\Framework\View\Result\PageFactory $resultPageFactory,
	    \Vgroup\SafetyHubApp\Model\RequisitionsFactory $requisitionFactory,
	    \Magento\Framework\Registry $registry
    ) {
	$this->resultPageFactory = $resultPageFactory;
	$this->_coreRegistry = $registry;
	$this->requisitionFactory = $requisitionFactory;
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
     * Edit Requisition
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute() {

	try {
	    $id = $this->getRequest()->getParam('entity_id');
	    $model = $this->requisitionFactory->create();

	    if ($id) {

		$model->load($id);
		if (!$model->getId()) {
		    $this->messageManager->addError(__('This requisition no longer exists.'));
		    /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
		    $resultRedirect = $this->resultRedirectFactory->create();

		    return $resultRedirect->setPath('*/*/');
		}
	    }

	    $this->_coreRegistry->register('current_requisition', $model);
	    $this->_coreRegistry->register('current_requisition_safetyitem', $model->getRequisitionUserSafetyItem($model, ['type', 'model_number', 'serial_number', 'nickname']));
	    $this->_coreRegistry->register('current_requisition_items', $model->getRequisitionItems($model, ['sku', 'name', 'qty', 'price']));

	    /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
	    $resultPage = $this->_initAction();
	    $resultPage->getConfig()->getTitle()->prepend(__('Requisition'));
	    $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Requisition# %1', $model->getId()) : __('Requisition'));

	    return $resultPage;
	} catch (NoSuchEntityException $e) {
	    $this->messageManager->addException($e, __('Something went wrong while view the requistion.' . $e->getMessage()));
	    $resultRedirect = $this->resultRedirectFactory->create();
	    $resultRedirect->setPath('*/*/index');
	    return $resultRedirect;
	} catch (Exception $e) {
	    $this->messageManager->addError($e->getMessage());
	    $resultRedirect = $this->resultRedirectFactory->create();
	    return $resultRedirect->setPath('*/*/index'); //Redirect Path
	}
    }

}
