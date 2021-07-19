<?php

namespace Vgroup\SafetyHubApp\Block\Adminhtml\Users\Edit\Tab;

use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\AddressFactory;
use Vgroup\SafetyHubApp\Model\CompaniesFactory;
use Vgroup\SafetyHubApp\Model\CompanyFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Vgroup\SafetyHubApp\Model\CustomerPermissionFactory;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface {

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $store;
    protected $itemtype;
    protected $_contactCollectionFactory;
    protected $customerFactory;
    protected $customerPermissionFactory;

    /**
     * @var \Vgroup\SafetyHubApp\Model\CompaniesFactory
      /**
     * @var \Vgroup\SafetyHubApp\Helper\Data $helper
     */
    protected $helper;
    protected $addressFactory;
    protected $_safetyItemsUsers;
    protected $_companiesFactory;
    protected $_companyFactory;
    protected $_template = 'Vgroup_SafetyHubApp::users/user.phtml';

    /**

     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
    \Magento\Backend\Block\Template\Context $context, CompaniesFactory $companies, \Magento\Framework\Registry $registry,
            \Magento\Framework\Data\FormFactory $formFactory, 
            \Vgroup\SafetyHubApp\Helper\Data $helper, \Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory $safetyItemsUsers,
            \Vgroup\SafetyHubApp\Model\CustomerPermissionFactory $customerPermissionFactory, \Magento\Customer\Model\CustomerFactory $customerFactory, 
            \Vgroup\SafetyHubApp\Model\ResourceModel\Companies\CollectionFactory $contactCollectionFactory, AddressFactory $addressFactory, CompanyFactory $company, CustomerRepositoryInterface $customerRepository, \Vgroup\SafetyHubApp\Model\Select\SafetyItemsTypes\Options $itemtype, array $data = []
    ) {
        $this->helper = $helper;
        $this->itemtype = $itemtype;
        $this->_contactCollectionFactory = $contactCollectionFactory;
        $this->customerFactory = $customerFactory;
        $this->_safetyItemsUsers = $safetyItemsUsers;
        $this->addressFactory = $addressFactory;
        $this->_companiesFactory = $companies;
        $this->_companyFactory = $company;
        $this->customerRepository = $customerRepository;
        $this->customerPermissionFactory = $customerPermissionFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm() {
        $id = $this->getRequest()->getParam('entity_id');
        // $company = $th {
        // $id = $this->getRequest()->gis->_companiesFactory->create();
        // $model = $company->load(1);
        /* @var $model \Vgroup\SafetyHubApp\Model\SafetyItems */
        $model = $this->_coreRegistry->registry('safetyhubapp_company');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('company_');
        $form->setFieldNameSuffix('company');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Users Information')]);

        if ($id) {
            $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
            $form->setValues($model->getData());
        }
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel() {
        return __('General');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle() {
        return __('General');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab() {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden() {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId) {
        return $this->_authorization->isAllowed($resourceId);
    }

    public function getStates() {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $states = $objectManager->create('Magento\Directory\Model\RegionFactory')
                        ->create()->getCollection()->addFieldToFilter('country_id', 'US');
        return $states->getData();
    }

    public function getUserData() {
        
        $id = $this->getRequest()->getParam('id');
        if(!empty($id))
        {
        $model = $this->customerFactory->create();
        $model->load($id);
        return $model->getData();
        
        }
        else{
            return[];
        }
    }

    public function getUserAddressData() {
        $id = $this->getRequest()->getParam('id');
        if(!empty($id))
        {
        

        $customer = $this->customerFactory->create();
        $customer->load($id);

        $shippingAddressId = $customer->getDefaultShipping();
        $shippingAddress = $this->addressFactory->create()->load($shippingAddressId);

        return $shippingAddress->getData();
        }
        else{
            return[];
        }
    }

    public function getUserItemData() {
        $id = $this->getRequest()->getParam('id');
        if(!empty($id))
        {
        $userItemData = [];
        $customer = $this->customerRepository->getById($id);
        $userItemData['company_id'] = !empty($customer->getCustomAttribute('company_id')) ? $customer->getCustomAttribute('company_id')->getValue() : 0;
        $userItemData['requisition_email_address'] = !empty($customer->getCustomAttribute('requisition_email_address')) ? $customer->getCustomAttribute('requisition_email_address')->getValue() : '';
        $userItemData['number_of_employees'] = !empty($customer->getCustomAttribute('number_of_emplyees')) ? $customer->getCustomAttribute('number_of_emplyees')->getValue() : '';
        $userItemData['job_title'] = !empty($customer->getCustomAttribute('job_title')) ? $customer->getCustomAttribute('job_title')->getValue() : '';
        return $userItemData;
        }
        else{
            return[];
        }
    }

    public function getUserItemDataOLD() {
        $id = $this->getRequest()->getParam('id');
        $userItemData = [];
        $model = $this->_safetyItemsUsers->create();
        $model->load($id, 'customer_id');
        $userItemData = $model->getData();
        $companyId = $userItemData && isset($userItemData['company_id']) && $userItemData['company_id'] ? $userItemData['company_id'] : '';
        $companyData = [];
        $company = $this->_companyFactory->create();
        $company->load($companyId, 'entity_id');
        $companyData = $company->getData();

        return array_merge($userItemData, $companyData);
    }

    public function getCompanies() {

        $company = $this->_companiesFactory->create();
//	$getItems = $getSafetyItems->getCollection();
//	$select = $getItems->addFieldToSelect('model_number');
        $data = $company->getCollection()->getData();
//        print_r($data);
//        exit;
        return $data;
    }

    public function getCustomerPermission() {
//
        $id = $this->getRequest()->getParam('id');
        if(!empty($id))
        {
            $collection = $this->customerPermissionFactory->create();
            //$data = $collection->getCollection()->getData();
            $collection->load($id, 'customer_id');
            return $collection->getData();
        }
        else 
        {
            return [];   
        }    
    }

//    public function getCompanyData($company_id) {
//        $id = $this->getRequest()->getParam('id');
//        $company = $this->_companyFactory->create();
//        $company->load($company_id, 'entity_id');
//        return $company->getData();
//    }
}
