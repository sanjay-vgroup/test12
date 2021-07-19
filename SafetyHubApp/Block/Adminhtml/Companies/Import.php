<?php

namespace Vgroup\SafetyHubApp\Block\Adminhtml\Companies;
use Vgroup\SafetyHubApp\Model\CompaniesFactory;

class Import extends \Magento\Backend\Block\Template
{
    protected $_companiesFactory;
    
    public function __construct(\Magento\Backend\Block\Template\Context $context, CompaniesFactory $companies)
    {
        $this->_companiesFactory = $companies;
        parent::__construct($context);
    }

    public function sayHello()  
    { 
        
        $txt = 'Hello World';
        return $txt;
    }
    
     public function getCompanies() {
	$company = $this->_companiesFactory->create();
//	$getItems = $getSafetyItems->getCollection();
//	$select = $getItems->addFieldToSelect('model_number');
	$data = $company->getCollection()->getData();
//        print_r($data);
//        exit;
	return $data;
    }
}