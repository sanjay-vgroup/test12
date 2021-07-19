<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api\Data;

/**
 * Offline Sync Interface
 * @api
 * @since 100.0.2
 */
interface OfflineSyncInterface
{

    /**
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const CUSTOMER_ID = "customer_id";
    const COMPANY_ID = "company_id";
    const SAVE = 'save';
    const UPDATE = 'update';
    const DELETE = 'delete';
    const SAVE_INVENTORY = 'save_inventory';
    const UPDATE_PROFILE = 'update_profile';
    const PLACE = 'place';
    const RESTOCK = 'restock';

    /**
     * Get customer id
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set Customer Id
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * Get Company Id
     *
     * @return int
     */
    public function getCompanyId();

    /**
     * Set Company Id
     *
     * @param int $companyId
     * @return $this
     */
    public function setCompanyId($companyId);
    /**
     * Save User Safety Items
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface[]
     */
    public function getSave();

    /**
     * Save User Safety Items
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface[] $saveUserSafetyItems
     * @return $this
     */
    public function setSave(array $saveUserSafetyItems);

    /**
     * Update User Safety Items
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface[]
     */
    public function getUpdate();

    /**
     * Update User Safety Items
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface[] $updateUserSafetyItems
     * @return $this
     */
    public function setUpdate(array $updateUserSafetyItems);

    /**
     * Delete User Safety Items
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface[]
     */
    public function getDelete();

    /**
     * Delete User Safety Items
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface[] $deleteUserSafetyItems
     * @return $this
     */
    public function setDelete(array $deleteUserSafetyItems);

    /**
     * Get User Safety Items
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface[]
     */
    public function getSaveInventory();

    /**
     * Set User Safety Items
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface[] $inventoryUserSafetyItems
     * @return $this
     */
    public function setSaveInventory(array $inventoryUserSafetyItems);

    /**
     * Get Place
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface[]
     */
    public function getPlace();

    /**
     * Set Create
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface[] $requisition
     * @return $this
     */
    public function setPlace(array $requisition);

    /**
     * Get Restock
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface[]
     */
    public function getRestock();

    /**
     * Set Restock
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface[] $restockRequisition
     * @return $this
     */
    public function setRestock(array $restockRequisition);

    /**
     * Get Update User Profile
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    public function getUpdateProfile();

    /**
     * Set Update User Profile
     *
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @return $this
     */
    public function setUpdateProfile(array $customer);
}
