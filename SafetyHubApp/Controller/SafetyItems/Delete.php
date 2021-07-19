<?php

namespace Vgroup\SafetyHubApp\Controller\SafetyItems;

class Delete extends \Magento\Framework\App\Action\Action {

    protected $_pageFactory;
    protected $_request;
    protected $_safetyItemsUsersFactory;

    public function __construct(
	    \Magento\Framework\App\Action\Context $context,
	    \Magento\Framework\View\Result\PageFactory $pageFactory,
	    \Magento\Framework\App\Request\Http $request,
	    \Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory $safetyItemsUsersFactory,
	    \Magento\Framework\Controller\ResultFactory $result
    ) {
	$this->_pageFactory = $pageFactory;
	$this->_request = $request;
	$this->_safetyItemsUsersFactory = $safetyItemsUsersFactory;
	$this->resultRedirect = $result;
	return parent::__construct($context);
    }

    public function execute() {

	$id = $this->_request->getParam('entity_id', false);
	$post = $this->_safetyItemsUsersFactory->create();


	try {
	    $result = $post->setId($id);
	    $result = $result->delete();

	    $this->messageManager->addSuccess(__('SafetyItem is deleted successfully !'));
	} catch (\Exception $e) {
	    $this->messageManager->addError($e->getMessage());
	}
	return $this->_redirect('safetyhubapp/account/safetyitems');
    }

}
