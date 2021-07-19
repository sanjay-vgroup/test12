<?php

namespace Vgroup\SafetyHubApp\Ui\Component\Listing\Column;

class RequisitionStatus implements \Magento\Framework\Option\ArrayInterface {

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray() {
        return [
            ['value' => 1, 'label' => __('Approved')],
            ['value' => 2, 'label' => __('Pending')],
            ['value' => 3, 'label' => __('Rejected')],
            ['value' => 4, 'label' => __('Draft')],
            ['value' => 5, 'label' => __('Fulfilled')],
            ['value' => 6, 'label' => __('Partially Fulfilled')],
        ];
    }

}
