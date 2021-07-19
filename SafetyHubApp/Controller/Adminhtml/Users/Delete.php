<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Users;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;
use Vgroup\SafetyHubApp\Model\UsersFactory;

class Delete extends \Magento\Backend\App\Action {

    /**
     * @var \Vgroup\SafetyHubApp\Model\CompaniesFactory
     */
   

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
	    Context $context,
	    \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
	parent::__construct($context);
	$this->resultPageFactory = $resultPageFactory;
	
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
   {
      $id = (int) $this->getRequest()->getParam('entity_id');
 
      if ($id) {
         /** @var $newsModel \Mageworld\SimpleNews\Model\News */
         $model = $this->usersFactory->create();
         $model->load($id);
		 //$model->delete();
		 // echo $model->getEntityId();
		 // exit;
 // print_r($model->getData());
 // exit;
         // Check this news exists or not
         if (!$model->getEntityId()) {
            $this->messageManager->addError(__('This news no longer exists.'));
         } else {
               try {
                  // Delete news
                  $model->delete();
                  $this->messageManager->addSuccess(__('The news has been deleted.'));
 
                  // Redirect to grid page
                  $this->_redirect('*/*/');
                  return;
				  
               } catch (\Exception $e) {
                   $this->messageManager->addError($e->getMessage());
                   $this->_redirect('*/*/edit', ['id' => $newsModel->getId()]);
               }
            }
      }
   }
}
