<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api\Data;
/**
 * Response Interface.
 * @api
 * @since 100.0.2
 */
interface CommonResponseInterface {

    /**
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const STATUS = 'status';
    const MESSAGE = 'message';

    /**
     * Get Status
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set Status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get Message
     *
     * @return string
     */
    public function getMessage();

    /**
     * Set Message
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message);
}
