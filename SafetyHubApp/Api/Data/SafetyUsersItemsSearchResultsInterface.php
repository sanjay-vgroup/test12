<?php

namespace Vgroup\SafetyHubApp\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface SafetyUsersItemsSearchResultsInterface extends SearchResultsInterface {

    /**
     * Get safety items list.
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface[]
     */
    public function getItems();

    /**
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyUsersItemsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
