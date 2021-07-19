<?php

namespace Vgroup\SafetyHubApp\Plugin;

class LoginPostPlugin {

    /**
     * Change redirect after login to home instead of dashboard.
     *
     * @param \Magento\Customer\Controller\Account $subject
     * @param \Magento\Framework\Controller\Result\Redirect $result
     */
    public function afterExecute(\Magento\Customer\Controller\Account\LoginPost $subject, $result) {
	$result->setPath('safetyhubapp/account/index');
	return $result;
    }

}
