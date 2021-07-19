<?php
namespace Vgroup\SafetyHubApp\Block\Company;

class Edit extends \Magento\Framework\View\Element\Template
{
     protected $_pageFactory;
     protected $_company;
   

     public function __construct(
         
          \Magento\Framework\View\Element\Template\Context $context,
          \Magento\Framework\View\Result\PageFactory $pageFactory,         
          \Vgroup\SafetyHubApp\Model\CompaniesFactory $company,
        
         
          array $data = []
          )
     {
          $this->_pageFactory = $pageFactory;      
          $this->__company = $company; 
         
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
     
   
   
}