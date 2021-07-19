<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Users;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\AddressFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Escaper;
use Magento\Framework\UrlFactory;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Registration;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\App\ObjectManager;
use Vgroup\SafetyHubApp\Model\CompanyFactory;
use Vgroup\SafetyHubApp\Model\CustomerPermissionFactory;

class Save extends \Magento\Backend\App\Action {

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var \Magento\Customer\Model\AddressFactory
     */
    protected $addressFactory;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magento\Framework\Escaper
     */
    protected $escaper;

    /**
     * @var \Magento\Framework\UrlFactory
     */
    protected $urlFactory;
    protected $_safetyItemsUsers;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $session;

    /**
     * @var Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;
    protected $_companyFactory;
    protected $customerPermissionFactory;

    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param CustomerFactory $customerFactory
     * @param AddressFactory $addressFactory
     * @param ManagerInterface $messageManager
     * @param Escaper $escaper
     * @param UrlFactory $urlFactory
     * @param Session $session
     * @param Validator $formKeyValidator
     */
    public function __construct(
    Context $context, StoreManagerInterface $storeManager, CustomerFactory $customerFactory, 
            AddressFactory $addressFactory, ManagerInterface $messageManager, \Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory $safetyItemsUsers, \Vgroup\SafetyHubApp\Model\CustomerPermissionFactory $customerPermissionFactory, Escaper $escaper, UrlFactory $urlFactory, Session $session, CompanyFactory $company, Validator $formKeyValidator = null
    ) {
        $this->storeManager = $storeManager;
        $this->customerFactory = $customerFactory;
        $this->addressFactory = $addressFactory;
        $this->messageManager = $messageManager;
        $this->escaper = $escaper;
        $this->_safetyItemsUsers = $safetyItemsUsers;
        $this->urlModel = $urlFactory->create();
        $this->_companyFactory = $company;
        $this->customerPermissionFactory = $customerPermissionFactory;
        $this->session = $session;
        $this->formKeyValidator = $formKeyValidator ?: ObjectManager::getInstance()->get(Validator::class);

        // messageManager can also be set via $context
        // $this->messageManager   = $context->getMessageManager();

        parent::__construct($context);
    }

