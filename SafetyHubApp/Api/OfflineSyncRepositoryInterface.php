<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api;

/**
 * Offline Sync interface.
 * @api
 * @since 100.0.2
 */
interface OfflineSyncRepositoryInterface
{

    /**
     * Create or update a Safety Item.
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\OfflineSyncInterface $offlineSync
     * @return \Vgroup\SafetyHubApp\Api\Data\ResponseInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function sync(\Vgroup\SafetyHubApp\Api\Data\OfflineSyncInterface $offlineSync);
    /**
     * Create or update a Safety Item.
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\ResponseInterface $response
     * @return \Vgroup\SafetyHubApp\Api\Data\ResponseInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function sendMail(\Vgroup\SafetyHubApp\Api\Data\ResponseInterface $response);
}
