<?php

namespace Vgroup\SafetyHubApp\Ui\Component\Listing\Column;

use Vgroup\SafetyHubApp\Model\ResourceModel\SafetyUsers\CollectionFactory;

class Permission implements \Magento\Framework\Option\ArrayInterface {

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
	    ['value' => 2, 'label' => __('Admin')],
            ['value' => 1, 'label' => __('Enterprise User')],
             ['value' => 3, 'label' => __('Standard User')]
	];
    }

}
