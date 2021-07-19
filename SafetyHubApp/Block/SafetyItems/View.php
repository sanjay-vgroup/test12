<?php

namespace Vgroup\SafetyHubApp\Block\SafetyItems;

use Magento\Store\Model\StoreManagerInterface;

class View extends \Magento\Framework\View\Element\Template {

    protected $_pageFactory;
    protected $_coreRegistry = null;
    protected $_safetyUsersItemsFactory;
    protected $_request;
    protected $productCollectionFactory;
    protected $_template = 'Vgroup_SafetyHubApp::safetyitems/view.phtml';

    public function __construct(
	    \Magento\Framework\View\Element\Template\Context $context,
	    \Magento\Framework\View\Result\PageFactory $pageFactory,
	    \Magento\Framework\Registry $coreRegistry,
	    \Vgroup\SafetyHubApp\Model\SafetyUsersItemsFactory $safetyUsersItemsFactory,
	    \Magento\Framework\App\Request\Http $request,
	    \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
	    array $data = []
    ) {
	$this->_pageFactory = $pageFactory;
	$this->_coreRegistry = $coreRegistry;
	$this->_request = $request;
	$this->__safetyUsersItemsFactory = $safetyUsersItemsFactory;
	$this->productCollectionFactory = $productCollectionFactory;

	return parent::__construct($context, $data);
    }

    public function execute() {

	return $this->_pageFactory->create();
    }

    public function getViewRecords() {

	$id = $this->getRequest()->getParam('entity_id');
	$post = $this->__safetyUsersItemsFactory->create()->getCollection()->addFieldToFilter('main_table.entity_id', $id);
	$result = $post->fetchItem();
	// $result = $post->load($id);
	return $result;
    }

    public function getProductCollection() {
	$id = $this->getRequest()->getParam('entity_id');
	$post = $this->__safetyUsersItemsFactory->create();
	$result = $post->load($id);

	$collection = $this->productCollectionFactory->create();

	$joinConditions = 'safetyhubapp_items_products.product_id = e.entity_id';

	$collection->addAttributeToSelect('*');
	$collection->getSelect()->join(
		['safetyhubapp_items_products' => $collection->getTable('safetyhubapp_items_products')],
		$joinConditions,
		[]
	)->columns("safetyhubapp_items_products.qty");

	return $collection;
    }

}
