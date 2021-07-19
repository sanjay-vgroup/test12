<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api\Data;

/**
 * UserManagement interface.
 * @api
 * @since 100.0.2
 */
interface ResultInterface {

    /**
     * @return string|null
     */
    public function getStatus();

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * @return \Vgroup\SafetyHubApp\Api\Data\UserGuideInterface|null
     */
    public function getUserGuide();

    /**
     * Set user guide.
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\UserGuideInterface $guide
     * @return $this
     */
    public function setUserGuide(\Vgroup\SafetyHubApp\Api\Data\UserGuideInterface $guide);

    /**
     * @return \Vgroup\SafetyHubApp\Api\Data\CompanyInterface|null
     */
    public function getCompany();

    /**
     * @param \Vgroup\SafetyHubApp\Api\Data\CompanyInterface $companyInformation
     * @return $this
     */
    public function setCompany(\Vgroup\SafetyHubApp\Api\Data\CompanyInterface $companyInformation);

    /**
     * @return \Vgroup\SafetyHubApp\Api\Data\CompaniesSearchResultsInterface|null
     */
    public function getCompanyLabels();

    /**
     * @param \Vgroup\SafetyHubApp\Api\Data\CompaniesSearchResultsInterface $search
     * @return $this
     */
    public function setCompanyLabels(\Vgroup\SafetyHubApp\Api\Data\CompaniesSearchResultsInterface $search);
}
