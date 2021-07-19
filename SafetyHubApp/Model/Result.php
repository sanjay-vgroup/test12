<?php

/**
 * Copyright � Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Model;

use Vgroup\SafetyHubApp\Api\Data\ResultInterface;

/**
 * Class SysproOrderFlag
 */
class Result extends \Magento\Framework\Api\AbstractExtensibleObject implements ResultInterface {
    /*     * #@+
     * Constant for confirmation status
     */

    const KEY_STATUS = 'status';
    const USER_GUIDE = 'user_guide';

    /*     * #@- */

    /**
     * {@inheritdoc}
     */
    public function getStatus() {
	return $this->_get(self::KEY_STATUS);
    }

    /**
     * @param \Vgroup\SafetyHubApp\Api\Data\UserGuideInterface $status
     * @return $this
     */
    public function setStatus($status) {
	return $this->setData(self::KEY_STATUS, $status);
    }

    /**
     * Get user guide.
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\UserGuideInterface|null
     */
    public function getUserGuide() {
	return $this->_get(self::USER_GUIDE);
    }

    /**
     * Set user guide.
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\UserGuideInterface $guide
     * @return $this
     */
    public function setUserGuide(\Vgroup\SafetyHubApp\Api\Data\UserGuideInterface $guide) {
	return $this->setData(self::USER_GUIDE, $guide);
    }

    /**
     * @return \Vgroup\SafetyHubApp\Api\Data\CompanyInterface|null
     */
    public function getCompany() {
	return $this->_get('company');
    }

    /**
     * @param \Vgroup\SafetyHubApp\Api\Data\CompanyInterface $companyInformation
     * @return $this
     */
    public function setCompany(\Vgroup\SafetyHubApp\Api\Data\CompanyInterface $companyInformation) {
	$this->setData('company', $companyInformation);
	return $this;
    }

    /**
     * @return \Vgroup\SafetyHubApp\Api\Data\CompaniesSearchResultsInterface|null
     */
    public function getCompanyLabels() {
	return $this->_get('company_labels');
    }

    /**
     * @param \Vgroup\SafetyHubApp\Api\Data\CompaniesSearchResultsInterface $search
     * @return $this
     */
    public function setCompanyLabels(\Vgroup\SafetyHubApp\Api\Data\CompaniesSearchResultsInterface $search) {
	$this->setData('company_labels', $search);
	return $this;
    }

}
