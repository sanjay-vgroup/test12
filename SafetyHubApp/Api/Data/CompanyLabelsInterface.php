<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api\Data;

/**
 * Company Labels Interface.
 * @api
 * @since 100.0.2
 */
interface CompanyLabelsInterface extends \Magento\Framework\Api\ExtensibleDataInterface {

    /**
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const ID = 'id';
    const IDENTIFIER = 'identifier';
    const DEFAULT_LABEL = 'default_label';
    const COMPANY_LABEL = 'company_label';
    const COMPANY_ID = 'company_id';
    const DEVICE_TYPE = 'device_type';

    /**

      /**
     * Get Id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set Id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get Identifier
     *
     * @return string|null
     */
    public function getIdentifier();

    /**
     * Set Identifier
     *
     * @param string $identifier
     * @return $this
     */
    public function setIdentifier($identifier);

    /**
     * Get Default Label
     *
     * @return string|null
     */
    public function getDefaultLabel();

    /**
     * Set Default Label
     *
     * @param string $defaultLabel
     * @return $this
     */
    public function setDefaultLabel($defaultLabel);

    /**
     * Get CompanyLabel
     *
     * @return string|null
     */
    public function getCompanyLabel();

    /**
     * Set Company Label
     *
     * @param string $companyLabel
     * @return $this
     */
    public function setCompanyLabel($companyLabel);

    /**
     * Get  Company Id
     *
     * @return int|null
     */
    public function getCompanyId();

    /**
     * Set Company Id
     *
     * @param int $companyId
     * @return $this
     */
    public function setCompanyId($companyId);

    /**
     * Get Device Type
     *
     * @return int|null
     */
    public function getDeviceType();

    /**
     * Set Device Type
     *
     * @param int $deviceType
     * @return $this
     */
    public function setDeviceType($deviceType);

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\CompanyLabelsExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\CompanyLabelsExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
	    \Vgroup\SafetyHubApp\Api\Data\CompanyLabelsExtensionInterface $extensionAttributes
    );
}
