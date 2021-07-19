<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Dashboard;

use Magento\Backend\Block\Widget\Grid\ExportInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class ExportRefundedReportCsv extends \Vgroup\SafetyHubApp\Controller\Adminhtml\Dashboard\RefundedReport {

    public function execute() {
		
	$fileName = 'orders_by_refundedreport_report_' . date('YmdHis') . '.csv';
	$this->_view->loadLayout();
	
	/** @var ExportInterface $exportBlock  */
	$exportBlock = $this->_view->getLayout()->getChildBlock('adminhtml.report.grid', 'grid.export');
	return $this->_fileFactory->create($fileName, $exportBlock->getCsvFile(), DirectoryList::VAR_DIR
	);
    }

}
