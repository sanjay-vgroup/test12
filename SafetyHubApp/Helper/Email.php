<?php

namespace Vgroup\SafetyHubApp\Helper;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{

	/**
	 * @var Magento\Framework\Translate\Inline\StateInterface
	 */
	protected $inlineTranslation;

	/**
	 * @var Magento\Framework\Escaper
	 */
	protected $escaper;

	/**
	 * @var Magento\Framework\Mail\Template\TransportBuilder
	 */
	protected $transportBuilder;

	/**
	 * @var Magento\Framework\App\Helper\Context
	 */
	protected $logger;

	/**
	 * @var Magento\Customer\Model\ResourceModel\Customer\CollectionFactory
	 */
	protected $_customerFactory;
	/**
	 * @var StoreManagerInterface
	 */
	public $storeManager;
	/**
	 * @var \Magento\Store\Model\StoreManagerInterface $storeManager
	 */
	protected $storeId = 7;
	/**
	 * @param Magento\Framework\App\Helper\Context $context
	 * @param Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
	 * @param Magento\Framework\Escaper $escaper
	 * @param Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
	 * @parma Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerFactory
	 */
	public function __construct(
		Context $context,
		StateInterface $inlineTranslation,
		Escaper $escaper,
		TransportBuilder $transportBuilder,
		CollectionFactory $customerFactory,
		StoreManagerInterface $storeManager
	) {
		parent::__construct($context);
		$this->inlineTranslation = $inlineTranslation;
		$this->escaper = $escaper;
		$this->transportBuilder = $transportBuilder;
		$this->_customerFactory = $customerFactory;
		$this->logger = $context->getLogger();
		$this->storeManager = $storeManager;
	}

	public function sendMail($mailData)
	{

		try {
			$mailData['recipients'] = array_values(array_filter($mailData['recipients'])); 
			$this->inlineTranslation->suspend();

			$sender = [
				'name' => $this->escaper->escapeHtml("First Aid Only App"),
				'email' => $this->escaper->escapeHtml("uat@vgroup.net"),
			];

			$transport = $this->transportBuilder
				->setTemplateIdentifier($mailData['template_identifier'])
				->setTemplateOptions(
					[
						'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
						'store' => $this->storeId,
						'requisition_id' => $mailData['body']['requisition_id'] ?? ""
					]
				)
				->setTemplateVars($mailData['body'])
				->setFrom($sender)
				->addTo($mailData['recipients'])
				->getTransport();

			$sendmail = $transport->sendMessage();
			$this->inlineTranslation->resume();
			return true;
		} catch (\Exception $exception) {
			$this->logger->debug($exception->getMessage());
		}
		return false;
	}

	public function getTemplateData($userData)
	{

		$collection = $this->_customerFactory->create()->addAttributeToSelect(["firstname", "lastname", "email", "company_id"])
			->addAttributeToFilter("entity_id", array("eq" => $userData['user_id']));

		$collection->getSelect()
			->joinLeft(array("customer_entity_int" => 'customer_entity_int'), "customer_entity_int.entity_id = e.entity_id AND customer_entity_int.attribute_id = 200", array('company_id' => 'value'))
			->joinLeft(array("safetyhubapp_companies" => 'safetyhubapp_companies'), "safetyhubapp_companies.entity_id = customer_entity_int.value AND customer_entity_int.attribute_id = 200", array('company_name' => 'name', 'company_email' => 'email', 'company_phone' => 'phone', 'company_url' => 'url', 'company_hours' => 'hours', 'company_logo' => 'logo', 'portal_bg_color' => 'portal_bg_color', 'portal_font_color' => 'portal_font_color', 'approval_mode' => 'approval_mode', 'interval' => 'interval'));
		$customer = current($collection->getData());

		$body = [
			'company_url' => $customer['company_url'],
			'logo_url' => $customer['company_logo'],
			'company_name' => $customer['company_name'],
			'company_hours' => $customer['company_hours'],
			'font_color' => $customer['portal_font_color'],
			'portal_bg_color' => $customer['portal_bg_color'],
			'store_phone' => $customer['company_phone'],
			'store_hours' => $customer['company_hours'],
			'querymail' => $customer['company_email'],
			'approval_mode' => ($customer['approval_mode'] == 2) ? true : false,
			'interval' => $customer['interval'],
			'customer_firstname' => $customer['firstname'],
			'customer_lastname' => $customer['lastname']
		];

		return $body;
	}

	public function getAdminEmails($data)
	{

		$adminEmailAddresses = [];
		$collection = $this->_customerFactory->create()->addAttributeToSelect(["email"])
			->addAttributeToFilter("company_id", array("eq" => $data['company_id']))->addAttributeToFilter("permission_type", array("eq" => 531));

		if ($collection->getSize() > 0) {
			foreach ($collection as $admin) {
				$adminEmailAddresses[] = $admin['email'];
			}
		}

		return ['size' => $collection->getSize(), 'email_addersses' => $adminEmailAddresses];
	}
}
