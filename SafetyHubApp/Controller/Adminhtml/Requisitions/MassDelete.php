<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Requisitions;

class MassDelete extends \Magento\Backend\App\Action {

    protected $_filter;
    protected $_collectionFactory;

    public function __construct(
	    \Magento\Ui\Component\MassAction\Filter $filter,
	    \Vgroup\SafetyHubApp\Model\ResourceModel\Requisitions\CollectionFactory $collectionFactory,
	    \Magento\Backend\App\Action\Context $context
    ) {
	$this->_filter = $filter;
	$this->_collectionFactory = $collectionFactory;
	parent::__construct($context);
    }

    public function execute() {
	try {

	    $logCollection = $this->_filter->getCollection($this->_collectionFactory->create());
	    $itemDeleted = 0;
	    foreach ($logCollection->getItems() as $item) {
		$item->delete();
		$itemDeleted++;
	    }
	    $this->messageManager->addSuccess(__('Item Deleted Successfully.'));
	} catch (Exception $e) {
	    $this->messageManager->addError($e->getMessage());
	}
	$resultRedirect = $this->resultRedirectFactory->create();
	return $resultRedirect->setPath('*/*/index'); //Redirect Path
    }

    /**
     * is action allowed
     *
     * @return bool
     */
    protected function _isAllowed() {
	return $this->_authorization->isAllowed('Vgroup_SafetyHubApp::view');
    }

}
