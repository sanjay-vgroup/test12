<?php

namespace Vgroup\SafetyHubApp\Model\Select\Requisitions\Status;

use Magento\Framework\Option\ArrayInterface;

class Options implements ArrayInterface {

    protected $options;

    public function toOptionArray() {

	$this->options = array(
	    '' => 'Select One',
	    1 => "Approved",
	    2 => "Pending",
	    3 => "Rejected",
	    4 => "Draft",
	    5 => "Fulfilled",
	    6 => "Partial Fulfilled"
	);

	return $this->options;
    }

}
