<?php

namespace Vgroup\SafetyHubApp\Ui\Component\Listing\Column;

use Vgroup\SafetyHubApp\Model\ResourceModel\Companies\CollectionFactory;

class Companies implements \Magento\Framework\Option\ArrayInterface {

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

	$companies = [];
	$collection = $this->collectionFactory->create()->addFieldToSelect('entity_id')->addFieldToSelect('name')->addFieldToSelect('name')->addFieldToFilter('status', 1);
	if ($collection) {
            $companies[] = ['value' => '', 'label' => __('First Aid Only')];
	    foreach ($collection as $company) {
		$companies[] = ['value' => $company->getEntityId(), 'label' => __($company->getName())];
	    }
	    return $companies;
	}
    }

}
