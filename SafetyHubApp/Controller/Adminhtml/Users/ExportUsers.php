<?php

/**
 * Created By : Rohan Hapani
 */

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Users;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Customer\Model\CustomerFactory;

class ExportUsers extends \Magento\Backend\App\Action {

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $customerFactory;
    protected $_safetyUsersItemsFactory;
    protected $productFactory;

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csvProcessor;

    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $directoryList;
    protected $_date;
    protected $_resourceConnection;
    protected $_connection;

    public function __construct(
    \Magento\Backend\App\Action\Context $context, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Magento\Catalog\Model\ProductFactory $productFactory, \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory, \Magento\Framework\File\Csv $csvProcessor, CustomerFactory $customerFactory, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date, \Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory $safetyUsersItemsFactory, \Magento\Framework\App\ResourceConnection $resourceConnection, \Magento\Framework\App\Filesystem\DirectoryList $directoryList
    ) {
        $this->fileFactory = $fileFactory;
        $this->customerFactory = $customerFactory;
        $this->productFactory = $productFactory;
        $this->resultLayoutFactory = $resultLayoutFactory;
        $this->csvProcessor = $csvProcessor;
        $this->directoryList = $directoryList;
        $this->_safetyUsersItemsFactory = $safetyUsersItemsFactory;
        $this->_resourceConnection = $resourceConnection;
        $this->_date = $date;
        parent::__construct($context);
    }

    public function execute() {

        $post = (array) $this->getRequest()->getPost();

        $customerIds = implode(',', $post['selected']);

        $this->_connection = $this->_resourceConnection->getConnection();
        $query = "SELECT customer.email,customer.firstname,customer.lastname,customer.created_at,custaddress.street,custaddress.city,custaddress.region,"
                . "custaddress.postcode,custaddress.country_id,custaddress.telephone,custaddress.company,"
                . "custpermission.permission_type,custpermission.permission FROM customer_entity As customer "
                . "LEFT JOIN customer_address_entity As custaddress ON customer.default_shipping=custaddress.entity_id "
                . " LEFT JOIN safetyhubapp_customer_permission As custpermission ON customer.entity_id=custpermission.customer_id "
                . "WHERE customer.entity_id IN ( $customerIds )";
        $collection = $this->_connection->fetchAll($query);
//        print_r($collection);
//        exit;
        $content[] = [
            'Email',
            'First Name',
            'Last Name',
            'Street',
            'City',
            'Region',
            'Postcode',
            'Country',
            'Telephone',
            'Permission Type',
            'Company',
            'Is AppUser',
            'User Role',
            'Manage Requisitions Permission',
            'Manage Safety Items Permission',
            'Manage Staff Permission',
            'Reports Permission',
            'Personalization Permission',
            'Set as admin',
            'Customer Since',
        ];

        $fileName = 'user_excel.csv'; // Add Your CSV File name
        $filePath = $this->directoryList->getPath(DirectoryList::MEDIA) . "/" . $fileName;
        foreach ($collection as $key => $value) {
            if ($value['permission_type'] == 1) {
                $permissionType = 'Specific Permissions';
            } elseif ($value['permission_type'] == 2) {
                $permissionType = 'Admin Group';
            } elseif ($value['permission_type'] == 3) {
                $permissionType = 'All Permissions';
            } else {
                $permissionType = '';
            }

            $manageRequisition = 'NO';
            $manageSIP = 'NO';
            $manageSP = 'NO';
            $RP = 'NO';
            $PP = 'NO';
            $permission = json_decode($value['permission'], true);
            if ($permission && count($permission) > 0) {
                if (in_array('1', $permission)) {
                    $manageRequisition = 'YES';
                }
                if (in_array('2', $permission)) {
                    $manageSIP = 'YES';
                }
                if (in_array('3', $permission)) {
                    $manageSP = 'YES';
                }
                if (in_array('4', $permission)) {
                    $RP = 'YES';
                }
                if (in_array('5', $permission)) {
                    $PP = 'YES';
                }
            }

            $content[] = [
                $value['email'],
                $value['firstname'],
                $value['lastname'],
                $value['street'],
                $value['city'],
                $value['region'],
                $value['postcode'],
                $value['country_id'],
                $value['telephone'],
                $permissionType,
                $value['company'],
                '',
                $permissionType,
                $manageRequisition,
                $manageSIP,
                $manageSP,
                $RP,
                $PP,
                '',
                $value['created_at']
            ];
        }

        $this->csvProcessor->setEnclosure('"')->setDelimiter(',')->saveData($filePath, $content);
        return $this->fileFactory->create(
                        $fileName, [
                    'type' => "filename",
                    'value' => $fileName,
                    'rm' => true, // True => File will be remove from directory after download.
                        ], DirectoryList::MEDIA, 'text/csv', null
        );
    }

}
