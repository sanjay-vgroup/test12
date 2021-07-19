<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api;

use Magento\Framework\Exception\InputException;

/**
 * Interface for managing customers accounts.
 * @api
 * @since 100.0.2
 */
interface AccountManagementInterface {

    /**
     * Change customer password.
     *
     * @param int $customerId
     * @param string $currentPassword
     * @param string $newPassword
     * @return \Vgroup\SafetyHubApp\Api\Data\CommonResponseInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function changePasswordById($customerId, $currentPassword, $newPassword);

    /**
     * Send an email to the customer with a password reset link.
     *
     * @param string $email
     * @param string $template
     * @param int $websiteId
     * @return \Vgroup\SafetyHubApp\Api\Data\CommonResponseInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function initiatePasswordReset($email, $template, $websiteId = null);
}
