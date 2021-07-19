<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action {

    /**
     * @var PageFactory
     */
    protected $resultPageFactory = false;
        protected $_requisitionFactory;
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
	    Context $context,
		 \Vgroup\SafetyHubApp\Model\RequisitionsFactory $requisitionFactory,
	    \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
	parent::__construct($context);
	$this->resultPageFactory = $resultPageFactory;
	$this->_requisitionFactory = $requisitionFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute() {
	
	$resultPage = $this->resultPageFactory->create();
	$resultPage->getConfig()->getTitle()->prepend((__('Dashboard')));
	$model   = $this->_requisitionFactory->create();
	$collection = $model->getCollection();

	
    // print_r($collection->getData()); exit;
	return $resultPage;
    }

    /**
     * Is the user allowed to view the attachment grid.
     *
     * @return bool
     */
    protected function _isAllowed()
      {
      return $this->_authorization->isAllowed('Vgroup_Dashboard::dashboard');
      } 
}
