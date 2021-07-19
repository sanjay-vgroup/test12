<?php

namespace Vgroup\SafetyHubApp\Ui\Component\Listing\Column;

class SerialCountAction extends \Magento\Ui\Component\Listing\Columns\Column {

    const URL_PATH_EDIT = 'safetyhubapp/safetyitems/edit';

    /**
     * URL builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    /**
     * constructor
     *
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
    \Magento\Framework\UrlInterface $urlBuilder, \Magento\Framework\View\Element\UiComponent\ContextInterface $context, \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory, array $components = [], array $data = []
    ) {
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource) {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['entity_id'])) {
                    if ($item['serial_count'] > 0):
                        $item[$name] = html_entity_decode('<a href="' .
                                $this->_urlBuilder->getUrl(self::URL_PATH_EDIT, ['entity_id' => $item['entity_id']]) . '">' . 'View ' . $item['serial_count'] . '</a>');
                    else:
                        $item[$name] = html_entity_decode('No records');
                    endif;
                }
            }
        }
        return $dataSource;
    }

}
