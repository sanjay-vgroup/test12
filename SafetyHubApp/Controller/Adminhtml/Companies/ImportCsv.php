<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Companies;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vgroup\SafetyHubApp\Model\CompaniesPartNumbersFactory;

class ImportCsv extends \Magento\Backend\App\Action {
    /**
     * @var \Vgroup\SafetyHubApp\Model\ResourceModel\Companies\CollectionFactory
     */

    /**
     * @var PageFactory
     */
    protected $resultPageFactory = false;
    protected $csv;
    protected $_companiesPartNumbersFactory;
    protected $productCollectionFactory;
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
    Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, 
    \Magento\Framework\File\Csv $csv, CompaniesPartNumbersFactory $companies,
    \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory        
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->csv = $csv;
        $this->_companiesPartNumbersFactory = $companies;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute() {

        $files = $this->getRequest()->getFiles();
        $post = $this->getRequest()->getPostValue();

        $files = $this->getRequest()->getFiles('csv_file');
        $file = $files['tmp_name'];
        $handle = fopen($file, "r");
        if (empty($handle) === false) {
            $model = $this->_companiesPartNumbersFactory->create();
			
            $i=0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
            { $i=$i+1;
			
                $default_sku = $data[0];
                $company_sku = $data[1];
                $title = $data[2];
                
                $sku = $default_sku;
                $collection = $this->productCollectionFactory->create();
                $collection->addFieldToFilter('sku', $sku);
                $product = $collection->getData();
                if($product && count($product)>0) {
                    $productId = $product[0]['entity_id'];
                } else {
                    $productId = 0;
                }
               

                $model->setData([
                        'row_id' => $post['row_id'],
                        'product_id' => $productId,
                        'default_sku' => $default_sku,
                        'company_sku' => $company_sku,
                        'title' => $title,
                ]);
                if(isset($post['skip_line']) && $post['skip_line']==1 && $i==1) {
                } else {
                        $saveData = $model->save();
                }
            }
            fclose($handle);
        }

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
