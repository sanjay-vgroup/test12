<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Vgroup\SafetyHubApp\Model;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * @api
 * @since 100.1.0
 */
interface EmailNotificationInterface
{
    /**
     * Constants for the type of new account email to be sent
     */
    const NEW_ACCOUNT_EMAIL_REGISTERED = 'registered';

    /**
     * Welcome email, when password setting is required
     */
    const NEW_ACCOUNT_EMAIL_REGISTERED_NO_PASSWORD = 'registered_no_password';

    /**
     * Welcome email, when confirmation is enabled
     */
    const NEW_ACCOUNT_EMAIL_CONFIRMATION = 'confirmation';

    /**
     * Confirmation email, when account is confirmed
     */
    const NEW_ACCOUNT_EMAIL_CONFIRMED = 'confirmed';

     /**
     * Send email with new customer password
     *
     * @param CustomerInterface $customer
     * @return void
     * @since 100.1.0
     */
    public function passwordReminder(CustomerInterface $customer);

    /**
     * Send email with reset password confirmation link
     *
     * @param CustomerInterface $customer
     * @return void
     * @since 100.1.0
     */
    public function passwordResetConfirmation(CustomerInterface $customer);

}
