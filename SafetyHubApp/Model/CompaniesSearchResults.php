<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Vgroup\SafetyHubApp\Model;

use Vgroup\SafetyHubApp\Api\Data\CompaniesSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with Customer search results.
 */
class CompaniesSearchResults extends SearchResults implements CompaniesSearchResultsInterface {
}