<?php

namespace Vgroup\SafetyHubApp\Controller\Company;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem;

class Save extends \Magento\Framework\App\Action\Action {

    protected $_company;
    protected $scopeConfig;
    protected $_logLoggerInterface;

    /**
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * @var AdapterFactory
     */
    protected $adapterFactory;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Psr\Log\LoggerInterface $loggerInterface, ScopeConfigInterface $scopeConfig, \Vgroup\SafetyHubApp\Model\CompaniesFactory $company, UploaderFactory $uploaderFactory, AdapterFactory $adapterFactory, Filesystem $filesystem
    ) {
        parent::__construct($context);
        $this->_company = $company;


        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
    }

    public function execute() {
        $post = (array) $this->getRequest()->getPost();
        // $data = $this->getRequest()->getParams();
        $id = $this->getRequest()->getParam('id');
        $companyData = $this->_company->create();
        $data = $companyData->load($id);
        if ($data) {
            $files = $this->getRequest()->getFiles();
            if (isset($files['logo']) && !empty($files['logo']["name"])) {
                try {
                    $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'logo']);
                    //  print_r($uploaderFactory); exit();
                    //check upload file type or extension
                    $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                    $imageAdapter = $this->adapterFactory->create();
                    //  $uploaderFactory->addValidateCallback('custom_image_upload', $imageAdapter, 'validateUploadFile');
                    $uploaderFactory->setAllowRenameFiles(true);
                    $uploaderFactory->setFilesDispersion(true);
                    $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                    $destinationPath = $mediaDirectory->getAbsolutePath('safetyhubapp/company/logo');

                    $result = $uploaderFactory->save($destinationPath);
                    if (!$result) {
                        throw new LocalizedException(
                        __('File cannot be saved to path: $1', $destinationPath)
                        );
                    }
                    $imagePath = 'safetyhubapp/company/logo' . $result['file'];

                    //Set file path with name for save into database
                    $data['logo'] = $imagePath;
                    //  print_r($data['logo']); exit();
                    // $data->save()
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                }
            }
        }

        $id = $this->getRequest()->getParam('id');
        $companyData = $this->_company->create();
        $model = $companyData->load($id);
        try {

            $model->addData([
                'logo' => $data['logo'],
                'portal_bg_color' => $post['portal_bg_color'],
                'portal_font_color' => $post['portal_font_color'],
                'navigation_bar_bg_color' => $post['navigation_bar_bg_color'],
                'navigation_bar_font_color' => $post['navigation_bar_font_color'],
                'large_action_button_bg_color' => $post['large_action_button_bg_color'],
                'large_action_button_font_color' => $post['large_action_button_font_color'],
                'small_action_button_bg_color' => $post['small_action_button_bg_color'],
                'small_action_button_font_color' => $post['small_action_button_font_color'],
                'medium_action_button_bg_color' => $post['medium_action_button_bg_color'],
                'medium_action_button_font_color' => $post['medium_action_button_font_color'],
                'heading_font_color' => $post['heading_font_color'],
                'partnumber_preference' => $post['partnumber_preference'],
                'hours' => $post['hours'],
                'restock' => $post['restock'],
                'interval' => $post['interval'],
                'approval_mode' => $post['approval_mode']
            ]);






            $saveData = $model->save();

            $this->messageManager->addSuccess(__('Company is updated successfully !'));
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        return $this->_redirect('safetyhubapp/account/company');
    }

}
?>



