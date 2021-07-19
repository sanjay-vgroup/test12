<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Requisitions;

class MassExport extends \Magento\Backend\App\Action {

    protected $_filter;
    protected $_collectionFactory;

    public function __construct(
    \Magento\Ui\Component\MassAction\Filter $filter, \Vgroup\SafetyHubApp\Model\ResourceModel\Requisitions\CollectionFactory $collectionFactory, \Magento\Backend\App\Action\Context $context, \Vgroup\SafetyHubApp\Model\RequisitionsFactory $requisitionFactory
    ) {
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        $this->requisitionFactory = $requisitionFactory;
        parent::__construct($context);
    }

    /**
     * @return void
     */
    public function execute() {
        $model = $this->requisitionFactory->create();
        try {
            $heading = [
                __('ID'),
                __('Requisitions Date'),
                __('First Name'),
                __('Last Name'),
                __('Email'),
                __('Requisitions Email Address'),
                __('Address'),
                __('City'),
                __('State'),
                __('Country'),
                __('Postcode'),
                __('Model#'),
                __('Serial#'),
                __('Company'),
                __('Status')
            ];
            $outputFile = "/var/www/html/fao/media/Requisition.csv";
            $handle = fopen($outputFile, 'w');
            fputcsv($handle, $heading);

            $logCollection = $this->_filter->getCollection($this->_collectionFactory->create());
            $itemDeleted = 0;
            foreach ($logCollection->getItems() as $item) {

                $requisition = $model->load($item->getData('entity_id'));
                $userSafetyItem = $model->getRequisitionUserSafetyItem($model, ['type', 'model_number', 'serial_number', 'nickname']);
                $Items = $model->getRequisitionItems($model, ['sku', 'name', 'qty', 'price']);
                $row = [
                    $item->getData('entity_id'),
                    date('m/d/Y H:i:s', strtotime($item->getData('created_at'))),
                    $item->getData('firstname'),
                    $item->getData('lastname'),
                    $item->getData('email'),
                    $item->getData('requisition_email_address'),
                    $item->getData('street1') . ' ' . $item->getData('street2'),
                    $item->getData('city'),
                    $item->getData('region'),
                    $requisition->getCountryId(),
                    $item->getData('postcode'),
                    $requisition->getModelNumber(),
                    $requisition->getSerialNumber(),
                    $item->getData('company'),
                    $requisition->getRequisitionStatusLabel(),
                ];

                fputcsv($handle, $row);
            }
            $this->downloadCsv($outputFile);
            $this->messageManager->addSuccess(__('Item Successfully.'));
        } catch (Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
                fclose($handle);
        exit;
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index'); //Redirect Path
    }

    /**
     * is action allowed
     *
     * @return bool
     */
    protected function _isAllowed() {
        return $this->_authorization->isAllowed('Vgroup_SafetyHubApp::view');
    }

    public function executeBKP() {
        $recordsIds = $this->getRequest()->getParam('news');
        $recordsModel = $this->_newslistFactory->create();
        $recordsCollection = $recordsModel->getCollection();
        $recordsCollection->addFieldToFilter('news_id', array('in' => $recordsIds));
        $imageHelper = $this->helper;
        $basePath = $imageHelper->getBaseDir();
        $currentStores = $imageHelper->getCurrentStores();

        $heading = [
            __('News ID'),
            __('News Title'),
            __('URL Identifier'),
            __('Category ID'),
            __('Store Name'),
            __('Image Url'),
            __('Description'),
            __('Status'),
            __('Publish Date')
        ];
        $outputFile = $basePath . "/NewsList.csv";
        $handle = fopen($outputFile, 'w');
        fputcsv($handle, $heading);
        foreach ($recordsCollection as $records) {
            //set store name
            $storeView = @explode(',', $records['store_view']);
            $storesForExport = array();
            foreach ($storeView as $stores):
                $storesForExport[] = $this->getStoreName($stores, $currentStores);
            endforeach;

            if ($records['category_id'] == '0'):
                $category_id = '';
            else:
                $category_id = $records['category_id'];
            endif;

            //status
            if ($records['status'] == '1'):
                $status = 'Enabled';
            else:
                $status = 'Disabled';
            endif;

            //image 
            $recordsImage = $records['image'];
            if (!empty($recordsImage)):
                if (!filter_var($recordsImage, FILTER_VALIDATE_URL)):
                    $getBaseUrl = $imageHelper->getBaseUrl();
                    $recordsImageValue = $getBaseUrl . '/' . $recordsImage;
                else:
                    $recordsImageValue = $recordsImage;
                endif;

            else:
                $recordsImageValue = '';
            endif;

            $row = [
                $records['news_id'],
                $records['title'],
                $records['url_identifier'],
                $category_id,
                @implode(',', $storesForExport),
                $recordsImageValue,
                strip_tags($records['description']),
                $status,
                date('m/d/Y H:i:s', strtotime($records['publish_date']))
            ];
            fputcsv($handle, $row);
        }
        $this->downloadCsv($outputFile);
    }

    public function downloadCsv($file) {
        if (file_exists($file)) {
            //set appropriate headers
            header('Content-Description: File Transfer');
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function getStoreName($storeId, $currentStores) {
        foreach ($currentStores as $currentStore):
            if ($currentStore['store_id'] == $storeId):
                return $currentStore['name'];
            endif;
        endforeach;
    }

}
