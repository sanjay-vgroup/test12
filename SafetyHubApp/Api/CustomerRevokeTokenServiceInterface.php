<?php

namespace Vgroup\SafetyHubApp\Api;
/**
 * Interface CustomerRevokeTokenServiceInterface
 * @package Vgroup\SafetyHubApp\Api
 */
interface  CustomerRevokeTokenServiceInterface 
{
    /**
     * Revoke token by customer id.
     *
     * @api
     * @param int $customerId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function revokeCustomerAccessToken($customerId);
}