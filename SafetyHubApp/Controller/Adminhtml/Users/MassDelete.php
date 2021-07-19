<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Users;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\AddressFactory;

class MassDelete extends \Magento\Backend\App\Action {

    protected $_filter;
    protected $_collectionFactory;
      protected $_safetyItemsUsers;
       protected $customerFactory;

    /**
     * @var \Magento\Customer\Model\AddressFactory
     */
    protected $addressFactory;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(
	    \Magento\Ui\Component\MassAction\Filter $filter,
	    \Vgroup\SafetyHubApp\Model\ResourceModel\SafetyUsersItems\CollectionFactory $collectionFactory,
            \Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory $safetyItemsUsers,
	    \Magento\Backend\App\Action\Context $context,
               CustomerFactory $customerFactory,
        AddressFactory $addressFactory,
	    ProductRepositoryInterface $productRepository = null
    ) {
	$this->_filter = $filter;
	$this->_collectionFactory = $collectionFactory;
             $this->_safetyItemsUsers = $safetyItemsUsers;
               $this->customerFactory  = $customerFactory;
        $this->addressFactory   = $addressFactory;
	$this->productRepository = $productRepository ?: \Magento\Framework\App\ObjectManager::getInstance()->create(ProductRepositoryInterface::class);
	parent::__construct($context);
    }

    public function execute() {
		
	try {
            $post = (array) $this->getRequest()->getPost();
            
            $customer = $this->customerFactory->create();
            foreach($post['selected'] as $val)
            {
                $customer->load($val);
                $customer->delete();
            }

//	    $logCollection = $this->_filter->getCollection($this->_collectionFactory->create());
//	    $itemDeleted = 0;
//	    foreach ($logCollection->getItems() as $item) {
//
// 
//		$item->delete();
//		$itemDeleted++;
//	    }
	    $this->messageManager->addSuccess(__('Item Deleted Successfully.'));
	} catch (Exception $e) {
	    $this->messageManager->addError($e->getMessage());
	}
	$resultRedirect = $this->resultRedirectFactory->create();
	return $resultRedirect->setPath('safetyhubapp/users/index'); //Redirect Path
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
