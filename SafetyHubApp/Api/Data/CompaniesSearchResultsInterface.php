<?php

namespace Vgroup\SafetyHubApp\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface CompaniesSearchResultsInterface extends SearchResultsInterface {

    /**
     * Get safety items list.
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\CompanyLabelsInterface[]
     */
    public function getItems();

    /**
     * @param \Vgroup\SafetyHubApp\Api\Data\CompanyLabelsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
