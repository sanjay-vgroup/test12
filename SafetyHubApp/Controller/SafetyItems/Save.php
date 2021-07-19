<?php

namespace Vgroup\SafetyHubApp\Controller\SafetyItems;

use Vgroup\SafetyHubApp\Model\SafetyItemsUsersFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Save extends \Magento\Framework\App\Action\Action {

    protected $_safetyItemsUsers;
    protected $resultRedirect;
    protected $timezone;
    protected $customerSession;
    protected $safetyItems;

    public function __construct(\Magento\Framework\App\Action\Context $context,
	    \Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory $safetyItemsUsers,
	    \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
	    \Magento\Customer\Model\Session $customerSession,
	    \Vgroup\SafetyHubApp\Model\SafetyItemsFactory $safetyItems,
	    \Magento\Framework\Controller\ResultFactory $result) {
	parent::__construct($context);
	$this->_safetyItemsUsers = $safetyItemsUsers;
	$this->resultRedirect = $result;
	$this->timezone = $timezone;
	$this->customerSession = $customerSession;
	$this->safetyItems = $safetyItems;
    }

    public function execute() {
	$post = (array) $this->getRequest()->getPost();

	if (!empty($post['safety_users_items_id'])) {
	    $id = $post['safety_users_items_id'];

	    $safetyData = $this->_safetyItemsUsers->create();
	    $model = $safetyData->load($id);
	    // $model = $model->getData();
	} else {
	    $model = $this->_safetyItemsUsers->create();
	}

	$currenttime = date('Y-m-d H:i:s');
	$dateTimeZone = $this->timezone->date(new \DateTime($currenttime))->format('Y/m/d H:i:s');

	$customerId = $this->customerSession->getCustomer()->getId();

	try {



	    if ($post['types'] == 2) {

		$model->addData([
		    'customer_id' => $customerId,
		    'type' => $post['types'],
		    'model_number' => $post['fire_model_number'],
		    'serial_number' => $post['fire_model_number'],
		    'nickname' => $post['fire_nickname'],
		    'expiration_date' => $post['fx_expiration_date'],
		    'service_due_date' => $post['fire_service_due_date'],
		    'refill_reminder_status' => (!empty($post['check_fire_extinguisher_reminder'])) ? $post['check_fire_extinguisher_reminder'] : 'NULL',
		    'refill_reminder_days' => (!empty($post['fx_refill_reminder_days'])) ? $post['fx_refill_reminder_days'] : 'NULL',
		    'created_at' => $dateTimeZone,
		    'updated_at' => $dateTimeZone,
		]);
		$model->setId($id);
	    } elseif ($post['types'] == 3) {
		$model->addData([
		    'customer_id' => $customerId,
		    'type' => $post['types'],
		    'model_number' => $post['aed_serial_number'],
		    'serial_number' => $post['aed_serial_number'],
		    'nickname' => $post['aed_nickname'],
		    'battery_expiration_date' => $post['battery_expiration_date'],
		    'pad_expiration_date' => $post['pad_expiration_date'],
		    'service_due_date' => $post['aed_service_due_date'],
		    'refill_reminder_status' => (!empty($post['aed_refill_reminder_status'])) ? $post['aed_refill_reminder_status'] : 'NULL',
		    'expiry_reminder_status' => (!empty($post['expiry_reminder_status'])) ? $post['expiry_reminder_status'] : 'NULL',
		    'created_at' => $dateTimeZone,
		    'updated_at' => $dateTimeZone,
		]);
	    } elseif ($post['types'] == 4) {
		$model->addData([
		    'customer_id' => $customerId,
		    'type' => $post['types'],
		    'model_number' => $post['eyewash_stations_model_number'],
		    'nickname' => $post['eyewash_stations_nickname'],
		    'expiration_date' => $post['eyewash_stations_expiration_date'],
		    'refill_reminder_status' => (!empty($post['check_eyewash_stations_reminder'])) ? $post['check_eyewash_stations_reminder'] : 'NULL',
		    'physical_inventory_status' => (!empty($post['do_physical_inventory_of_eyewash_stations'])) ? $post['do_physical_inventory_of_eyewash_stations'] : 'NULL',
		    'created_at' => $dateTimeZone,
		    'updated_at' => $dateTimeZone
		]);
	    } elseif ($post['types'] == 5) {
		$model->addData([
		    'customer_id' => $customerId,
		    'type' => $post['types'],
		    'model_number' => $post['spill_model_number'],
		    'nickname' => $post['spill_nickname'],
		    'refill_reminder_status' => (!empty($post['spill_refill_reminder_status'])) ? $post['spill_refill_reminder_status'] : 'NULL',
		    'physical_inventory_status' => (!empty($post['spill_physical_inventory_status'])) ? $post['spill_physical_inventory_status'] : 'NULL',
		    'created_at' => $dateTimeZone,
		    'updated_at' => $dateTimeZone
		]);
	    } else {
		$model->addData([
		    'customer_id' => $customerId,
		    'type' => $post['types'],
		    'model_number' => $post['model_number'],
		    'serial_number' => $post['serial_number'],
		    'nickname' => $post['nickname'],
		    'expiration_date' => $post['expiration_date'],
		    'refill_reminder_status' => (!empty($post['cabinet_refill_reminder_status'])) ? $post['cabinet_refill_reminder_status'] : 'NULL',
		    'physical_inventory_status' => (!empty($post['cabinet_physical_inventory_status'])) ? $post['cabinet_physical_inventory_status'] : 'NULL',
		    'created_at' => $dateTimeZone,
		    'updated_at' => $dateTimeZone,
		]);
	    }

	    $saveData = $model->save();
	    if (!empty($id)) {
		$this->messageManager->addSuccess(__('SafetyItem is updated successfully !'));
	    } else {
		$this->messageManager->addSuccess(__('SafetyItem is created successfully !'));
	    }
	} catch (\Exception $e) {
	    $this->messageManager->addError($e->getMessage());
	}
	return $this->_redirect('safetyhubapp/account/safetyitems');
    }

}
?>



