<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Users;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\AddressFactory;
use Vgroup\SafetyHubApp\Model\CompanyFactory;

class ImportCsv extends \Magento\Backend\App\Action {
    /**
     * @var \Vgroup\SafetyHubApp\Model\ResourceModel\Companies\CollectionFactory
     */

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    protected $csv;
    protected $customerSession;
    protected $customerFactory;
    protected $addressFactory;
    protected $_companyFactory;
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
    Context $context, 
        \Magento\Framework\View\Result\PageFactory $resultPageFactory, 
        \Magento\Framework\File\Csv $csv, 
        \Magento\Customer\Model\Session $customerSession, 
        CustomerFactory $customerFactory,
        AddressFactory $addressFactory,
        CompanyFactory $company
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->csv = $csv;
        $this->customerSession  = $customerSession;
        $this->customerFactory  = $customerFactory;
        $this->addressFactory   = $addressFactory;
        $this->_companyFactory  = $company;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute() {
        $resultRedirect = $this->resultRedirectFactory->create();

        $files = $this->getRequest()->getFiles();
        $post = $this->getRequest()->getPostValue();

        $files = $this->getRequest()->getFiles('csv_file');
        $file = $files['tmp_name'];
        $handle = fopen($file, "r");
        if (empty($handle) === false) {
//            $model = $this->customerFactory->create();
            $i = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $i = $i + 1;
                
                $email      = $data[0];
                $firstName  = $data[1];
                $lastName   = $data[2];
                $street     = $data[3];
                $city       = $data[4];
                $region     = $data[5];
                $postcode   = $data[6];
                $country    = $data[7];
                $telephone  = $data[8];
                $permType   = $data[9];
                $company        = $data[10];
                $isAppUser      = $data[11];
                $userRole       = $data[12];
                $manReqPerm     = $data[13];
                $manSafItemPerm = $data[14];
                $manStaffPerm   = $data[15];
                $reportsPerm    = $data[16];
                $persPerm       = $data[17];
                $setAsAdmin     = $data[18];
                $customerSince  = $data[19];
                
                if($permType=='Specific Permissions') {
                    $permissionType = 1;
                } elseif($permType=='Admin Group') {
                    $permissionType = 2;
                } elseif($permType=='All Permissions') {
                    $permissionType = 3;
                } else {
                    $permissionType = NULL;
                }
                
                $permissions = [];
                if($manReqPerm=='Yes') {
                    $permissions[] = 1;
                }
                if($manSafItemPerm=='Yes') {
                    $permissions[] = 2;
                }
                if($manStaffPerm=='Yes') {
                    $permissions[] = 3;
                }
                if($reportsPerm=='Yes') {
                    $permissions[] = 4;
                }
                if($persPerm=='Yes') {
                    $permissions[] = 5;
                }
                
                if($i > 1)
                {
                    $customer = $this->customerFactory->create();
                    $customer->setGroupId(4);
                    $customer->setEmail($email); 
                    $customer->setFirstname($firstName);
                    $customer->setLastname($lastName);
                    $customer->save();

                    $customerId =   $customer->getId();

                    $customerAddress = $this->addressFactory->create();                
                    $customerAddress->setCustomerId($customerId)
                                    ->setFirstname($firstName)
                                    ->setLastname($lastName)
                                    ->setCountryId('US')
    //                              ->setRegionId($regionId) // optional, depends upon Country, e.g. USA
                                    ->setRegion($region) // optional, depends upon Country, e.g. USA
                                    ->setPostcode($postcode)
                                    ->setCity($city)
                                    ->setTelephone($telephone)
    //                                ->setFax('999')
                                    ->setCompany($company)
                                    ->setStreet(array(
                                        '0' => $street, // compulsory
    //                                  '1' => $street2 // optional
                                    )) 
                                    ->setIsDefaultBilling('1')
                                    ->setIsDefaultShipping('1')
                                    ->setSaveInAddressBook('1');

                    $customerAddress->save();
                    
                    $companysave = $this->_companyFactory->create();
                    $companysave->addData([
                        'name'              =>  $company,
                        'email'             =>  $email,
                        'permission_type'   =>  $permissionType,
                        'permissions'       =>  ($permissions && count($permissions) >0) ? implode(',',$permissions) : '',
                    ]); 
                    $companysave->save();
                }
            }

            fclose($handle);
        }
        return $resultRedirect->setPath('*/*/index');
        exit;
    }

    /**
     * Is the user allowed to view the attachment grid.
     *
     * @return bool
     */
    /* protected function _isAllowed()
      {
      return $this->_authorization->isAllowed('Vgroup_SafetyHubApp::safetyitems');
      } */
}
