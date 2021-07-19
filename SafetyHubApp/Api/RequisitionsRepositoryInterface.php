<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api;

/**
 * Requisition CRUD interface.
 * @api
 * @since 100.0.2
 */
interface RequisitionsRepositoryInterface
{

    /**
     * Create or update a requisition.
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface $requisition
     * @return \Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function place(\Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface $requisition);

    /**
     * Get requisitions by requisitions ID.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param int $id
     * @param int $customerId
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchResultsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If customer with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, $id, $customerId);

    /**
     * Retrieve requisitions which match a specified criteria.
     *
     * This call returns an array of objects, but detailed information about each object’s attributes might not be
     * included.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Vgroup\SafetyHubApp\Api\Data\RequisitionsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete requisitions by Requisitions ID.
     *
     * @param int $requisitionsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($requisitionsId);

    /**
     * Move to Draft.
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface $requisition
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchResultsInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function moveToDraft(\Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface $requisition);
    /**
     * Remove Item from Draft.
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface $requisition
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchResultsInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function removeDraftItems(\Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface $requisition);
    /**
     * Create or update a requisition.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param int $id
     * @param string $modelNumber
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchResultsInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function placetest(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,$id,$modelNumber);
}
