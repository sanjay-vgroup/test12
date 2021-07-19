<?php

namespace Vgroup\SafetyHubApp\Controller\Company;

use Magento\Framework\App\Action\Context;

class EmailSave extends \Magento\Framework\App\Action\Action {

    protected $_company;
   

   

    public function __construct(\Magento\Framework\App\Action\Context $context,  \Vgroup\SafetyHubApp\Model\CompaniesFactory $company
    ) {
        parent::__construct($context);
        $this->_company = $company;
       
    }

    public function execute() {
        $post = (array) $this->getRequest()->getPost();
        $id = $this->getRequest()->getParam('id');
        $companyData = $this->_company->create();
        $model = $companyData->load($id);
        try {

            $model->addData([
                'email_template_subject' => $post['email_template_subject'],
                'email_template_content' => $post['email_template_content'],
                'email_template_style' => $post['email_template_style'],
               
            ]);

            $saveData = $model->save();

            $this->messageManager->addSuccess(__('Email template is updated successfully !'));
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        return $this->_redirect('safetyhubapp/account/email');
    }

}
?>



