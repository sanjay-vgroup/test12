<?php

namespace Vgroup\SafetyHubApp\Ui\Component\Listing\Column;

class PermissionType implements \Magento\Framework\Option\ArrayInterface {

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray() {
	return [
	    ['value' => 1, 'label' => __('Specific Permissions')],
	    ['value' => 2, 'label' => __('Admin Group')],
	    ['value' => 3, 'label' => __('All Permissions')],
             ['value' => null, 'label' => __('no Permissions')],
	    
	];
    }

}
