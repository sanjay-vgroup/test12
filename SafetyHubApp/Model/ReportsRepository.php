<?php

namespace Vgroup\SafetyHubApp\Model;

use Vgroup\SafetyHubApp\Api\ReportsRepositoryInterface;
use Vgroup\SafetyHubApp\Api\Data\ReportInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Vgroup\SafetyHubApp\Model\ReportsFactory;
use Vgroup\SafetyHubApp\Helper\Email;
use Vgroup\SafetyHubApp\Helper\Data;

class ReportsRepository implements ReportsRepositoryInterface
{

	/**
	 * @var CollectionProcessor
	 */
	private $collectionProcessor;

	/**
	 * @var ExtensibleDataObjectConverter
	 */
	protected $extensibleDataObjectConverter;

	/**
	 * @var Magento\Framework\Stdlib\DateTime\TimezoneInterface
	 */
	protected $_timezoneInterface;

	/**
	 * @var Vgroup\SafetyHubApp\Model\ReportsFactory
	 */
	protected $reportFactory;

	/**
	 * @var Vgroup\SafetyHubApp\Helper\Email
	 */
	protected $mailHelper;

	/**
	 * @var Vgroup\SafetyHubApp\Helper\Data
	 */
	protected $helper;

	/**
	 * @param SafetyUsersItemsSearchResultsInterfaceFactory $searchResultsFactory
	 * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
	 * @param CollectionProcessorInterface $collectionProcessor
	 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
	 * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface
	 * @param \Vgroup\SafetyHubApp\Model\ReportsFactory $reportFactory
	 * @param \Vgroup\SafetyHubApp\Helper\Email $mailHelper
	 * @param \Vgroup\SafetyHubApp\Helper\Data $helper
	 */
	public function __construct(\Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter, CollectionProcessor $collectionProcessor, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface, ReportsFactory $reportFactory, Email $mailHelper, Data $helper)
	{
		$this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
		$this->collectionProcessor = $collectionProcessor;
		$this->_timezoneInterface = $timezoneInterface;
		$this->reportFactory = $reportFactory;
		$this->mailHelper = $mailHelper;
		$this->helper = $helper;
	}

	public function export(ReportInterface $report)
	{

		$reportModel = $this->reportFactory->create();

		try {

			$reportData = $this->extensibleDataObjectConverter->toNestedArray(
				$report,
				[],
				'\Vgroup\SafetyHubApp\Api\Data\ReportInterface'
			);

			$uniqueCode = $this->helper->generateCode();
			$recipients = @implode(",", $report->getRecipients());
			$filters = @implode(",", $report->getFilters());

                        
                        
			$safetyItemTypes = $this->helper->getSafetyItemTypes();
			$queryParams = ['report' => $uniqueCode];
			$storeDetail = $this->helper->getStoreManagerData($queryParams);
			$reportBody = [
				'download_link' => $storeDetail['download_link'],
				'item_type' => (in_array($report->getEntityIdentifier(), array_keys($safetyItemTypes))) ? $safetyItemTypes[$report->getEntityIdentifier()] : $report->getEntityIdentifier(),
			];

			$mailBody = ['user_id' => $report->getUserId()];
			$body = $this->mailHelper->getTemplateData($mailBody);

			$mailData = [
				'report_type' => $report->getReportType(),
				'user_id' => $report->getUserId(),
				'recipients' => $report->getRecipients(),
				'template_identifier' => 29
			];
                        switch($report->getReportType()):
                            case 3: 
                                $mailData['template_identifier'] = 31; // Requisition History Report
                                break; 
                            
                        endswitch;
			$mailData['body'] =  array_merge($body, $reportBody);
			$isMailSend = $this->mailHelper->sendMail($mailData);
			$reportData['recipients'] = $recipients;
			$reportData['filters'] = $filters;
			$reportModel->setReportType($report->getReportType());
			$reportModel->setUserId($report->getUserId());
			$reportModel->setEntityIdentifier($report->getEntityIdentifier());
			$reportModel->setModelNumber($report->getModelNumber());
			$reportModel->setSenderEmail($report->getSenderEmail());
			$reportModel->setRecipients($reportData['recipients']);
			$reportModel->setFilters($reportData['filters']);
			$reportModel->setSendMail(1);
			$reportModel->setUniqueCode($uniqueCode);
			$reportModel->setEmailSent($isMailSend);
			$reportModel->save();
			return true;
		} catch (\Exception $exception) {

			throw new CouldNotSaveException(
				__('Could not send the report: %1', $exception->getMessage()),
				$exception
			);

			$this->logger->debug($e->getMessage());
		}
		return false;
	}
}
