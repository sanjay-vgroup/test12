<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Companies;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\TestFramework\ErrorLog\Logger;
use Vgroup\SafetyHubApp\Model\CompanyFactory;

class Save extends \Magento\Backend\App\Action {

    /**
     * @var \Magento\Backend\Helper\Js
     */
    protected $_jsHelper;

    /**
     * @var \Webspeaks\ProductsGrid\Model\ResourceModel\Contact\CollectionFactory
     */
    protected $_contactCollectionFactory;

    /**
     * @var \Vgroup\SafetyHubApp\Model\CompaniesFactory
     */
    protected $_companyFactory;

	protected $request;

    /**
     * \Magento\Backend\Helper\Js $jsHelper
     * @param Action\Context $context
     */
    public function __construct(
	    Context $context,
	    \Magento\Backend\Helper\Js $jsHelper,
	    \Vgroup\SafetyHubApp\Model\ResourceModel\Companies\CollectionFactory $contactCollectionFactory,
	    CompanyFactory $company,
		\Magento\Framework\App\Request\Http $request
    ) {
	$this->_jsHelper = $jsHelper;
	$this->_contactCollectionFactory = $contactCollectionFactory;
	$this->_companyFactory = $company;
	$this->request = $request;
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
        $companyPostData = $data['company'];
        $permissionType = $data['permission_type'];
        $permission = (isset($data['resource']) && count($data['resource']) > 0) ? $data['resource'] : [];
//        print_r($permission);
//        exit;
             if ($data) {
                 
			/** @var \Vgroup\SafetyHubApp\Model\CompaniesFactory $company */
			$company = $this->_companyFactory->create();
			
			if (isset($companyPostData['entity_id']) && $companyPostData['entity_id']) {
				$id = $companyPostData['entity_id'];

				$company->load($id, 'entity_id');
				//print_r($company->getData());
				//exit;
				// $company->setId($id);
				$msg =  'Company Updated Successfully.';
			} else {
				$msg = 'Company Inserted Successfully.';
			}
			
			$companyPostData['preferred_distributors'] = (isset($companyPostData['preferred_distributors']) && count($companyPostData['preferred_distributors']) > 0 ) ? implode(',', $companyPostData['preferred_distributors']) : '';
			$companyPostData['permission_type'] = $permissionType;
                        $companyPostData['permissions'] = ($permission && count($permission) >0) ? implode(',',$permission) : '';
                        $company->setData($companyPostData);

			try {
				$company->save();
		
				$this->messageManager->addSuccess(__($msg));
				if ($this->getRequest()->getParam('back')) {
					return $resultRedirect->setPath('*/*/edit', ['entity_id' => $company->getId(), '_current' => true]);
				}
				return $resultRedirect->setPath('*/*/');
			} catch (\Magento\Framework\Exception\LocalizedException $e) {
				$this->messageManager->addError($e->getMessage());
			} catch (\RuntimeException $e) {
				$this->messageManager->addError($e->getMessage());
			} catch (\Exception $e) {
				$this->messageManager->addException($e, __('Something went wrong while saving the company.'));
			}

			$this->_getSession()->setFormData($data);
			return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
		}
		return $resultRedirect->setPath('*/*/');
    }
}
