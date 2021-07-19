<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api\Data;

/**
 * Safety Item Products Interface.
 * @api
 * @since 100.0.2
 */
interface SafetyItemProductsInterface
{

    /**
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const PRODUCT_ID = 'product_id';
    const NAME = 'name';
    const QTY = 'qty';
    const RESTOCK_QTY = 'restock_qty';
    const IS_ANSI_REFILL_PACK = 'is_ansi_refill_pack';
    const PHYSICAL_INVENTORY_STATUS = 'physical_inventory_status';
    const ASIN = "asin";
    const DISABLE_EDITING = "disable_editing";
    const FAO_PART = "fao_part";
    const UPC = "upc";
    const UNIT_PRICE = "unit_price";
    const MAX_QTY = "max_qty";
    const CUSTOMER_PART_NUMBER = "customer_part_number";
    const IMAGE_URL = 'image_url';

    /**
     * Get product id
     *
     * @return int|null
     */
    public function getProductId();

    /**
     * Set product id
     *
     * @param int $id
     * @return $this
     */
    public function setProductId($productId);

    /**
     * Get product name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set product name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Get Product Qty
     *
     * @return int|null
     */
    public function getQty();

    /**
     * Set Product Qty
     *
     * @param int $qty
     * @return $this
     */
    public function setQty($qty);
    /**
     * Get Product Restock Qty
     *
     * @return int|null
     */
    public function getRestockQty();

    /**
     * Set Product Restock Qty
     *
     * @param int $restockQty
     * @return $this
     */
    public function setRestockQty($restockQty);

    /**
     * Get if Product is Ansi Refill Pack.
     *
     * @return bool
     */
    public function getIsAnsiRefillPack();

    /**
     * Set if Product is Ansi Refill Pack.
     *
     * @param bool $isAnsiRefillPack
     * @return $this
     */
    public function setIsAnsiRefillPack($isAnsiRefillPack);

    /**
     * Get Safety Item Product Physical Inventory Status
     *
     * @return int
     */
    public function getPhysicalInventoryStatus();

    /**
     * Set Safety Item Product Physical Inventory Status
     *
     * @param int $physicalInventoryStatus
     * @return $this
     */
    public function setPhysicalInventoryStatus($physicalInventoryStatus);

    /**
     * Get ASIN
     *
     * @return string
     */
    public function getAsin();

    /**
     * Set ASIN
     *
     * @param string $asin
     * @return $this
     */
    public function setAsin($asin);

    /**
     * Get Disable Editing
     *
     * @return int
     */
    public function getDisableEditing();

    /**
     * Set Disable Editing
     *
     * @param int $disableEditing
     * @return $this
     */
    public function setDisableEditing($disableEditing);

    /**
     * Get FAO Part
     *
     * @return string
     */
    public function getFaoPart();

    /**
     * Set FAO Part
     *
     * @param string $faoPart
     * @return $this
     */
    public function setFaoPart($faoPart);

    /**
     * Get UPC
     *
     * @return string
     */
    public function getUpc();

    /**
     * Set UPC
     *
     * @param string $upc
     * @return $this
     */
    public function setUpc($upc);

    /**
     * Get Unit Price
     *
     * @return string
     */
    public function getUnitPrice();

    /**
     * Set Unit Price
     *
     * @param string $unitPrice
     * @return $this
     */
    public function setUnitPrice($unitPrice);

    /**
     * Get Max Qty
     *
     * @return string
     */
    public function getMaxQty();

    /**
     * Set Unit Price
     *
     * @param string $maxQty
     * @return $this
     */
    public function setMaxQty($maxQty);

    /**
     * Get Customer Part Number
     *
     * @return string
     */
    public function getCustomerPartNumber();

    /**
     * Set Customer Part Number
     *
     * @param string $customerPartNumber
     * @return $this
     */
    public function setCustomerPartNumber($customerPartNumber);
    /**
     * Get Image URL
     *
     * @return string
     */
    public function getImageUrl();

    /**
     * Set Image URL
     *
     * @param string $imageUrl
     * @return $this
     */
    public function setImageUrl($imageUrl);
}
