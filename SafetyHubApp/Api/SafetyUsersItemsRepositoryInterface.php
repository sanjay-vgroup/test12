<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api;

/**
 * SafetyItemUsers CRUD interface.
 * @api
 * @since 100.0.2
 */
interface SafetyUsersItemsRepositoryInterface {

    /**
     * Create or update a Users Safety Items.
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface $safetyUserItem
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided email is already used
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface $safetyUserItem);

    /**
     * Get User SafetyItem by SafetyItem ID.
     *
     * @param int $id
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If SafetyItem with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * Retrieve User SafetyItems List which match a specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param int $customerId
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, $customerId);

    /**
     * Delete Users Safety Item Id.
     *
     * @param int $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);

    /**
     * Save Inventory and Save Inventory/Place Requisition .
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface $safetyUserItem
     * @param int $id
     * @param int $customerId
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided email is already used
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function saveInventory(\Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface $safetyUserItem, $id, $customerId);
    /**
     * Save Inventory and Save Inventory/Place Requisition .
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface $safetyUserItem
     * @return \Vgroup\SafetyHubApp\Api\Data\ResponseInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided email is already used
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function checkOk(\Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface $safetyUserItem);
}
