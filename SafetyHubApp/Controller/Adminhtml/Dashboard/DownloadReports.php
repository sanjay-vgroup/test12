<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class DownloadReports extends \Magento\Backend\App\Action {

    /**
     * @var PageFactory
     */
    protected $resultPageFactory = false;
        protected $_requisitionFactory;
			protected $_date;
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
	    Context $context,
		\Vgroup\SafetyHubApp\Model\RequisitionsFactory $requisitionFactory,
	    \Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Vgroup\SafetyHubApp\Model\CustomerFactory $customerFactory, // This is returns Collaction of Data
		\Magento\Framework\Stdlib\DateTime\TimezoneInterface $date

    ) {
	parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->_requisitionFactory = $requisitionFactory;
		$this->_customerFactory = $customerFactory;
		$this->_date =  $date;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute() {
	
	$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
			$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
			$connection = $resource->getConnection();
			

			//Select Data from table
			$sql = "SELECT count(*) as total_user FROM customer_entity c where c.group_id=4 ";
			$result = $connection->fetchAll($sql); // gives associated array, table fields as key in array.
			$sql1 = "SELECT count(*) as total_user FROM customer_entity c, safetyhubapp_customer_permission sc where c.group_id=4 and c.entity_id=sc.customer_id and sc.company_id>0";
			$resultEnterise = $connection->fetchAll($sql1); // gives associated array, table fields as key in array.

                       
		$currentDate = $this->_date->date()->format('Y-m-d');
		
	$pdf = new \Zend_Pdf(); //Create new PDF file

	$page = $pdf->newPage(\Zend_Pdf_Page::SIZE_A4);

	$pdf->pages[] = $page; 

	$page->setFont(\Zend_Pdf_Font::fontWithName(\Zend_Pdf_Font::FONT_HELVETICA), 20);  //Set Font 

		$currentMonthStart = date('Y-m-01', strtotime($currentDate));
		$currentMonthEnd = date('Y-m-t', strtotime($currentDate));

        $pdf = new \Zend_Pdf();
        $pdf->pages[] = $pdf->newPage(\Zend_Pdf_Page::SIZE_A4);
        $page = $pdf->pages[0]; // this will get reference to the first page.
        $style = new \Zend_Pdf_Style();
        $style->setLineColor(new \Zend_Pdf_Color_Rgb(0,0,0));
        $font = \Zend_Pdf_Font::fontWithName(\Zend_Pdf_Font::FONT_TIMES);
        $style->setFont($font,15);
        $page->setStyle($style);
        $width = $page->getWidth();
        $hight = $page->getHeight();
        $x = 30;
        $pageTopalign = 900; //default PDF page height
        $this->y = 850 - 100; //print table row from page top – 100px
        //Draw table header row’s


        $style->setFont($font,15);
        $page->setStyle($style);
        $page->drawText(__("FAO SAFETYHUB APP"), 250, $this->y+50, 'UTF-8');
        $style->setFont($font,14);
        $page->setStyle($style);
        $page->drawText(__("Users Report"), 35, 740, 'UTF-8');
        $style->setFont($font,11);
        $page->setStyle($style);
        $page->drawText(__("Report Generated Date:  %1",$currentDate), 35, 720, 'UTF-8');
        $style->setFont($font,13);
        $page->setStyle($style);
	$page->drawText('Enterprise App Users: '.$resultEnterise[0]['total_user'], 35, 670, 'UTF-8'); 
         $style->setFont($font,13);
        $page->setStyle($style);
	$page->drawText('Standard App Users: '.($result[0]['total_user']-$resultEnterise[0]['total_user']), 35, 650, 'UTF-8'); 
        $style->setFont($font,14);
        $page->setStyle($style);
	$page->drawText('Total App Users: '.$result[0]['total_user'], 35, 630, 'UTF-8'); 
        
	$pdfData = $pdf->render(); // Get PDF document as a string 

	header("Content-Disposition: inline; filename=SafteyHubApp-Users.pdf"); 

	header("Content-type: application/x-pdf"); 

	echo $pdfData; 

	// $resultPage = $this->resultPageFactory->create();
	// $resultPage->getConfig()->getTitle()->prepend((__('Dashboard')));
	// $model   = $this->_requisitionFactory->create();
	// $collection = $model->getCollection();

	
    // print_r($collection->getData()); exit;
	// return $resultPage;
    }

    /**
     * Is the user allowed to view the attachment grid.
     *
     * @return bool
     */
    protected function _isAllowed()
      {
      return $this->_authorization->isAllowed('Vgroup_SafetyHubApp::dashboard');
      } 
}
