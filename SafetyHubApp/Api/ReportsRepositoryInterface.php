<?php

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api;

/**
 * Reports CRUD interface.
 * @api
 * @since 100.0.2
 */
interface ReportsRepositoryInterface {

    /**
     * Export User Safety Item List.
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\ReportInterface $report
     * @return bool
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function export(\Vgroup\SafetyHubApp\Api\Data\ReportInterface $report);
}
