<?php

namespace Vgroup\SafetyHubApp\Helper;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    protected $storeManager;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    protected $storeId = 7;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var \Magento\SalesRule\Model\Coupon\Codegenerator
     */
    protected $codeGenerator;
    /**
     * @var Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_timezoneInterface;

    /**
     * @param \Magento\Framework\App\Helper\Context   $context
     * @param \Magento\Backend\Model\UrlInterface $backendUrl
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\SalesRule\Model\Coupon\Codegenerator $codeGenerator
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Backend\Model\UrlInterface $urlBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\SalesRule\Model\Coupon\Codegenerator $codeGenerator,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface
    ) {

        $this->urlBuilder = $urlBuilder;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->codeGenerator = $codeGenerator;
        $this->_timezoneInterface = $timezoneInterface;
        parent::__construct($context);
    }

    /**
     * Prining URLs using StoreManagerInterface
     */
    public function getStoreManagerData($queryParams = null)
    {

        //	 $queryParams = [
        //            'param_1' => value1, // value for parameter
        //            'param_2' => value2
        //        ];

        return [
            'base_url' => $this->storeManager->getStore($this->storeId)->getBaseUrl(),
            'download_link' => $this->storeManager->getStore($this->storeId)->getUrl('safetyhubapp/account/download', $queryParams),
            'media_url' => $this->storeManager->getStore($this->storeId)->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
        ];
    }

    /**
     * get products tab Url in admin
     * @return string
     */
    public function getProductsGridUrl()
    {
        return $this->urlBuilder->getUrl('safetyhubapp/safetyitems/products', ['_current' => true]);
    }

    /**
     * get part numbers tab url in admin
     * @return string
     */
    public function getPartNumbersGridUrl()
    {
        return $this->urlBuilder->getUrl('safetyhubapp/companies/partnumbers', ['_current' => true]);
    }

    public function getUsersGridUrl()
    {
        return $this->urlBuilder->getUrl('safetyhubapp/users/partnumbers', ['_current' => true]);
    }
    /**
     * get safety items type
     * @return string
     * 
     */
    public function getSafetyItemTypes($type = 0)
    {
        $safetyItemTypes =  array(
            '1' => "Cabinet",
            '2' => "Fire Exitinguisher",
            '3' => "AED",
            '4' => "Eyewash Stations",
            '5' => "Spill Control"
        );
        return ($type > 0) ?  $safetyItemTypes[$type] : $safetyItemTypes;
    }

    public function getConfig($config_path, $scope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE)
    {
        return $this->scopeConfig->getValue($config_path, $scope);
    }

    public function generateCode()
    {
        return $this->codeGenerator->setFormat('alphanum')->setLength(10)->generateCode();
    }

    public function getDate($format)
    {
        return $this->_timezoneInterface->date()->format($format);
    }
}
