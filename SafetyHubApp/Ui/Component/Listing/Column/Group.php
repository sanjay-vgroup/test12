<?php

namespace Vgroup\SafetyHubApp\Ui\Component\Listing\Column;

use Vgroup\SafetyHubApp\Model\ResourceModel\SafetyUsers\CollectionFactory;

class Group implements \Magento\Framework\Option\ArrayInterface {

    /**
     * @var \Vgroup\SafetyHubApp\Model\ResourceModel\Companies\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * \Magento\Backend\Helper\Js $jsHelper
     * @param Action\Context $context
     */
    public function __construct(CollectionFactory $collectionFactory) {
	$this->collectionFactory = $collectionFactory;
    }

    /**
     * Options getter
     *
     * @return array
     */
public function toOptionArray() {
	return [
	    ['value' => 4, 'label' => __('FAO_APP')],
            
	];
    }

}
