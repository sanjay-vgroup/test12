<?php

namespace Vgroup\SafetyHubApp\Model;

use Magento\Framework\DataObject\IdentityInterface;

class Requisitions extends \Magento\Framework\Model\AbstractModel implements IdentityInterface
{

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'safetyhubapp_requisitions';

    /**
     * @var string
     */
    protected $_cacheTag = 'safetyhubapp_requisitions';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'safetyhubapp_requisitions';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {

        $this->_init('Vgroup\SafetyHubApp\Model\ResourceModel\Requisitions');
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getRequisitionItems(\Vgroup\SafetyHubApp\Model\Requisitions $object, $columns)
    {
        $tbl = $this->getResource()->getTable(\Vgroup\SafetyHubApp\Model\ResourceModel\Requisitions::TBL_REQUISITION_ITEMS);
        $select = $this->getResource()->getConnection()->select()->from(
            $tbl,
            $columns
        )
            ->where(
                'requisition_id = ?',
                (int) $object->getId()
            );
        if (count($columns) > 1)
            return $this->getResource()->getConnection()->fetchAll($select);
        else
            return $this->getResource()->getConnection()->fetchCol($select);
    }

    public function getRequisitionUserSafetyItem(\Vgroup\SafetyHubApp\Model\Requisitions $object, $columns)
    {
        $tbl = $this->getResource()->getTable(\Vgroup\SafetyHubApp\Model\ResourceModel\Requisitions::TBL_REQUISITION_USER_SAFETYITEM);
        $select = $this->getResource()->getConnection()->select()->from(
            $tbl,
            $columns
        )
            ->where(
                'entity_id = ?',
                (int) $object->getSafetyItemId()
            );
        if (count($columns) > 1)
            return current($this->getResource()->getConnection()->fetchAll($select));
        else
            return $this->getResource()->getConnection()->fetchCol($select);
    }
}
