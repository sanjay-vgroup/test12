<?php

namespace Vgroup\SafetyHubApp\Model;

class GetState {

    /**
     * @var \Magento\Directory\Api\CountryInformationAcquirerInterface
     */
    protected $countryInformationAcquirer;

    /**
     * Constructor call.
     * @param \Magento\Directory\Api\CountryInformationAcquirerInterface $countryInformationAcquirer
     */
    public function __construct(
    \Magento\Directory\Api\CountryInformationAcquirerInterface $countryInformationAcquirer
    ) {
        $this->countryInformationAcquirer = $countryInformationAcquirer;
    }

    /**
     * Just a simple example
     * @return array
     */
    public function getState($countryId) {
        $data = [];
        $countries = $this->countryInformationAcquirer->getCountriesInfo();
        foreach ($countries as $country) {
            if ($country->getId() == $countryId) { 
                $regions = [];
                if ($availableRegions = $country->getAvailableRegions()) {
                    foreach ($availableRegions as $region) {
                        $data[] = [
                            'code' => $region->getCode(),
                            'region_id' => $region->getId(),
                            'name' => $region->getName()
                        ];
                    }
                }
            }
        }

        return $data;
    }

}