    /**
     * Default customer account page
     *
     * @return void
     */
    public function execute() {
        $resultRedirect = $this->resultRedirectFactory->create();

        // check if the form is actually posted and has the proper form key
        if (!$this->getRequest()->isPost() || !$this->formKeyValidator->validate($this->getRequest())) {
            $url = $this->urlModel->getUrl('*/*/save', ['_secure' => true]);
            $resultRedirect->setUrl($this->_redirect->error($url));
            return $resultRedirect;
        }

        $post = (array) $this->getRequest()->getPost();
//        print_r($post);
//        exit;
        $websiteId = $this->storeManager->getWebsite()->getWebsiteId();
//echo $websiteId;
//        $modeluseritem = $this->_safetyItemsUsers->create();
//        $modeluseritem->load('36955','customer_id');
//        print_r($modeluseritem->getData());
//        exit;

        $firstName = $post['firstname'];
        $lastName = $post['lastname'];
        $email = $post['user_email'];
        $password = $post['password'];
        $regionId = $post['region_id'];
        $region = $post['region'];
        $city = $post['cityname'];
        $zipcode = $post['zipcode'];
        $street = $post['street'];
        $street2 = $post['add2'];
        $telephone = $post['telephone'];
        $company = isset($post['company']) ? $post['company'] : '';
        $companyName = $post['company_name'];

        $entityId = '';
        // instantiate customer object
        $customer = $this->customerFactory->create();
        if (isset($post['entity_id']) && $post['entity_id'] != '') {
            $customer->load($post['entity_id']);
            $entityId = $post['entity_id'];
        }

        $customer->setWebsiteId($websiteId);

        // check if customer is already present
        // if customer is already present, then show error message
        // else create new customer
        if ($customer->loadByEmail($email)->getId() && $customer->loadByEmail($email)->getId() != $entityId) {
            echo 'Customer with the email ' . $email . ' is already registered.';
            $message = __(
                    'There is already an account with this email address "%1".', $email
            );
            // @codingStandardsIgnoreEnd
            $this->messageManager->addError($message);
        } else {

//            try {
            // prepare customer data
            $customer->setGroupId(4);
            $customer->setEmail($email);
            $customer->setFirstname($firstName);
            $customer->setLastname($lastName);
            if ($password && $password != '') {
                // set null to auto-generate password 
                $customer->setPassword($password);
            }
            // set the customer as confirmed
            // this is optional
            // comment out this line if you want to send confirmation email
            // to customer before finalizing his/her account creation
            $customer->setForceConfirmed(true);
            // save data
            $customer->save();

            $customerId = $customer->getId();
//                exit; 
//                if(isset($post['entity_id']) && $post['entity_id']!='')                 
//                {
//                    $customerId =  $post['entity_id'];
//                }
//                else
//                {
//                    $customerId =  $customer->getId();
//                }
            // save customer address
            // this is optional
            // you can skip saving customer address while creating the customer
            $customerAddress = $this->addressFactory->create();
            $customerAddress->setCustomerId($customerId)
                    ->setFirstname($firstName)
                    ->setLastname($lastName)
                    ->setCountryId('US')
                    ->setRegionId($regionId) // optional, depends upon Country, e.g. USA
                    ->setRegion($region) // optional, depends upon Country, e.g. USA
                    ->setPostcode($zipcode)
                    ->setCity($city)
                    ->setTelephone($telephone)
//                                ->setFax('999')
                    ->setCompany($companyName)
                    ->setStreet(array(
                        '0' => $street, // compulsory
                        '1' => $street2 // optional
                    ))
                    ->setIsDefaultBilling('1')
                    ->setIsDefaultShipping('1')
                    ->setSaveInAddressBook('1');

            // save customer address
            $customerAddress->save();

            if ($post['entity_id'] == '') {

                $modeluseritem = $this->_safetyItemsUsers->create();

//                    $customerId = 36973;
                if ($post['types'] == 2) {
                    $safetyUserItemArray = [
                        'serial_number' => $post['fire_model_number'],
                        'nickname' => $post['fire_nickname'],
                        'expiration_date' => $post['fx_expiration_date'],
                        'refill_reminder_status' => (!empty($post['fire_service_due_date'])) ? $post['fire_service_due_date'] : 'NULL',
                        'refill_reminder_days' => (!empty($post['fx_refill_reminder_days'])) ? $post['fx_refill_reminder_days'] : 'NULL',
                    ];
                } elseif ($post['types'] == 3) {
                    $safetyUserItemArray = [
                        'serial_number' => $post['aed_serial_number'],
                        'nickname' => $post['aed_nickname'],
                        'battery_expiration_date' => $post['aed_battery_expiration_date'],
                        'pad_expiration_date' => $post['aed_pad_expiration_date'],
                        'service_due_date' => $post['aed_service_due_date'],
                        'refill_reminder_status' => isset($post['aed_refill_reminder_status']) ? $post['aed_refill_reminder_status'] : '',
                        'refill_reminder_days' => $post['aed_refill_reminder_days'],
                    ];
                } elseif ($post['types'] == 4) {
                    $safetyUserItemArray = [
                        'model_number' => $post['eyewash_model_number'],
                        'nickname' => $post['eyewash_nickname'],
                        'expiration_date' => $post['eyewash_expiration_date'],
                        'refill_reminder_status' => isset($post['eyewash_refill_reminder_status']) ? $post['eyewash_refill_reminder_status'] : '',
                        'physical_inventory_status' => isset($post['eyewash_physical_inventory_status']) ? $post['eyewash_physical_inventory_status'] : '',
                    ];
                } elseif ($post['types'] == 5) {
                    $safetyUserItemArray = [
                        'model_number' => $post['spill_model_number'],
                        'nickname' => $post['spill_nickname'],
                        'refill_reminder_status' => isset($post['spill_refill_reminder_status']) ? $post['spill_refill_reminder_status'] : '',
                        'physical_inventory_status' => isset($post['spill_physical_inventory_status']) ? $post['spill_physical_inventory_status'] : '',
                    ];
                } else {
                    $safetyUserItemArray = [
                        'model_number' => $post['model_number'],
                        'serial_number' => $post['serial_number'],
                        'nickname' => $post['nickname'],
                        'expiration_date' => $post['expiration_date'],
                        'refill_reminder_days' => isset($post['refill_reminder_status']) && $post['refill_reminder_status'] != '' ? $post['refill_reminder_status'] : '',
                        'physical_inventory_status' => isset($post['physical_inventory_status']) ? $post['physical_inventory_status'] : '',
                    ];
                }

                $userItemArray = [
                    'customer_id' => $customerId,
                    'type' => $post['types'],
                    'number_of_employees' => $post['no_of_employees'],
                    'firstname' => $firstName,
                    'lastname' => $lastName,
                    'email' => $post['requisition_email_address'],
//                    'company_id' => $post['company'],
                    'company' => $post['company_name'],
                    'city' => $post['cityname'],
                    'street1' => $post['street'],
                    'street2' => $post['add2'],
                    'region_id' => $post['region_id'],
                    'region' => $post['region'],
                    'telephone' => $post['telephone'],
                    'postcode' => $post['zipcode'],
                ];
                if ($post['entity_id'] == '') 
                {
                    $userItemArray['company_id'] = $post['company'];
                }
                    
 
                $mainArray = array_merge($userItemArray, $safetyUserItemArray);
//                    print_r($mainArray);
//                    exit;
                $modeluseritem->addData($mainArray);

                $saveData = $modeluseritem->save();
            } else {
                $modeluseritem = $this->_safetyItemsUsers->create();
                $modeluseritem->load($customerId, 'customer_id');

                if ($modeluseritem && $modeluseritem['entity_id'] != '') {
                    $saveuseritem = $this->_safetyItemsUsers->create();
                    $saveuseritem->load($modeluseritem['entity_id']);
                } else {
                    $saveuseritem = $this->_safetyItemsUsers->create();
                }
                $userItemArray = [
                    'customer_id' => $customerId,
                    'number_of_employees' => $post['no_of_employees'],
                    'firstname' => $firstName,
                    'lastname' => $lastName,
                    'email' => isset($post['requisitions_email_address']) ? $post['requisitions_email_address'] : null,
//                    'company_id' => $post['company'],
                    'company' => $post['company_name'],
                    'city' => $post['cityname'],
                    'street1' => $post['street'],
                    'street2' => $post['add2'],
                    'region_id' => $post['region_id'],
                    'region' => $post['region'],
                    'telephone' => $post['telephone'],
                    'postcode' => $post['zipcode'],
                ];
                
                if ($post['entity_id'] == '') 
                {
                    $userItemArray['company_id'] = $post['company'];
                }

                $saveuseritem->addData($userItemArray);
                $saveuseritem->save();
            }

            
//                    $companysave = $this->_companyFactory->create();
//                    $companysave->load($post['company'], 'entity_id');
//                    $permission = (isset($post['resource']) && count($post['resource']) > 0) ? $post['resource'] : [];
//                    $companyPostData['permissions'] = ($permission && count($permission) >0) ? implode(',',$permission) : '';
//                    $companysave->addData($companyPostData); 
//                    $companysave->save();

                $permission = $this->customerPermissionFactory->create();
                $checkPermission = $permission->load($customerId, 'customer_id');
                if ($checkPermission) {
                    $permissionsave = $this->customerPermissionFactory->create();
                    $permissionsave->load($customerId, 'customer_id');
                    $permission = (isset($post['resource']) && count($post['resource']) > 0) ? $post['resource'] : [];
                    if ($post['entity_id'] == '') 
                    {
                        $permissionData['company_id'] = $post['company'];
                    }
                    $permissionData['customer_id'] = $customerId;
                    $permissionData['permission_type'] = isset($post['permission_type']) ? $post['permission_type'] : null;
                    $permissionData['permission'] = ($permission && count($permission) > 0) ? json_encode($permission, true) : '';
                    $permissionsave->addData($permissionData);
                    $permissionsave->save();
                } else {
 
                    $permissionsave = $this->customerPermissionFactory->create();

                    $permission = (isset($post['resource']) && count($post['resource']) > 0) ? $post['resource'] : [];
                    if ($post['entity_id'] == '') 
                    {
                        $permissionData['company_id'] = $post['company'];
                    }
                    $permissionData['customer_id'] = $customerId;
                    $permissionData['permission_type'] = isset($post['permission_type']) ? $post['permission_type'] : null; 
                    $permissionData['permission'] = ($permission && count($permission) > 0) ? json_encode($permission, true) : '';
                    $permissionsave->addData($permissionData);
                    $permissionsave->save();
                }
          
            $this->messageManager->addSuccess(
                    __(
                            'Customer account with email %1 created successfully.', $email
                    ) 
            );

//                $url = $this->urlModel->getUrl('*/*/save', ['_secure' => true]);
//                $resultRedirect->setUrl($this->_redirect->success($url));
            //$resultRedirect->setPath('*/*/');
//                return $resultRedirect;
            return $resultRedirect->setPath('safetyhubapp/users/');
//            } catch (StateException $e) {
////                $url = $this->urlModel->getUrl('customer/account/forgotpassword');
//                // @codingStandardsIgnoreStart
//                $message = __(
//                    'There is already an account with this email address. If you are sure that it is your email address, <a href="%1">click here</a> to get your password and access your account.',
//                    $url
//                );
//                // @codingStandardsIgnoreEnd
//                $this->messageManager->addError($message);
//            } catch (InputException $e) {
//                $this->messageManager->addError($this->escaper->escapeHtml($e->getMessage()));
//                foreach ($e->getErrors() as $error) {
//                    $this->messageManager->addError($this->escaper->escapeHtml($error->getMessage()));
//                }
//            } catch (LocalizedException $e) {
//                $this->messageManager->addError($this->escaper->escapeHtml($e->getMessage()));
//            } catch (\Exception $e) {
//                $this->messageManager->addException($e, __('We can\'t save the customer.'));
//            }
        }

        $this->session->setCustomerFormData($this->getRequest()->getPostValue());
//        $defaultUrl = $this->urlModel->getUrl('*/*/save', ['_secure' => true]);
//        $resultRedirect->setUrl($this->_redirect->error($defaultUrl));
//        return $resultRedirect;
    }

}

?>