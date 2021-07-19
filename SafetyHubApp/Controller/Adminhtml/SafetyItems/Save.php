<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\SafetyItems;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\TestFramework\ErrorLog\Logger;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\MediaStorage\Model\File\Validator\NotProtectedExtension;
use Magento\MediaStorage\Helper\File\Storage;
use Vgroup\SafetyHubApp\Model\SafetyItemsFactory;

class Save extends Action {

    /**
     * @var \Magento\Backend\Helper\Js
     */
    protected $_jsHelper;

    /**
     * @var \Vgroup\SafetyHubApp\Model\ResourceModel\SafetyItems\CollectionFactory
     */
    protected $_contactCollectionFactory;

    /**
     * @var  \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $_fileUploaderFactory;

    /**
     * @var \Magento\MediaStorage\Helper\File\Storage\Database
     */
    protected $_database;

    /**
     * @var \Magento\MediaStorage\Model\File\Validator\NotProtectedExtension
     */
    protected $_noprotectedextension;

    /**
     * @var \Magento\MediaStorage\Helper\File\Storage
     */
    protected $_storage;

    /**
     * @var \Vgroup\SafetyHubApp\Model\SafetyItems
     */
    protected $_safetyItemFactory;

    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    protected $_file;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_filesystem;

    public function __construct(
    Context $context, \Magento\Backend\Helper\Js $jsHelper, \Vgroup\SafetyHubApp\Model\ResourceModel\SafetyItems\CollectionFactory $contactCollectionFactory, \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory, \Magento\Framework\Filesystem $filesystem, \Magento\Framework\Filesystem\Driver\File $file, Database $database, NotProtectedExtension $noProtectedExtension, Storage $storage, SafetyItemsFactory $safetyItemsFactory, \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_jsHelper = $jsHelper;
        $this->_contactCollectionFactory = $contactCollectionFactory;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_filesystem = $filesystem;
        $this->_database = $database;
        $this->_noprotectedextension = $noProtectedExtension;
        $this->_storage = $storage;
        $this->_file = $file;
        $this->_safetyItemFactory = $safetyItemsFactory;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed() {
        return true;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute() {

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $files = $this->getRequest()->getFiles();
        $mediaURL = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        if ($data) {

            try {

                /** @var \Vgroup\SafetyHubApp\Model\Safetyitem $model */
                $safetyItem = $this->_safetyItemFactory->create();
                $safetyItemPostData = $data['safetyitems'];
                if (!empty($safetyItemPostData['id'])) {
                    $safetyItem->load($safetyItemPostData['id']);
                    $safetyItemUploadedImage = $safetyItem->getImage();
                    $schematicsUploadedImage = $safetyItem->getFile();
                    $safetyItem->addData($safetyItemPostData);
                    $safetyItem->setId($safetyItemPostData['id']);
                    $msg = 'Safety Item Updated Successfully.';
                } else {
                    $msg = 'Safety Item Inserted Successfully.';
                    $safetyItem->setData($safetyItemPostData);
                }


                if (!empty($files['safetyitems']['image']['name'])) {

                    $safetyItemImageUploadPath = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('safetyhubapp/safetyitemsimages');
                    $safetyItemImageUploader = $this->_fileUploaderFactory->create(['fileId' => 'safetyitems[image]'])->setAllowedExtensions(['jpg', 'jpeg', 'png'])->setAllowRenameFiles(true);
                    $resultSafetyItemImage = $safetyItemImageUploader->save($safetyItemImageUploadPath);
                    if (!empty($safetyItemUploadedImage) && !empty($resultSafetyItemImage['file'])) {
//                        $this->_file->deleteFile($safetyItemImageUploadPath . '/' . $safetyItemUploadedImage);
                        $safetyItem->setData('image', $mediaURL . 'safetyhubapp/safetyitemsimages/' . $resultSafetyItemImage['file']);
                    } else {
                        $safetyItem->setData('image', $mediaURL . 'safetyhubapp/safetyitemsimages/' . $resultSafetyItemImage['file']);
                    }
                }
//
                if (!empty($files['safetyitems']['file']['name'])) {

                    $schematicsImageUploadPath = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('safetyhubapp/schematicsimages');
                    $schematicsImageUploader = $this->_fileUploaderFactory->create(['fileId' => 'safetyitems[file]'])->setAllowedExtensions(['jpg', 'jpeg', 'png'])->setAllowRenameFiles(true);
                    $resultschematicsImage = $schematicsImageUploader->save($schematicsImageUploadPath);

                    if (!empty($schematicsUploadedImage) & !empty($resultschematicsImage['file'])) {
//                        $this->_file->deleteFile($schematicsImageUploadPath . '/' . $schematicsUploadedImage);
                        $safetyItem->setData('file', $mediaURL . 'safetyhubapp/schematicsimages/' . $resultschematicsImage['file']);
                    } else {
                        $safetyItem->setData('file', $mediaURL . 'safetyhubapp/schematicsimages/' . $resultschematicsImage['file']);
                    }
                }

//                echo '<pre>';
                $safetyItem->save();
                $this->saveProducts($safetyItem, $data);
                $this->saveSerialNumbers($safetyItem, $data);
                $this->messageManager->addSuccess(__($msg));

                //return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the item.' . $e->getMessage()));
            }
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $safetyItem->getId(), '_current' => true]);
            }

            return $resultRedirect->setPath('*/*/');
        }
    }

    public function saveSerialNumbers($model, $post) {
        if (isset($post['serial_numbers'])) {
            $serialNumbers = $this->_jsHelper->decodeGridSerializedInput($post['serial_numbers']);
            $this->_resources = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
            $connection = $this->_resources->getConnection();
            $table = $this->_resources->getTableName('safetyhupapp_cabinet_serials');

            try {
                $oldSerialNumbers = $model->getCabinetSerialsOnly($model);
                $newSerialNumbers = (array) array_keys($serialNumbers);

                $insert = array_diff($newSerialNumbers, $oldSerialNumbers);
                $delete = array_diff($oldSerialNumbers, $newSerialNumbers);

                if ($delete) {
                    $where = ['cabinet_id = ?' => (int) $model->getId(), 'id IN (?)' => $delete];
                    $connection->delete($table, $where);
                }

//                if ($insert) {
//                    $data = [];
//                    foreach ($insert as $product_id) {
//                        $data[] = ['cabinet_id' => (int) $model->getId(), 'product_id' => (int) $product_id, 'qty' => $productIds[(int) $product_id]['qty']];
//                    }
//                    $countData = $connection->insertMultiple($table, $data);
//                }
            } catch (Exception $ex) {
                $this->messageManager->addException($ex, __('Something went wrong while saving the safety item serial numbers.' . $ex->getMessage()));
            }
        }
    }

    public function saveProducts($model, $post) {
        // Attach the attachments to safetyitem
        if (isset($post['products'])) {
            $productIds = $this->_jsHelper->decodeGridSerializedInput($post['products']);
            try {
                $oldProducts = (array) $model->getProducts($model, ['product_id']);
                $newProducts = (array) array_keys($productIds);
                $this->_resources = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
                $connection = $this->_resources->getConnection();

                $table = $this->_resources->getTableName(\Vgroup\SafetyHubApp\Model\ResourceModel\SafetyItems::TBL_ATT_PRODUCT);
                $insert = array_diff($newProducts, $oldProducts);
                $delete = array_diff($oldProducts, $newProducts);

                if ($delete) {
                    $where = ['row_id = ?' => (int) $model->getId(), 'product_id IN (?)' => $delete];
                    $connection->delete($table, $where);
                }

                if ($insert) {
                    $data = [];
                    foreach ($insert as $product_id) {
                        $data[] = ['row_id' => (int) $model->getId(), 'product_id' => (int) $product_id, 'qty' => $productIds[(int) $product_id]['qty']];
                    }
                    $countData = $connection->insertMultiple($table, $data);
                }
            } catch (Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the safety item products.' . $e->getMessage()));
            }
        }
    }

}
