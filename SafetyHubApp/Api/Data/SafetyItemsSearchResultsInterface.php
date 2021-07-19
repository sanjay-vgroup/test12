<?php

namespace Vgroup\SafetyHubApp\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface SafetyItemsSearchResultsInterface extends SearchResultsInterface {

    /**
     * Get safety items list.
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemsInterface[]
     */
    public function getItems();

    /**
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyItemsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
