<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Companies;

use Vgroup\SafetyHubApp\Model\ResourceModel\Companies\PartNumbers\CollectionFactory;

class MassPartNumbersDelete extends \Magento\Backend\App\Action {

    protected $_filter;
    protected $_collectionFactory;

    public function __construct(
	    \Magento\Ui\Component\MassAction\Filter $filter,
	    CollectionFactory $collectionFactory,
	    \Magento\Backend\App\Action\Context $context
    ) {
	$this->_filter = $filter;
	$this->_collectionFactory = $collectionFactory;
	parent::__construct($context);
    }

    public function execute() {

	try {

	    $collection = $this->_collectionFactory->create();
	    $collection->addFieldToFilter("value_id", ['in' => $data = $this->getRequest()->getPostValue('value_id')]);
	    $itemDeleted = 0;
	    foreach ($collection as $item) {
		$item->delete();
		$itemDeleted++;
	    }
	    $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $itemDeleted));
	} catch (Exception $e) {
	    $this->messageManager->addError($e->getMessage());
	}
	$resultRedirect = $this->resultRedirectFactory->create();
	return $resultRedirect->setPath('*/*/edit', array('entity_id' => $this->getRequest()->getParam('entity_id'), 'active_tab' => 'comapnies_partnumbers')); //Redirect Path
    }

    /**
     * is action allowed
     *
     * @return bool
     */
//    protected function _isAllowed() {
//	return $this->_authorization->isAllowed('Vgroup_SafetyHubApp::view');
//    }
}
