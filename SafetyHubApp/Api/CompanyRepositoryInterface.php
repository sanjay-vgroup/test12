<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api;

/**
 * Company CRUD interface.
 * @api
 * @since 100.0.2
 */
interface CompanyRepositoryInterface {

    /**
     * Get company by company ID.
     *
     * @param int $companyId
     * @return \Vgroup\SafetyHubApp\Api\Data\CompanyInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If customer with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($companyId);

    /**
     * Retrieve Company Labels List which match a specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param int $companyId
     * @return \Vgroup\SafetyHubApp\Api\Data\CompaniesSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getLabels(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, $companyId);
   
}
