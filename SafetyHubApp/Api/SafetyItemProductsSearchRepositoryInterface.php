<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api;

/**
 * SafetyItem Products Search interface.
 * @api
 * @since 100.0.2
 */
interface SafetyItemProductsSearchRepositoryInterface {

    /**
     * Retrieve Safety Item Products which match a specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterfae $searchCriteria
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchInterface $customFilter
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,\Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchInterface $customFilter);
}
