<?php

namespace Vgroup\SafetyHubApp\Block\SafetyItems;

use Vgroup\SafetyHubApp\Ui\Component\Listing\Column\Types;

class Edit extends \Magento\Framework\View\Element\Template {

    protected $_pageFactory;
    protected $_coreRegistry;
    protected $_safetyUsersItemsFactory;
    protected $_request;
    protected $_regionCollectionFactory;
    protected $__countryCollectionFactor;
    protected $__typesFactory;

    public function __construct(
	    Types $typesFactory,
	    \Magento\Framework\View\Element\Template\Context $context,
	    \Magento\Framework\View\Result\PageFactory $pageFactory,
	    \Magento\Framework\Registry $coreRegistry,
	    \Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory $safetyUsersItemsFactory,
	    \Magento\Framework\App\Request\Http $request,
	    \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regionCollectionFactory,
	    \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory,
	    \Magento\Framework\ObjectManagerInterface $objectManager,
	    array $data = []
    ) {
	$this->_pageFactory = $pageFactory;
	$this->_coreRegistry = $coreRegistry;
	$this->_request = $request;
	$this->__safetyUsersItemsFactory = $safetyUsersItemsFactory;
	$this->__regionCollectionFactory = $regionCollectionFactory;
	$this->__countryCollectionFactory = $countryCollectionFactory;
	$this->_objectManager = $objectManager;
	$this->__typesFactory = $typesFactory;
	return parent::__construct($context, $data);
    }

    public function execute() {

	return $this->_pageFactory->create();
    }

    public function getEditRecords() {

	$id = $this->getRequest()->getParam('entity_id');
	$post = $this->__safetyUsersItemsFactory->create();
	$result = $post->load($id);
	return $result;
    }

    public function getTypes() {

	$safetyitemsTypes = $this->__typesFactory->create()->toOptionArray();

	// $safetyitemsTypes = $this->_objectManager->create(
	//      'Vgroup\SafetyHubApp\Ui\Component\Listing\Column\Types'
	//  )->toOptionArray();

	return $safetyitemsTypes;
	// return json_encode($safetyitemsTypes);
    }

    public function getSafetyItems() {
	return $this->getRequest()->getParam('entity_id');
    }

}
