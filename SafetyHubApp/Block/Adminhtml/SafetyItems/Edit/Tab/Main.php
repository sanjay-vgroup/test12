<?php

namespace Vgroup\SafetyHubApp\Block\Adminhtml\SafetyItems\Edit\Tab;

use Magento\Framework\App\Filesystem\DirectoryList;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface {

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $store;
    protected $itemtype;
    protected $helper;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(
    \Magento\Backend\Block\Template\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Data\FormFactory $formFactory, \Vgroup\SafetyHubApp\Helper\Data $helper, \Magento\Store\Model\StoreManagerInterface $storeManager, \Vgroup\SafetyHubApp\Model\Select\SafetyItemsTypes\Options $itemtype, array $data = []
    ) {

        $this->helper = $helper;
        $this->itemtype = $itemtype;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm() {
        /* @var $model \Vgroup\SafetyHubApp\Model\SafetyItems */
        $model = $this->_coreRegistry->registry('safetyhubapp_safetyitems');
        $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('safetyitems_');
        $form->setFieldNameSuffix('safetyitems');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Safety Item Information')]);
        $safetyItemImage = '';
        $schematicsImage = '';
        $isRequired = true;
        if ($model->getId()) {
            $fieldset->addField('entity_id', 'hidden', ['name' => 'id']);
//	    $safetyItemImage = '<br><img src="' . $mediaUrl . 'safetyhubapp/safetyitemsimages/' . $model->getImage() . '" width="210" height="210">';
//	    $schematicsImage = '<br><img src="' . $mediaUrl . 'safetyhubapp/schematicsimages/' . $model->getFile() . '" width="210" height="210">';
            if (!empty($model->getImage())):
                $safetyItemImage = '<br><img src="' . $model->getImage() . '" width="210" height="210">';
            endif;
            if (!empty($model->getFile())):
                $schematicsImage = '<br><img src="' . $model->getFile() . '" width="210" height="210">';
            endif;
            $isRequired = false;
        }

        $fieldset->addField(
                'type', 'select', [
            'name' => 'type',
            'label' => __('Item Type'),
            'options' => $this->itemtype->toOptionArray(),
            'required' => true,
                ]
        );

        $fieldset->addField(
                'title', 'text', [
            'name' => 'title',
            'label' => __('Title'),
            'title' => __('Title'),
            'required' => true,
                ]
        );


        $fieldset->addField(
                'model_number', 'text', [
            'name' => 'model_number',
            'label' => __('Model No'),
            'title' => __('Model No'),
            'required' => true,
                ]
        );

        $fieldset->addField(
                'serial_number', 'text', [
            'name' => 'serial_number',
            'label' => __('Serial Number'),
            'title' => __('Serial Number'),
            'required' => true,
                ]
        );


        $fieldset->addField(
                'sku', 'text', [
            'name' => 'sku',
            'label' => __('SKU'),
            'title' => __('SKU'),
            'required' => true,
                ]
        );
        $fieldset->addField(
                'upc', 'text', [
            'name' => 'upc',
            'label' => __('UPC'),
            'title' => __('UPC'),
            'required' => true,
                ]
        );



        $fieldset->addField(
                'description', 'textarea', [
            'name' => 'description',
            'label' => __('Content'),
            'title' => __('Content'),
            'required' => true,
                ]
        );

        $fieldset->addField(
                'image', 'file', [
            'name' => 'image',
            'label' => __('Safety Item Image'),
            'title' => __('Safety Item Image'),
            'required' => $isRequired,
            'after_element_html' => $safetyItemImage
                ]
        );


        $fieldset->addField(
                'file', 'file', [
            'name' => 'file',
            'label' => __('Item Schematics'),
            'title' => __('Item Schematics'),
            'required' => $isRequired,
            'after_element_html' => $schematicsImage
                ]
        );


        $fieldset->addField(
                'status', 'select', [
            'name' => 'status',
            'label' => __('Status'),
            'id' => 'status',
            'title' => __('Status'),
            'class' => 'input-select',
            'options' => [
                '1' => __('Active'),
                '0' => __('Inactive')
            ],
            'required' => true
                ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function _getWidgetSelectAfterHtml() {
        echo "Yes";
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel() {
        return __('General');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle() {
        return __('General');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab() {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden() {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId) {
        return $this->_authorization->isAllowed($resourceId);
    }

}
