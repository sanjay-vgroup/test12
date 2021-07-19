<?php

/**
 * Copyright � Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Model;

use Vgroup\SafetyHubApp\Api\Data\UserGuideInterface;

/**
 * Class User Guide
 */
class UserGuide extends \Magento\Framework\Api\AbstractExtensibleObject implements UserGuideInterface {
    /**
     * Constant for confirmation status
     */

    /**
     * Get version id
     *
     * @return string|null
     */
    public function getVersion() {
	return $this->_get(self::VERSION);
    }

    /**
     * Set version id
     *
     * @param string $version
     * @return $this
     */
    public function setVersion($version) {
	return $this->setData(self::VERSION, $version);
    }

    /**
     * Get guide url
     *
     * @return string|null
     */
    public function getUrl() {
	return $this->_get(self::URL);
    }

    /**
     * Set guide url
     *
     * @param string $url
     * @return $this
     */
    public function setUrl($url) {
	return $this->setData(self::URL, $url);
    }

}
