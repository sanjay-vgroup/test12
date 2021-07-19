<?php

namespace Vgroup\SafetyHubApp\Ui\Component\Listing\Column;

class Types implements \Magento\Framework\Option\ArrayInterface {

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray() {
	return [
	    ['value' => 1, 'label' => __('Cabinet')],
	    ['value' => 2, 'label' => __('Fire Exitinguisher')],
	    ['value' => 3, 'label' => __('AED')],
	    ['value' => 4, 'label' => __('Eyewash Stations')],
	    ['value' => 5, 'label' => __('Spill Control')]
	];
    }

}
