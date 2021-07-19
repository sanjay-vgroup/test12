<?php

namespace Vgroup\SafetyHubApp\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface RequisitionsSearchResultsInterface extends SearchResultsInterface {

    /**
     * Get safety items list.
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface[]
     */
    public function getItems();

    /**
     * @param \Vgroup\SafetyHubApp\Api\Data\RequisitionsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
