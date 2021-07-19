<?php

namespace Vgroup\SafetyHubApp\Plugin;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Customer\Api\Data\CustomerExtensionFactory;
use Vgroup\SafetyHubApp\Api\Data\ResultInterfaceFactory;
use Vgroup\SafetyHubApp\Api\Data\UserGuideInterfaceFactory;
use Vgroup\SafetyHubApp\Api\CompanyRepositoryInterface;
use Vgroup\SafetyHubApp\Api\SafetyItemsRepositoryInterface;
use Vgroup\SafetyHubApp\Api\SafetyUsersItemsRepositoryInterface;
use Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory;
use Magento\Framework\Registry;
use Magento\Framework\Exception\LocalizedException;
use Vgroup\SafetyHubApp\Model\CompaniesRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Vgroup\SafetyHubApp\Helper\Data;
use Magento\Framework\Webapi\Rest\Request;


class CustomerRepository
{

    /**
     * @var \Vgroup\SafetyHubApp\Api\CompanyRepositoryInterface
     */
    protected $companyRepository;

    /**
     * @var \Magento\Customer\Api\Data\CustomerExtensionFactory
     */
    protected $customerExtensionFactory;
    /**
     * @var Request
     */
    protected $request;
    /**
     * Init plugin
     *
     * @param \Vgroup\SafetyHubApp\Api\CompanyRepositoryInterface $companyRepository
     * @param \Vgroup\SafetyHubApp\Api\Data\ResultInterfaceFactory $resultFactory     
     * @param \Vgroup\SafetyHubApp\Api\Data\UserGuideInterfaceFactory $userGuideInterface,
     * @param \Magento\Customer\Api\Data\CustomerExtensionFactory $customerExtensionFactory
     * @param \Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory $safetyUserItemFactory; 
     */
    public function __construct(
        \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        SafetyItemsRepositoryInterface $safetyItemsRepository,
        CompanyRepositoryInterface $comapnyRepository,
        \Psr\Log\LoggerInterface $logger,
        SafetyUsersItemsFactory $safetyUserItemFactory,
        ResultInterfaceFactory $resultFactory,
        UserGuideInterfaceFactory $userGuideInterface,
        CustomerExtensionFactory $customerExtensionFactory,
        SafetyUsersItemsRepositoryInterface $safetyItemsUsersRepository,
        SearchCriteriaInterface $searchCriteria,
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Model\Session $customerSession,
        CompaniesRepository $companyRepository,
        Data $helper,
        Request $request
    ) {
        $this->companyRepository = $comapnyRepository;
        $this->_resultRepository = $resultFactory;
        $this->_userGuideRepo = $userGuideInterface;
        $this->customerExtensionFactory = $customerExtensionFactory;
        $this->safetyUsersItemsFactory = $safetyUserItemFactory;
        $this->_safetyItemsUsersRepository = $safetyItemsUsersRepository;
        $this->_searchCriteria = $searchCriteria;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->_registry = $registry;
        $this->_logger = $logger;
        $this->_customerSession = $customerSession;
        $this->safetyItemRepository = $safetyItemsRepository;
        $this->helper = $helper;
        $this->request = $request;
    }

    /**
     * Get Company
     *
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $subject
     * @param \Magento\Customer\Api\Data\CustomerInterface $resultOrder
     * @return \Magento\Customer\Api\Data\CustomerInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetById(CustomerRepositoryInterface $subject, CustomerInterface $resultCustomer)
    {
        $resultCustomer = $this->getCustomerData($resultCustomer);
        return $resultCustomer;
    }

    /**
     * Get Data
     *
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @return \Magento\Customer\Api\Data\CustomerInterface 
     */
    protected function getCustomerData(\Magento\Customer\Api\Data\CustomerInterface $customer)
    {

        try {
            $resultRepo = $this->_resultRepository->create();
            /* Set user guide */
            $guide = $this->_userGuideRepo->create();
            $guide->setVersion('1.2.0');
            $guide->setUrl('http://www.firstaidonly.com/fao/FAO-First-Aid-Manual.pdf');
            $resultRepo->setUserGuide($guide);
            /* Set user company */
            $companyId = 0;
            if ($customer->getCustomAttribute('company_id'))
                $companyId = $customer->getCustomAttribute('company_id')->getValue();

            $company = $this->companyRepository->getById($companyId);
            $resultRepo->setCompany($company);
            /* Set Company Labels */
            $companyLabels = $this->companyRepository->getLabels($this->_searchCriteria, $companyId);
            $resultRepo->setCompanyLabels($companyLabels);
            /** @var \Magento\Customer\Api\Data\CustomerExtension $orderExtension */
            $extensionAttributes = $customer->getExtensionAttributes();
            $customerExtension = $extensionAttributes ? $extensionAttributes : $this->customerExtensionFactory->create();
            $customerExtension->setResponse($resultRepo);
            $customerExtension->setIsProfileComplete(TRUE);
            $customer->setExtensionAttributes($customerExtension);
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(
                __('Customer does not exist', $e->getMessage()),
                $e
            );
        }
        return $customer;
    }

