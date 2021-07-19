<?php 

namespace Vgroup\SafetyHubApp\Model\ResourceModel\CompanyDefaultLabels;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct() {
        $this->_init('Vgroup\SafetyHubApp\Model\CompanyDefaultLabels', 'Vgroup\SafetyHubApp\Model\ResourceModel\CompanyDefaultLabels');
    }


}
