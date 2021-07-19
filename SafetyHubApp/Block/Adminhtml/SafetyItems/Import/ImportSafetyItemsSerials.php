<?php

namespace Vgroup\SafetyHubApp\Block\Adminhtml\SafetyItems\Import;

use Vgroup\SafetyHubApp\Model\CompaniesFactory;

class ImportSafetyItemsSerials extends \Magento\Backend\Block\Template {

    protected $_companiesFactory;

    public function __construct(\Magento\Backend\Block\Template\Context $context, CompaniesFactory $companies) {
        $this->_companiesFactory = $companies;
        parent::__construct($context);
    }

}