    /**
     * Plugin after create customer that updates safetyUserItems.
     *
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $customer
     * @return CustomerInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeSave(CustomerRepositoryInterface $subject, CustomerInterface $customer)
    {

        $extensionAttributes = $customer->getExtensionAttributes();
        $customerExtension = $extensionAttributes ? $extensionAttributes : $this->customerExtensionFactory->create();
        $safetyUserItems = $customerExtension->getSafetyUsersItems();
        try {
            $companyId = 0;
            if ($customer->getCustomAttribute('safetyhubapp_access_code')) {
                $companyAccessCode = $customer->getCustomAttribute('safetyhubapp_access_code')->getValue();
                if (!empty(trim($companyAccessCode))) {
                    $result = $this->companyRepository->getByCode($companyAccessCode);
                    if (!$result)
                        throw new \Exception(__("Invalid Company Group Code - please contact your administrator or register as a standard user."));
                    $companyId = $result->getId();
                }
                $customer->setCustomAttribute('company_id', $companyId);
            }
            // Validate Model Number: 
            if (!empty($safetyUserItems)) {
                $model = $safetyUserItems->getModelNumber();
                $type = $safetyUserItems->getType();
                if (!empty(trim($model))) {
                    $result = $this->safetyItemRepository->getByModelNumber($model, $type);
                    if (!$result) :
                        throw new \Exception(__('Safety Item Model Number does not exist.'));
                    else :
                        $safetyUserItems->setSafetyitemId($result->getId());
                    endif;
                }
            }
        } catch (\Exception $e) {
            throw new NoSuchEntityException(__($e->getMessage()));
        }
    }

    /**
     * Plugin after create customer that updates safetyUserItems.
     *
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $customer
     * @return CustomerInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterSave(CustomerRepositoryInterface $subject, CustomerInterface $result, CustomerInterface $entity)
    {


        $bodyParams = $this->request->getBodyParams();
        //echo "<pre>";
        //print_r($bodyParams);
        $extensionAttributes = $entity->getExtensionAttributes();
        $customerExtension = $extensionAttributes ? $extensionAttributes : $this->customerExtensionFactory->create();
        if ($customerExtension->getSafetyUsersItems() !== null) {
            $safetyUserItem = $customerExtension->getSafetyUsersItems();
            $safetyItemData = $this->extensibleDataObjectConverter->toNestedArray(
                $safetyUserItem,
                [],
                '\Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface'
            );
            if (!empty($safetyItemData)) :
                unset($safetyItemData['associated_products']);
                unset($safetyItemData['products_count']);
                $companyId = $result->getCustomAttribute('company_id')->getValue();
                $safetyItemData['physical_inventory_date'] = $this->helper->getDate("Y-m-d");
                $safetyItemData['show_physical_inventory_date'] = 1;
                $safetyItemData['customer_id'] = $result->getId();
                $safetyItemData['company_id'] = (!empty($companyId)) ? $companyId : 0;
                $safetyItemData['firstname'] = $result->getFirstname();
                $safetyItemData['lastname'] = $result->getLastname();
                $safetyItemData['email'] = $result->getEmail();
                foreach ($bodyParams['customer']['addresses'] as $address) {
                    $safetyItemData['company'] = $address['company'];
                    $safetyItemData['postcode'] = $address['postcode'];
                    $safetyItemData['telephone'] =  $address['telephone'];
                    $streets = $address['street'];
                    if (isset($streets[0])) {
                        $safetyItemData['street1'] =  $streets[0];
                    }
                    if (isset($streets[1])) {
                        $safetyItemData['street2'] =  $streets[1];
                    }
                    $safetyItemData['city'] =  $address['city'];
                    $safetyItemData['region_id'] =  (isset($address['region_id'])) ? $address['region_id'] : 0;
                    $safetyItemData['region'] = (isset($address['region']['region'])) ? $address['region']['region'] : "";
                    $safetyItemData['country_id'] = (isset($address['country_id'])) ? $address['country_id'] : "";
                }  
                $numberOfEmployees = $result->getCustomAttribute('number_of_employees')->getValue(); 
                $safetyItemData['number_of_employees'] = (!empty($numberOfEmployees)) ? $numberOfEmployees : 0;
                //echo "<pre>";
                //  var_dump($result->getAddresses());
                //print_r($safetyItemData);
                // exit;
                $safetyItemModel = $this->safetyUsersItemsFactory->create();
                $safetyItemModel->setData($safetyItemData);
                $safetyItemModel->save();
            endif;
        }


        $companyId = 0;
        if ($result->getCustomAttribute('company_id')) {
            $resultRepo = $this->_resultRepository->create();
            $companyId = $result->getCustomAttribute('company_id')->getValue();
            $company = $this->companyRepository->getById($companyId);
            $resultRepo->setCompany($company);
            $customerExtension->setAccessCode($customerExtension->getAccessCode());
            $customerExtension->setResponse($resultRepo);
        }
        $customerExtension->setIsProfileComplete(1);
        $result->setExtensionAttributes($customerExtension);
        return $result;
    }
}
