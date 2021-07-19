<?php

namespace Vgroup\SafetyHubApp\Model;

use Magento\Framework\DataObject\IdentityInterface;

class SafetyItems extends \Magento\Framework\Model\AbstractModel implements IdentityInterface {

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'safetyhubapp_items';

    /**
     * @var string
     */
    protected $_cacheTag = 'safetyhubapp_items';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'safetyhubapp_items';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct() {

        $this->_init('Vgroup\SafetyHubApp\Model\ResourceModel\SafetyItems');
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities() {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getProductsOnly(\Vgroup\SafetyHubApp\Model\SafetyItems $object) {
        $tbl = $this->getResource()->getTable(\Vgroup\SafetyHubApp\Model\ResourceModel\SafetyItems::TBL_ATT_PRODUCT);
        $select = $this->getResource()->getConnection()->select()->from(
                        $tbl, ['product_id', 'qty']
                )
                ->where(
                'row_id = ?', (int) $object->getId()
        );
        return $this->getResource()->getConnection()->fetchAll($select);
    }

    public function getProducts(\Vgroup\SafetyHubApp\Model\SafetyItems $object, $columns, $userSafetyItem = 0) {

        $tbl = $this->getResource()->getTable(\Vgroup\SafetyHubApp\Model\ResourceModel\SafetyItems::TBL_ATT_PRODUCT);

        $select = $this->getResource()->getConnection()->select()->from(
                        $tbl, $columns
                )->where(
                $tbl . '.row_id = ?', (int) $object->getId()
        );

        $select->joinLeft(['catalog_product_entity_fao_part' => 'catalog_product_entity'], 'safetyhubapp_items_products.product_id = catalog_product_entity_fao_part.row_id', ['fao_part' => 'catalog_product_entity_fao_part.sku']
        );

        $select->joinLeft(['catalog_product_entity_varchar' => 'catalog_product_entity_varchar'], 'safetyhubapp_items_products.product_id = catalog_product_entity_varchar.row_id AND catalog_product_entity_varchar.attribute_id = 71', ['name' => 'catalog_product_entity_varchar.value']
        );

        $select->joinLeft(['catalog_product_entity_ansi' => 'catalog_product_entity_int'], 'safetyhubapp_items_products.product_id = catalog_product_entity_ansi.row_id AND catalog_product_entity_ansi.attribute_id = 187 AND catalog_product_entity_ansi.store_id = 2', ['is_ansi_refill_pack' => 'catalog_product_entity_ansi.value']
        );

        $select->joinLeft(['catalog_product_entity_asin' => 'catalog_product_entity_varchar'], 'safetyhubapp_items_products.product_id = catalog_product_entity_ansi.row_id AND catalog_product_entity_ansi.attribute_id = 147 AND catalog_product_entity_ansi.store_id = 2', ['asin' => 'catalog_product_entity_asin.value']
        );

        $select->joinLeft(['catalog_product_entity_customer_part_number' => 'catalog_product_entity_varchar'], 'safetyhubapp_items_products.product_id = catalog_product_entity_customer_part_number.row_id AND catalog_product_entity_ansi.attribute_id = 179 AND catalog_product_entity_ansi.store_id = 2', ['customer_part_number' => 'catalog_product_entity_customer_part_number.value']
        );

        $select->joinLeft(['catalog_product_entity_disable_editing' => 'catalog_product_entity_varchar'], 'safetyhubapp_items_products.product_id = catalog_product_entity_disable_editing.row_id AND catalog_product_entity_ansi.attribute_id = 221 AND catalog_product_entity_ansi.store_id = 2', ['disable_editing' => 'IFNULL(catalog_product_entity_disable_editing.value,0)']
        );

        $select->joinLeft(['catalog_product_entity_image' => 'catalog_product_entity_varchar'], 'safetyhubapp_items_products.product_id = catalog_product_entity_ansi.row_id AND catalog_product_entity_ansi.attribute_id = 85 AND catalog_product_entity_ansi.store_id = 2', ['image_url' => 'catalog_product_entity_image.value']
        );

        $select->joinLeft(['catalog_product_entity_upc' => 'catalog_product_entity_varchar'], 'safetyhubapp_items_products.product_id = catalog_product_entity_upc.row_id AND catalog_product_entity_ansi.attribute_id = 134 AND catalog_product_entity_ansi.store_id = 2', ['upc' => 'catalog_product_entity_upc.value']
        );


        $select->joinLeft(['catalog_product_entity_unit_price' => 'catalog_product_entity_decimal'], 'safetyhubapp_items_products.product_id = catalog_product_entity_unit_price.row_id AND catalog_product_entity_ansi.attribute_id = 75 AND catalog_product_entity_ansi.store_id = 2', ['unit_price' => 'catalog_product_entity_unit_price.value']
        );

        if ($userSafetyItem != 0) {
            $select->joinLeft(['safetyhubapp_physicalinventory' => 'safetyhubapp_physicalinventory'], 'safetyhubapp_items_products.product_id = safetyhubapp_physicalinventory.product_id AND safetyhubapp_physicalinventory.row_id =' . $userSafetyItem, ['physical_inventory_status' => 'IFNULL(`safetyhubapp_physicalinventory`.`status`,1)']
            );
        }

        $select->group('safetyhubapp_items_products.product_id');
        //echo $select;
        if (count($columns) > 1)
            return $this->getResource()->getConnection()->fetchAll($select);
        else
            return $this->getResource()->getConnection()->fetchCol($select);
    }

    public function getMetaData(\Vgroup\SafetyHubApp\Model\SafetyItems $object, $customerId) {


        $columns = ['nickname', 'street1', 'street2', 'city', 'region'];
        $tbl = $this->getResource()->getTable('safetyhubapp_users_items');

        $select = $this->getResource()->getConnection()->select()->from(
                        $tbl, ['nickname']
                )->where($tbl . '.customer_id = ?', (int) $customerId)
                ->where($tbl . '.model_number = ?', (string) $object->getModelNumber())
                ->where($tbl . '.nickname != ?', 'NULL');

        $select->group($tbl . '.nickname');
        //echo $select;

        $nicknames = $this->getResource()->getConnection()->fetchCol($select);
//	
//	$columns = ['nickname', 'street1', 'street2', 'city', 'region'];
//	$tbl = $this->getResource()->getTable('safetyhubapp_users_items');

        $select = $this->getResource()->getConnection()->select()->from(
                        $tbl, ['street1', 'street2', 'city', 'region']
                )->where($tbl . '.customer_id = ?', (int) $customerId)
                ->where($tbl . '.model_number = ?', (string) $object->getModelNumber());

        $select->group($tbl . '.street1');
        $select->group($tbl . '.street2');
        $select->group($tbl . '.city');
        $select->group($tbl . '.region');
        //echo $select;

        $locations = $this->getResource()->getConnection()->fetchAll($select);


        $select = $this->getResource()->getConnection()->select()->from(
                        $tbl, ['serial_number']
                )->where($tbl . '.customer_id = ?', (int) $customerId)
                ->where($tbl . '.model_number = ?', (string) $object->getModelNumber())
                ->where($tbl . '.serial_number != ?', 'NULL');

        $select->group($tbl . '.serial_number');
        //echo $select;

        $serialNumbers = $this->getResource()->getConnection()->fetchCol($select);

        //print_r($nicknames);
        return [
            'locations' => $locations,
            'nicknames' => $nicknames,
            'serial_numbers' => $serialNumbers
        ];
    }

    public function getCabinetSerials(\Vgroup\SafetyHubApp\Model\SafetyItems $object) {
        $tbl = $this->getResource()->getTable('safetyhubapp_safetyitem_serials');
        $select = $this->getResource()->getConnection()->select()->from(
                        $tbl, ['id', 'serial_number']
                )
                ->where(
                'row_id = ?', (int) $object->getId()
        );
        return $this->getResource()->getConnection()->fetchAll($select);
    }

    public function getCabinetSerialsOnly(\Vgroup\SafetyHubApp\Model\SafetyItems $object) {
        $tbl = $this->getResource()->getTable('safetyhubapp_safetyitem_serials');
        $select = $this->getResource()->getConnection()->select()->from(
                        $tbl, ['id', 'serial_number']
                )
                ->where(
                'row_id = ?', (int) $object->getId()
        );
        return $this->getResource()->getConnection()->fetchCol($select);
    }

}
