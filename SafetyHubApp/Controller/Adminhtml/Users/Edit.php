<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Users;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Customer\Model\CustomerFactory;

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
    protected $customerFactory;
    protected $_safetyItemsUsers;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
    Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Registry $registry, CustomerFactory $customerFactory, \Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory $safetyItemsUsers
    ) {

        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->_safetyItemsUsers = $safetyItemsUsers;

        $this->customerFactory = $customerFactory;
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

        $model = $this->customerFactory->create();

        if ($id) {
            $model->load($id);
            //	$entityId = $model->getEntityId();

            if (!$id) {
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
                $id ? __('Edit Users') : __('New Users'), $id ? __('Edit Users') : __('New Users')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Users'));
        $resultPage->getConfig()->getTitle()
                ->prepend($model->getId() ? $model->getName() : __('Manage Users'));

        return $resultPage;
    }

}
