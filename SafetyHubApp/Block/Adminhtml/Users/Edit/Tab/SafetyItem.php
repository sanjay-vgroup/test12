<?php

namespace Vgroup\SafetyHubApp\Block\Adminhtml\Users\Edit\Tab;

use Magento\Customer\Model\AddressFactory;

class SafetyItem extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface {

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $store;
    protected $itemtype;
    protected $_contactCollectionFactory;
    protected $customerFactory;

    /**
     * @var \Vgroup\SafetyHubApp\Model\CompaniesFactory
      /**
     * @var \Vgroup\SafetyHubApp\Helper\Data $helper
     */
    protected $helper;
    protected $_safetyUsersItemsFactory;
    protected $addressFactory;
    protected $_template = 'Vgroup_SafetyHubApp::users/safetyitem.phtml';

    /**

     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
    \Magento\Backend\Block\Template\Context $context, 
     \Magento\Framework\Registry $registry, 
      \Magento\Framework\Data\FormFactory $formFactory,
     \Vgroup\SafetyHubApp\Helper\Data $helper,
      \Magento\Customer\Model\CustomerFactory $customerFactory,
       \Vgroup\SafetyHubApp\Model\ResourceModel\Companies\CollectionFactory $contactCollectionFactory,
         AddressFactory $addressFactory,
         \Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory $safetyUsersItemsFactory,
         \Vgroup\SafetyHubApp\Model\Select\SafetyItemsTypes\Options $itemtype, array $data = []
    ) {

        $this->helper = $helper;
        $this->itemtype = $itemtype;
        $this->_contactCollectionFactory = $contactCollectionFactory;
        $this->customerFactory = $customerFactory;
        $this->addressFactory = $addressFactory;
        $this->__safetyUsersItemsFactory = $safetyUsersItemsFactory;

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
        // $company = $this->_companiesFactory->create();
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
        return __('SafetyItem Information');
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
        $id = $this->getRequest()->getParam('entity_id');
        $model = $this->customerFactory->create();
        $model->load($id);


        // $billingAddressId = $customer->getDefaultBilling(); $billingAddress = $this->_addressFactory->create()->load($billingAddressId);
        // print_r($model->getData());
        // exit;
        return $model->getData();
    }

    public function getUserAddData() {
        $id = $this->getRequest()->getParam('entity_id');
        $customer = $this->customerFactory->create();
        $customer->load($id);

        $billingAddressId = $customer->getDefaultBilling();
        $billingAddress = $this->addressFactory->create()->load($billingAddressId);


        // print_r($model->getData());
        // exit;


        return $billingAddress;
    }

    public function getEditRecords() {

        $id = $this->getRequest()->getParam('entity_id');
        // $id = $this->_request->getParam('id');        
        $post = $this->__safetyUsersItemsFactory->create();
        $result = $post->load($id);
        return $result;
    }
    public function getCabinetModel() {
        $id = $this->getRequest()->getParam('entity_id');   
        $post   = $this->__safetyUsersItemsFactory->create();
        $result = $post->load('1','type')->getCollection()->addFieldToSelect('model_number')->distinct(true);
        return $result->getData();
    }

}
