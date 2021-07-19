<?php

/**
 * Copyright Â© Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api\Data;

/**
 * Interface \Vgroup\SafetyHubApp\Api\Data\CustomerActionMethodInterface
 *
 */
interface CustomerActionMethodInterface {

    const SAVE = 'save';
    const UPDATE = 'update';
    const DELETE = 'delete';

    /**
     * Get Save
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface[]
     */
    public function getSave();

    /**
     * Set Save
     *
     * @param \Magento\Customer\Api\Data\CustomerInterface[] $save
     * @return $this
     */
    public function setSave(array $save);

    /**
     * Get Save
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface[]
     */
    public function getUpdate();

    /**
     * Set Save
     *
     * @param \Magento\Customer\Api\Data\CustomerInterface[] $update
     * @return $this
     */
    public function setUpdate(array $update);

    /**
     * Get Save
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface[]
     */
    public function getDelete();

    /**
     * Set Save
     *
     * @param \Magento\Customer\Api\Data\CustomerInterface[] $delete
     * @return $this
     */
    public function setDelete(array $delete);
}
