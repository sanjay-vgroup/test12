<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Vgroup\SafetyHubApp\Model;

use Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with Customer search results.
 */
class SafetyItemProductsSearchResults extends SearchResults implements SafetyItemProductsSearchResultsInterface {
    
}
