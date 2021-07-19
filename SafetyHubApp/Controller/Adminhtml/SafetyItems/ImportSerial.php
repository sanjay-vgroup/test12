<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\SafetyItems;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class ImportSerial extends \Magento\Backend\App\Action {
    /**
     * @var \Vgroup\SafetyHubApp\Model\ResourceModel\Companies\CollectionFactory
     */
    /**
     * @var PageFactory
     */
    protected $resultPageFactory = false;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
    Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute() {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Import Serial Numbers')));
        return $resultPage;
    }

}
