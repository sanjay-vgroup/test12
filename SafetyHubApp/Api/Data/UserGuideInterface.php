<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api\Data;

/**
 * Customer address interface.
 * @api
 * @since 100.0.2
 */
interface UserGuideInterface extends \Magento\Framework\Api\CustomAttributesDataInterface {

    const VERSION = 'version';
    const URL = 'url'; 

    /**
     * Get guide Version
     *
     * @return string|null
     */
    public function getVersion();

    /**
     * Set guide Version
     *
     * @param string $version
     * @return $this
     */
    public function setVersion($version);   
    
    /**
     * Get guide url
     *
     * @return string|null
     */
    public function getUrl();

    /**
     * Set guide url
     *
     * @param string $url
     * @return $this
     */
    public function setUrl($url);
}
