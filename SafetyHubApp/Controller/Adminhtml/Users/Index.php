<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Users;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;


class Index extends \Magento\Backend\App\Action {

    /**
     * @var \Vgroup\SafetyHubApp\Model\ResourceModel\Companies\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory = false;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
	    Context $context,
	  
	    \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
	parent::__construct($context);
	
	$this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute() {

	$resultPage = $this->resultPageFactory->create();
	$resultPage->getConfig()->getTitle()->prepend((__('Manage Users')));
//	$collection = $this->collectionFactory->create()->addFieldToSelect('name')->addFieldToFilter('status', 1);
//	echo "---".$collection->getSelect();
	return $resultPage;
    }

    /**
     * Is the user allowed to view the attachment grid.
     *
     * @return bool
     */
    /* protected function _isAllowed()
      {
      return $this->_authorization->isAllowed('Vgroup_SafetyHubApp::safetyitems');
      } */
}
