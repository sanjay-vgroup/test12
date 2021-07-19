<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api;

/**
 * Interface providing token generation for Customers
 *
 * @api
 * @since 100.0.2
 */
interface CustomerTokenServiceInterface {

    /**
     * Create access token for admin given the customer credentials.
     *
     * @param string $username
     * @param string $password
     * @param string $device_token
     * @param string $app_id
     * @param string $version
     * @return string Token created
     * @throws \Magento\Framework\Exception\AuthenticationException
     */
    public function createCustomerAccessToken($username, $password, $device_token = NULL, $app_id = NULL, $version = NULL);

    /**
     * Revoke token by customer id.
     *
     * @param int $customerId
     * @param string $device_token
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function revokeCustomerAccessToken($customerId, $device_token = NULL);
    
    /**
     * Add device token.
     *
     * @param string $customer_id
     * @param string $device_token     
     * @param string $app_id
     * @return bool  
     * @throws \Magento\Framework\Exception\AuthenticationException
     */
    public function addDeviceToken($customer_id, $device_token = NULL, $app_id = NULL);

}
