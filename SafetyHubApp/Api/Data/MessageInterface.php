<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api\Data;

/**
 * Error Message Interface.
 * @api
 * @since 100.0.2
 */
interface MessageInterface {

    /**
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const REQUEST_ID = 'id';
    const MSG = 'msg';
    const TYPE = 'type';
    const STATUS = 'status';

    /**
     * Get Request Id
     *
     * @return int
     */
    public function getRequestId();

    /**
     * Set Request Id
     *
     * @param int|null $requestId
     * @return $this
     */
    public function setRequestId($requestId);

    /**
     * Get Message
     *
     * @return string
     */
    public function getMsg();

    /**
     * Set Message
     *
     * @param string|null $msg
     * @return $this
     */
    public function setMsg($msg);

    /**
     * Get Type
     *
     * @return string
     */
    public function getType();

    /**
     * Set Type
     *
     * @param string|null $type
     * @return $this
     */
    public function setType($type);

    /**
     * Get Status
     *
     * @return int
     */
    public function getStatus();

    /**
     * Set Status
     *
     * @param int|null $status
     * @return $this
     */
    public function setStatus($status);
}
