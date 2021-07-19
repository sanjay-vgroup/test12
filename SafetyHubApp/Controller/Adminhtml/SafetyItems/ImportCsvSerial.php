<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\SafetyItems;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vgroup\SafetyHubApp\Model\SafetyItemsFactory;

class ImportCsvSerial extends \Magento\Backend\App\Action {
    /**
     * @var \Vgroup\SafetyHubApp\Model\ResourceModel\Companies\CollectionFactory
     */

    /**
     * @var PageFactory
     */
    protected $resultPageFactory = false;
    protected $csv;
    protected $_safetyItemsFactory;
    protected $productCollectionFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
    Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\File\Csv $csv, SafetyItemsFactory $safetyItemsFactory, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->csv = $csv;
        $this->_safetyItemsFactory = $safetyItemsFactory;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute() {
        try {
            //    echo '<pre>';
            $resultRedirect = $this->resultRedirectFactory->create();
            $files = $this->getRequest()->getFiles();
            $post = $this->getRequest()->getPostValue();
            $files = $this->getRequest()->getFiles('csv_file');
            $file = $files['tmp_name'];
            $safetyItems = $this->getCvsData($file);
            $msg = '';
            switch ($post['action_type']):
                case 'add_update':
                    $msg = 'Serial Number(s) added successfully.';
                    foreach ($safetyItems as $safetyItem):
                        $modelNumber = $safetyItem['safety_item_model_number'];
                        //echo $modelNumber . '<br/>';
                        $model = $this->_safetyItemsFactory->create();
                        $safety = $model->load($modelNumber, 'model_number');
                        if (!empty($safety->getData())):
                            $safety_id = $safety->getId();
                            $serial = $safetyItem['serials'];
                            foreach ($serial as $record):
                                if (!empty($record)):
                                    $bulkInsert[] = [
                                        'row_id' => $safety_id,
                                        'serial_number' => $record
                                    ];
                                endif;
                            endforeach;
                            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                            $dbStorage = $objectManager->get('Vgroup\SafetyHubApp\Model\Storage');
                            //print_r($bulkInsert);
                            $dbStorage->insertMultiple('safetyhubapp_safetyitem_serials', $bulkInsert);
                        endif;
                    endforeach;
                    break;
                case 'delete':
                    $msg = 'Serial Number(s) deleted successfully.';
                    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                    $dbStorage = $objectManager->get('Vgroup\SafetyHubApp\Model\Storage');
                    foreach ($safetyItems as $safetyItem):
                        $modelNumber = $safetyItem['safety_item_model_number'];
                        //echo $modelNumber . '<br/>';
                        $model = $this->_safetyItemsFactory->create();
                        $safety = $model->load($modelNumber, 'model_number');
                        if (!empty($safety->getData())):
                            $safety_id = $safety->getId();
                            $serial_numbers = implode(",", $safetyItem['serials']);
                            $serial_numbers = "'" . str_replace(",", "','", $serial_numbers) . "'";
                            $dbStorage->deleteMultiple('safetyhubapp_safetyitem_serials', $safety_id, $serial_numbers);
                        endif;
                    endforeach;
                    break;
            endswitch;
            $this->messageManager->addSuccess(__($msg));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\RuntimeException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong while saving the item.' . $e->getMessage()));
        }
        return $resultRedirect->setPath('*/*/importserial');
    }

    public function getCvsData($file) {
        $handle = fopen($file, "r");
        if (empty($handle) === false) {
            $i = 0;
            $products = [];
            $safetyItems = [];
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($i++ == 0):
                    $row = $data;
                    continue;
                endif;
                $response = array_combine($row, $data);
                $i = $i + 1;
                $modelNumber = $response['safety_item_model_number'];
                if (!empty($modelNumber)):
                    $indexRow = $modelNumber;
                    $safetyItem = [];
                    $safetyItem = $response;
                    $safetyItem['serials'][] = $response['safety_item_serial_number'];
                else:
                    if (!empty($response['safety_item_serial_number'])):
                        $safetyItem['serials'][] = $response['safety_item_serial_number'];
                    endif;
                endif;
                $safetyItems[trim($indexRow)] = $safetyItem;
            }
            fclose($handle);
            return $safetyItems;
        }
    }

}
