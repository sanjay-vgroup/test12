<?php
namespace Vgroup\SafetyHubApp\Block\Company;

class Preview extends \Magento\Framework\View\Element\Template
{
     protected $_pageFactory;
     protected $_company;
     protected $fileDriver;
      /**
     * @var \Magento\MediaStorage\Helper\File\Storage\Database
     */
    protected $_fileStorageHelper;
    
     public function __construct(
         
          \Magento\Framework\View\Element\Template\Context $context,
          \Magento\Framework\View\Result\PageFactory $pageFactory,         
          \Vgroup\SafetyHubApp\Model\CompaniesFactory $company,
          \Magento\Framework\Filesystem\Driver\File $fileDriver, 
          \Magento\MediaStorage\Helper\File\Storage\Database $fileStorageHelper,   
           
         
          array $data = []
          )
     {
          $this->_pageFactory = $pageFactory;      
          $this->__company = $company; 
          $this->fileDriver = $fileDriver;
          $this->_fileStorageHelper = $fileStorageHelper;
          return parent::__construct($context,$data);
     }
 
     public function execute()
     {
   
          return $this->_pageFactory->create();
     }
       
 
     public function getCompany()
     {
      
          $id = 2;     
         $post = $this->__company->create();
         $result = $post->load($id);
         return $result;
        
            
     }
     
      public function checkFileExists()
    {
        $fileName = '/var/www/html/nutan/pub/media/safetyhubapp/company/logo/l/o';
        if ($this->fileDriver->isExists($fileName)) {
            return "file is exist";
        } else {
            return "file not exist";
        }
     
    }
    
      
}