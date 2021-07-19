<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Users;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\AddressFactory;
use Vgroup\SafetyHubApp\Model\CustomerPermissionFactory;

class AssignAll extends \Magento\Backend\App\Action {

    protected $_filter;
    protected $_collectionFactory;
      protected $_safetyItemsUsers;
       protected $customerFactory;
 protected $customerPermissionFactory;
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
            \Vgroup\SafetyHubApp\Model\CustomerPermissionFactory $customerPermissionFactory,
               CustomerFactory $customerFactory,
        AddressFactory $addressFactory,
	    ProductRepositoryInterface $productRepository = null
    ) {
	$this->_filter = $filter;
	$this->_collectionFactory = $collectionFactory;
             $this->_safetyItemsUsers = $safetyItemsUsers;
               $this->customerFactory  = $customerFactory;
                 $this->customerPermissionFactory = $customerPermissionFactory;
        $this->addressFactory   = $addressFactory;
	$this->productRepository = $productRepository ?: \Magento\Framework\App\ObjectManager::getInstance()->create(ProductRepositoryInterface::class);
	parent::__construct($context);
    }

    public function execute() {
		
	try {
            $post = (array) $this->getRequest()->getPost();
//            print_r($post['selected']);
//            exit;
            $customer = $this->customerPermissionFactory->create();
            foreach($post['selected'] as $val)
            {
                $customer->load($val, "customer_id");
                $customer->addData(["permission_type" => 2]);
                $customer->save();
            } 

	    $this->messageManager->addSuccess(__('Assign permission Successfully.'));
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
