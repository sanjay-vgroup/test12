<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api\Data;

/**
 * Safety item interface.
 * @api
 * @since 100.0.2
 */
interface SafetyItemsInterface {

    /**
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const ID = 'entity_id';
    const NAME = 'title';
    const TYPE = 'type';
    const MODEL_NUMBER = 'model_number';
    const SKU = 'sku';
    const UPC = 'upc';
    const DESCRIPTION = 'description';
    const IMAGE = 'image';
    const FILE = 'file';
    const LASTNAME = 'lastname';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    /**
     * Get Safety Item Id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set Safety Item Id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get Safety Item Name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set  Safety Item Name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Get Safety Item Type
     *
     * @return int|null
     */
    public function getType();

    /**
     * Set Safety Item Type
     *
     * @param int $type
     * @return $this
     */
    public function setType($type);

    /**
     * Get model number
     *
     * @return string|null
     */
    public function getModelNumber();

    /**
     * Set model number
     *
     * @param string $modelNumber
     * @return $this
     */
    public function setModelNumber($modelNumber);

    /**
     * Get created at time
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created at time
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated at time
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated at time
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get Sku
     *
     * @return string|null
     */
    public function getSku();

    /**
     * Set Sku
     *
     * @param string $sku
     * @return $this
     */
    public function setSku($sku);

    /**
     * Get upc
     *
     * @return string
     */
    public function getUpc();

    /**
     * Set upc
     *
     * @param string $upc
     * @return $this
     */
    public function setUpc($upc);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * Get image
     *
     * @return string
     */
    public function getImage();

    /**
     * Set image
     *
     * @param string $image
     * @return $this
     */
    public function setImage($image);

    /**
     * Get file
     *
     * @return string|null
     */
    public function getFile();

    /**
     * Set file
     *
     * @param string $file
     * @return $this
     */
    public function setFile($file);

    /**
     * Get status
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Set status
     *
     * @param int $status
     * @return $this
     */
    public function setStatus($status);

   
}
