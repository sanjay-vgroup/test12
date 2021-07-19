<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api;

/**
 * SafetyItem CRUD interface.
 * @api
 * @since 100.0.2
 */
interface SafetyItemsRepositoryInterface {

    /**
     * Create or update a Safety Item.
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyItemsInterface $safetyItem
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemsInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided email is already used
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Vgroup\SafetyHubApp\Api\Data\SafetyItemsInterface $safetyItem);

    /**
     * Get Safety Item by Safety Item ID.
     *
     * @param int $safetyItemId
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If customer with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($safetyItemId);

    /**
     * Retrieve Safety Item which match a specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterfae $searchCriteria
     * @param int $customerId
     * @param int $isApi
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, $customerId,$isApi);

    /**
     * Delete Safety Item by Safety Item ID.
     *
     * @param int $safetyItemId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($safetyItemId);
}
