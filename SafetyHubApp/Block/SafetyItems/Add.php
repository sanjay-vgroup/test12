<?php

/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Block\SafetyItems;

use Magento\Framework\View\Element\Template;

/**
 * Main contact form block
 */
class Add extends Template {

    protected $safetyItems;

    /**
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
	    Template\Context $context,
	    \Vgroup\SafetyHubApp\Model\SafetyItemsFactory $safetyItems,
	    array $data = []) {
	parent::__construct($context, $data);
	$this->_isScopePrivate = true;
	$this->safetyItems = $safetyItems;
    }

    public function getSafetyItemsData() {
	$getSafetyItems = $this->safetyItems->create();
	$getItems = $getSafetyItems->getCollection();
	$select = $getItems->addFieldToSelect('model_number');
	// $data = $select->getData();
	return $select;
    }

}
