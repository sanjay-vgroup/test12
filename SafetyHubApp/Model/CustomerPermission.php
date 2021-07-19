<?php

namespace Vgroup\SafetyHubApp\Model;

use Magento\Framework\Api\AttributeValueFactory;

class CustomerPermission extends \Magento\Framework\Model\AbstractExtensibleModel 
{

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'safetyhubapp_customer_permission';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param TypeFactory $typeFactory
     * @param \Vgroup\SafetyHubApp\Model\ResourceModel\Companies $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        \Vgroup\SafetyHubApp\Model\ResourceModel\Companies $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $resource,
            $resourceCollection,
            $data
        );
    }

    protected function _construct()
    {

        $this->_init('Vgroup\SafetyHubApp\Model\ResourceModel\CustomerPermission');
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

  

}
