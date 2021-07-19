<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class DownloadRequisitionReports extends \Magento\Backend\App\Action {

    protected $uploaderFactory;

    protected $_customerFactory; 
	/**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;
	protected $_date;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory = false;
        protected $_requisitionFactory;
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
	    Context $context,
		\Vgroup\SafetyHubApp\Model\RequisitionsFactory $requisitionFactory,
	    \Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Vgroup\SafetyHubApp\Model\RequisitionsFactory $customerFactory, // This is returns Collaction of Data
		\Magento\Framework\App\Response\Http\FileFactory $fileFactory,
		\Magento\Framework\Stdlib\DateTime\TimezoneInterface $date

    ) {
	parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->_requisitionFactory = $requisitionFactory;
		$this->_customerFactory = $customerFactory;
		$this->fileFactory = $fileFactory;
		$this->_date =  $date;
    }


    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
		$post = $this->getRequest()->getPostValue();
		
		$currentDate = $this->_date->date()->format('Y-m-d');

		$past7Days = date('Y-m-d', strtotime('-7 days'));

		$ytdDate = date('Y-m-d', strtotime('-1 days'));

		$dbytdDate = date('Y-m-d', strtotime('-2 days'));

		$currentMonthStart = date('Y-m-01', strtotime($currentDate));
		$currentMonthEnd = date('Y-m-t', strtotime($currentDate));

		$model   = $this->_requisitionFactory->create();
		$collection = $model->getCollection();
		
		if($post['frame_color']=='Last 7 days')
		{
			$approvedReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 1)
			->addFieldToFilter('main_table.created_at', ['lteq' => $past7Days])
			->addFieldToFilter('main_table.created_at', ['gteq' => $currentDate]);
			$approvedRequisition = $approvedReqItems;
			
			$rejectedReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 2)
			->addFieldToFilter('main_table.created_at', ['lteq' => $past7Days])
			->addFieldToFilter('main_table.created_at', ['gteq' => $currentDate]);
			$rejectedRequisition = $rejectedReqItems;

			$pendingReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 3)
			->addFieldToFilter('main_table.created_at', ['lteq' => $past7Days])
			->addFieldToFilter('main_table.created_at', ['gteq' => $currentDate]);
			$pendingRequisition = $pendingReqItems;
		}
		elseif($post['frame_color']=='Current Month')
		{
			$approvedReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 1)
			->addFieldToFilter('main_table.created_at', ['lteq' => $currentMonthStart])
			->addFieldToFilter('main_table.created_at', ['gteq' => $currentMonthEnd]);
			$approvedRequisition = $approvedReqItems;
			 
			$rejectedReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 2)
			->addFieldToFilter('main_table.created_at', ['lteq' => $currentMonthStart])
			->addFieldToFilter('main_table.created_at', ['gteq' => $currentMonthEnd]);
			$rejectedRequisition = $rejectedReqItems;

			$pendingReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 3)
			->addFieldToFilter('main_table.created_at', ['lteq' => $currentMonthStart])
			->addFieldToFilter('main_table.created_at', ['gteq' => $currentMonthEnd]);
			$pendingRequisition = $pendingReqItems;
		}
		elseif($post['frame_color']=='YTD')
		{
			$approvedReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 1)
			->addFieldToFilter('main_table.created_at', ['lteq' => $ytdDate])
			->addFieldToFilter('main_table.created_at', ['gteq' => $currentDate]);
			$approvedRequisition = $approvedReqItems;
			
			$rejectedReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 2)
			->addFieldToFilter('main_table.created_at', ['lteq' => $ytdDate])
			->addFieldToFilter('main_table.created_at', ['gteq' => $currentDate]);
			$rejectedRequisition = $rejectedReqItems;

			$pendingReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 3)
			->addFieldToFilter('main_table.created_at', ['lteq' => $ytdDate])
			->addFieldToFilter('main_table.created_at', ['gteq' => $currentDate]);
			$pendingRequisition = $pendingReqItems;
		}
		elseif($post['frame_color']=='2YTD')
		{
			$approvedReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 1)
			->addFieldToFilter('main_table.created_at', ['lteq' => $dbytdDate])
			->addFieldToFilter('main_table.created_at', ['gteq' => $currentDate]);
			$approvedRequisition = $approvedReqItems;
			
			$rejectedReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 2)
			->addFieldToFilter('main_table.created_at', ['lteq' => $dbytdDate])
			->addFieldToFilter('main_table.created_at', ['gteq' => $currentDate]);
			$rejectedRequisition = $rejectedReqItems;

			$pendingReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 3)
			->addFieldToFilter('main_table.created_at', ['lteq' => $dbytdDate])
			->addFieldToFilter('main_table.created_at', ['gteq' => $currentDate]);
			$pendingRequisition = $pendingReqItems;
		}
		else
		{
			$approvedReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 1)->addFieldToFilter('main_table.created_at', $currentDate);
			$approvedRequisition = $approvedReqItems;

			$rejectedReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 2)->addFieldToFilter('main_table.created_at', $currentDate);
			$rejectedRequisition = $rejectedReqItems;

			$pendingReqItems = $model->getCollection()->addFieldToFilter('main_table.status', 3)->addFieldToFilter('main_table.created_at', $currentDate);
			$pendingRequisition = $pendingReqItems;
		}
                
		echo $approvedReqItems->select();
		
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
        $page->drawText(__("FAO SAFETYHUB APP"), $x + 5, $this->y+50, 'UTF-8');
        $style->setFont($font,14);
        $page->setStyle($style);
        $page->drawText(__("Requisition Report"), $x + 5, $this->y+38, 'UTF-8');
        $style->setFont($font,11);
        $page->setStyle($style);
        $page->drawText(__("Report Generated Date: : %1",$currentDate), $x + 5, $this->y+28, 'UTF-8');
        $page->drawText(__("Report Duration: : %1",$post['frame_color']), $x + 5, $this->y+16, 'UTF-8');

        $style->setFont($font,12);
        $page->setStyle($style);
        $page->drawText(__("Requisition Date"), $x + 60, $this->y-10, 'UTF-8');
        $page->drawText(__("Approved"), $x + 200, $this->y-10, 'UTF-8');
        $page->drawText(__("Rejected"), $x + 310, $this->y-10, 'UTF-8');
        $page->drawText(__("Pending"), $x + 440, $this->y-10, 'UTF-8');

        $style->setFont($font,10);
        $page->setStyle($style);
        $add = 9;
        $page->drawText(count($approvedRequisition), $x + 210, $this->y-30, 'UTF-8');
        $page->drawText(count($rejectedRequisition), $x + 330, $this->y-30, 'UTF-8');
        $page->drawText(count($pendingRequisition), $x + 470, $this->y-30, 'UTF-8');
        $pro = $currentDate;
        $page->drawText($pro, $x + 65, $this->y-30, 'UTF-8');
        $page->drawRectangle(30, $this->y -62, $page->getWidth()-30, $this->y + 10, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        $fileName = 'RequisitionReports.pdf';

//        $this->fileFactory->create(
//           $fileName,
//           $pdf->render(),
//           \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR, // this pdf will be saved in var directory with the name RequisitionReports.pdf
//           'application/pdf'
//        );
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
