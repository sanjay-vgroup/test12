<?php

namespace Vgroup\SafetyHubApp\Api;

interface CountryStateInterface {

    /**
     * Get country and region information for the store.
     *
     * @param string $countryId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return \Magento\Directory\Api\Data\CountryInformationInterface
     */
    public function getState($countryId); 
}
