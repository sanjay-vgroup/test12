<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\SafetyItems;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vgroup\SafetyHubApp\Model\SafetyItemsFactory;

class ImportCsv extends \Magento\Backend\App\Action {
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
            $resultRedirect = $this->resultRedirectFactory->create();
            $files = $this->getRequest()->getFiles();
            $post = $this->getRequest()->getPostValue();
            $files = $this->getRequest()->getFiles('csv_file');
            $file = $files['tmp_name'];
            $safetyItems = $this->getCvsData($file);
            switch ($post['action_type']):
                case 'add_update':
                    foreach ($safetyItems as $safetyItem):
                        $modelNumber = $safetyItem['safety_item_model_number'];
                        echo $modelNumber . '<br/>';

                        $model = $this->_safetyItemsFactory->create();
                        $safety = $model->load($modelNumber, 'model_number');
                        $data = [
                            'title' => $safetyItem['title'],
                            'type' => $safetyItem['item_type'],
                            'model_number' => $safetyItem['safety_item_model_number'],
                            'sku' => $safetyItem['safety_item_sku'],
                            'upc' => $safetyItem['safety_item_upc'],
                            'description' => $safetyItem['description'],
                            'image' => $safetyItem['url'],
                            'file' => $safetyItem['safety_item_schematics'],
                            'status' => $safetyItem['status'],
                        ];
                        if (empty($safety->getData())):
                            $safety = $this->_safetyItemsFactory->create();
                            $safety->setData($data);
                            $msg = 'Safety Items Inserted Successfully.';
                        else:
                            $safety->addData($data);
                            $safety->setId($safety->getId());
                            $msg = 'Safety Items Updated Successfully.';
                        endif;
                        $saveData = $safety->save();
                        $product = $safetyItem['product'];
                        $bulkInsert = [];
                        foreach ($product as $record):
                            $sku = $record['sku'];
                            $collection = $this->productCollectionFactory->create();
                            $collection->addFieldToFilter('sku', $sku);
                            $product = $collection->getData();
                            if ($product && count($product) > 0) {
                                $productId = $product[0]['entity_id'];
                            } else {
                                $productId = 0;
                            }
                            $bulkInsert[] = [
                                'product_id' => $productId,
                                'qty' => $record['quantity'],
                                'row_id' => $safety->getId()
                            ];
                        endforeach;

                        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                        $dbStorage = $objectManager->get('Vgroup\SafetyHubApp\Model\Storage');
                        $dbStorage->insertMultiple('safetyhubapp_items_products', $bulkInsert);
                    endforeach;
                    break;
                case 'replace':
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


        return $resultRedirect->setPath('*/*/');
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
//                print_r($response);
                $i = $i + 1;
                $modelNumber = $response['safety_item_model_number'];
                if (!empty($modelNumber)):
                    $indexRow = $modelNumber;
                    $safetyItem = [];
                    $safetyItem = $response;
                    $safetyItem['product'][] = array(
                        'sku' => $response['product_sku'],
                        'quantity' => $response['quantity'],
                    );
                else:
                    $safetyItem['product'][] = array(
                        'sku' => $response['product_sku'],
                        'quantity' => $response['quantity'],
                    );
                endif;
                $safetyItems[$indexRow] = $safetyItem;
            }
            fclose($handle);
            return $safetyItems;
        }
    }

}
