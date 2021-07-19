<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Block\Account\Dashboard;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Dashboard Customer Info
 *
 * @api
 * @since 100.0.2
 */
class Info extends \Magento\Framework\View\Element\Template {

    /**
     * @var \Magento\Customer\Helper\View
     */
    protected $_helperView;

    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $currentCustomer;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param \Magento\Customer\Helper\View $helperView
     * @param array $data
     */
    public function __construct(
            \Magento\Framework\View\Element\Template\Context $context,
            \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
            \Magento\Customer\Helper\View $helperView,
            array $data = []
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->_helperView = $helperView;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    protected function _toHtml() {
        return $this->currentCustomer->getCustomerId() ? parent::_toHtml() : '';
    }

}
