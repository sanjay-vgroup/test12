<?php

namespace Vgroup\SafetyHubApp\Ui\Component\Listing\Column;

class Website implements \Magento\Framework\Option\ArrayInterface {

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray() {
	return [['value' => 2, 'label' => __('First Aid Only')]];
    }

}
