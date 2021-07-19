<?php

namespace Vgroup\SafetyHubApp\Controller\Adminhtml\SafetyItems;

use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;

class SerialNumbersGrid extends \Magento\Backend\App\Action
{

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $_resultLayoutFactory;

    /**
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     * @param Action\Context $context
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
    ) {
        parent::__construct($context);
        $this->_resultLayoutFactory = $resultLayoutFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
        $resultLayout->getLayout()->getBlock('safetyhubapp.safetyitems.edit.tab.serialnumbers')
                ->setInSerialNumbers($this->getRequest()->getPost('safetyitems_serialnumbers', null));

        return $resultLayout;
    }

}
