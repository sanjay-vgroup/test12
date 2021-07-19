<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\SafetyItems;

use Magento\Catalog\Api\ProductRepositoryInterface;

class MassDelete extends \Magento\Backend\App\Action {

    protected $_filter;
    protected $_collectionFactory;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(
	    \Magento\Ui\Component\MassAction\Filter $filter,
	    \Vgroup\SafetyHubApp\Model\ResourceModel\SafetyItems\CollectionFactory $collectionFactory,
	    \Magento\Backend\App\Action\Context $context,
	    ProductRepositoryInterface $productRepository = null
    ) {
	$this->_filter = $filter;
	$this->_collectionFactory = $collectionFactory;
	$this->productRepository = $productRepository ?: \Magento\Framework\App\ObjectManager::getInstance()->create(ProductRepositoryInterface::class);
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
	return $resultRedirect->setPath('safetyhubapp/safetyitems/index'); //Redirect Path
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
