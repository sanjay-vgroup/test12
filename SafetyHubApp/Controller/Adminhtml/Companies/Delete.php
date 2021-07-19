<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Companies;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;
use Vgroup\SafetyHubApp\Model\CompaniesFactory;

class Delete extends \Magento\Backend\App\Action {

    /**
     * @var \Vgroup\SafetyHubApp\Model\CompaniesFactory
     */
    protected $_companiesFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
	    Context $context,
	    \Magento\Framework\View\Result\PageFactory $resultPageFactory,
	    CompaniesFactory $companies
    ) {
	parent::__construct($context);
	$this->resultPageFactory = $resultPageFactory;
	$this->_companiesFactory = $companies;
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute() {
	$id = $this->getRequest()->getParam('entity_id');
	/** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
	$resultRedirect = $this->resultRedirectFactory->create();
	if ($id) {
	    try {
		$this->_companiesFactory->create()->load($id)->delete();
		$this->messageManager->addSuccess(__('The company has been deleted.'));
		return $resultRedirect->setPath('*/*/');
	    } catch (\Exception $e) {
		$this->messageManager->addError($e->getMessage());
		return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
	    }
	}
	$this->messageManager->addError(__('We can\'t find a company to delete.'));
	return $resultRedirect->setPath('*/*/');
    }

}
