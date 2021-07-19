<?php

namespace Vgroup\SafetyHubApp\Model\Select\SafetyItemsTypes;

use Magento\Framework\Option\ArrayInterface;

class Options implements ArrayInterface {

    protected $options;

    public function toOptionArray() {

	$this->options = array(
	    '' => 'Select One',
	    '1' => "Cabinet",
	    '2' => "Fire Exitinguisher",
	    '3' => "AED",
	    '4' => "Eyewash Stations",
	    '5' => "Spill Control"
	);

	return $this->options;
    }

}
