<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api\Data;

/**
 * Safety Item Product Search interface.
 * @api
 * @since 100.0.2
 */
interface SafetyItemProductsSearchInterface
{

    /**
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const NAME = 'name';
    const USER_SAFETY_ITEM_ID = 'user_safety_item_id';
    const MODEL_NUMBER = 'model_number';
    const SERIAL_NUMBER = 'serial_number';
    const NICKNAME = 'nickname';
    const SAFETY_ITEM_UPC = 'safety_item_upc';
    const STREET1 = 'street1';
    const STREET2 = 'street2';
    const CITY = 'city';
    const REGION_ID = 'region_id';
    const REGION_CODE = 'region_code';
    const REGION = 'region';
    const PRODUCT_ID = 'product_id';
    const ITEM_NAME = 'item_name';
    const QTY = 'qty';
    const FAO_PART = 'fao_part';
    const UPC = 'upc';
    const IS_ANSI_REFILL_PACK = 'is_ansi_refill_pack';
    const COMPANY_SKU = 'company_sku';
    const COMPANY_NAME = 'company_name';
    const CUSTOMER_ID = 'customer_id';
    const COMPANY_ID = 'company_id';
    const SAFETY_ITEM_TYPE = 'safety_item_type';
    const REQUISITION_ID = 'requisition_id';
    const IS_API = 'is_api';

    /**
     * Get Safety Item Name
     *
     * @return string
     */
    public function getSafetyItemName();

    /**
     * Set Safety Item Name
     *
     * @param string $name
     * @return $this
     */
    public function setSafetyItemName($name);

    /**
     * Get User Safety Item Id
     *
     * @return int
     */
    public function getUserSafetyItemId();

    /**
     * Set User Safety Item Id
     *
     * @param int $userSafetyItemId
     * @return $this
     */
    public function setUserSafetyItemId($userSafetyItemId);

    /**
     * Get Model Number
     *
     * @return string
     */
    public function getModelNumber();

    /**
     * Set Model Number
     *
     * @param string $modelNumber
     * @return $this
     */
    public function setModelNumber($modelNumber);

    /**
     * Get Serial Number
     *
     * @return string
     */
    public function getSerialNumber();

    /**
     * Set Serial Number
     *
     * @param string $serialNumber
     * @return $this
     */
    public function setSerialNumber($serialNumber);

    /**
     * Get Nickname
     *
     * @return string
     */
    public function getNickname();

    /**
     * Set Nickname
     *
     * @param string $nickname
     * @return $this
     */
    public function setNickname($nickname);

    /**
     * Get Safety Item Upc
     *
     * @return string
     */
    public function getSafetyItemUpc();

    /**
     * Set Safety Item Upc
     *
     * @param string $safetyItemUpc
     * @return $this
     */
    public function setSafetyItemUpc($safetyItemUpc);

    /**
     * Get Street 1
     *
     * @return string
     */
    public function getStreet1();

    /**
     * Set Street 1
     *
     * @param string $street1
     * @return $this
     */
    public function setStreet1($street1);

    /**
     * Get Street 2
     *
     * @return string
     */
    public function getStreet2();

    /**
     * Set Street 2
     *
     * @param string $street2
     * @return $this
     */
    public function setStreet2($street2);

    /**
     * Get City
     *
     * @return string
     */
    public function getCity();

    /**
     * Set Street 2
     *
     * @param string $city
     * @return $this
     */
    public function setCity($city);

    /**
     * Get Region Id
     *
     * @return int
     */
    public function getRegionId();

    /**
     * Set Region Id
     *
     * @param int $regionId
     * @return $this
     */
    public function setRegionId($regionId);

    /**
     * Get Region Code
     * 
     * @return string
     */
    public function getRegionCode();

    /**
     * Set Region Code
     *
     * @param string $regionCode
     * @return $this
     */
    public function setRegionCode($regionCode);

    /**
     * Get Region
     * 
     * @return string
     */
    public function getRegion();

    /**
     * Set Region
     *
     * @param string $region
     * @return $this
     */
    public function setRegion($region);

    /**
     * Get Safety Item Product Id
     *
     * @return int
     */
    public function getProductId();

    /**
     * Set Safety Item Product Id
     *
     * @param int $productId
     * @return $this
     */
    public function setProductId($productId);

    /**
     * Get Safety Item Product Name
     *
     * @return string
     */
    public function getItemName();

    /**
     * Set Safety Item Product Name
     *
     * @param string $productName
     * @return $this
     */
    public function setItemName($itemName);

    /**
     * Get Safety Item Product Qty
     *
     * @return int
     */
    public function getQty();

    /**
     * Set Safety Item Product Qty
     *
     * @param int $qty
     * @return $this
     */
    public function setQty($qty);

    /**
     * Get Safety Item Product SKU
     *
     * @return string
     */
    public function getFaoPart();

    /**
     * Set Safety Item Product SKU
     *
     * @param string $faoPart
     * @return $this
     */
    public function setFaoPart($faoPart);

    /**
     * Get Safety Item Product UPC
     *
     * @return string
     */
    public function getUpc();

    /**
     * Set Safety Item Product UPC
     *
     * @param string $upc
     * @return $this
     */
    public function setUpc($upc);

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
     * Get Safety Item Company Product Number
     *
     * @return string
     */
    public function getCompanySku();

    /**
     * Set Safety Item Product Number
     *
     * @param string $companySku
     * @return $this
     */
    public function setCompanySku($companySku);

    /**
     * Get Safety Item Company Product Name
     *
     * @return string
     */
    public function getCompanyName();

    /**
     * Set Safety Item Product Name
     *
     * @param string $companyName
     * @return $this
     */
    public function setCompanyName($companyName);
    /**
     * Get Customer Id
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set Customer Id
     *
     * @param string $customerId
     * @return $this
     */
    public function setCustomerId($customerId);
    /**
     * Get Company Id
     *
     * @return int
     */
    public function getCompanyId();

    /**
     * Set Company Id
     *
     * @param string $companyId
     * @return $this
     */
    public function setCompanyId($companyId);
    /**
     * Get Safety Item Type
     *
     * @return int
     */
    public function getSafetyItemType();

    /**
     * Set Safety Item Type
     *
     * @param string $safetyItemType
     * @return $this
     */
    public function setSafetyItemType($safetyItemType);
    /**
     * Get Requisition Id
     *
     * @return int
     */
    public function getRequisitionId();

    /**
     * Set  Requisition Id
     *
     * @param string $requisitionId
     * @return $this
     */
    public function setRequisitionId($requisitionId);
    /**
     * Get Is API
     *
     * @return int
     */
    public function getIsApi();

    /**
     * Set Is API
     *
     * @param string $isApi
     * @return $this
     */
    public function setIsApi($isApi);
}
