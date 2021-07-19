<?php

namespace Vgroup\SafetyHubApp\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface SafetyItemProductsSearchResultsInterface extends SearchResultsInterface {

    /**
     * Get Safety Item Products List.
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchInterface[]
     */
    public function getItems();

    /**
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyItemProductsSearchInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
