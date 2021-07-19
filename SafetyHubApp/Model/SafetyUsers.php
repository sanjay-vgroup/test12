<?php

namespace Vgroup\SafetyHubApp\Model;

use Magento\Framework\Api\AttributeValueFactory;

class SafetyUsers extends \Magento\Framework\Model\AbstractExtensibleModel implements
    \Vgroup\SafetyHubApp\Api\Data\CompanyInterface
{

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'customer_entity';

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

        $this->_init('Vgroup\SafetyHubApp\Model\ResourceModel\SafetyUsers');
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

    public function getApiPassword()
    {
        return $this->getData(self::API_PASSWORD);
    }

    public function getApiUser()
    {
        return $this->getData(self::API_USER);
    }

    public function getApiUsername()
    {
        return $this->getData(self::API_USERNAME);
    }

    public function getApprovalMode()
    {
        return $this->getData(self::APPROVAL_MODE);
    }

    public function getPortalFontColor()
    {
        return $this->getData(self::PORTAL_FONT_COLOR);
    }

    public function getCodes()
    {
        return $this->getData(self::CODES);
    }

    public function getCompanyRequisitionEmail()
    {
        return $this->getData(self::COMPANY_REQUISITIONS_EMAIL);
    }

    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    public function getDefaultPaging()
    {
        return $this->getData(self::DEFAULT_PAGING);
    }

    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    public function getEmailTemplateContent()
    {
        return $this->getData(self::EMAIL_TEMPLATE_CONTENT);
    }

    public function getEmailTemplateStyle()
    {
        return $this->getData(self::EMAIL_TEMPLATE_STYLE);
    }

    public function getEmailTemplateSubject()
    {
        return $this->getData(self::EMAIL_TEMPLATE_SUBJECT);
    }

    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    public function getHeadingFontColor()
    {
        return $this->getData(self::HEADING_FONT_COLOR);
    }

    public function getHours()
    {
        return $this->getData(self::HOURS);
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function getInterval()
    {
        return $this->getData(self::INTERVAL);
    }

    public function getIsPreferredDistributor()
    {
        return $this->getData(self::IS_PREFERRED_DISTRIBUTOR);
    }

    public function getLargeActionButtonBgBolor()
    {
        return $this->getData(self::LARGE_BUTTONS_BG_COLOR);
    }

    public function getLargeActionButtonFontColor()
    {
        return $this->getData(self::LARGE_BUTTONS_FONT_COLOR);
    }

    public function getLogo()
    {
        return $this->getData(self::LOGO);
    }

    public function getMediumActionButtonBgColor()
    {
        return $this->getData(self::MEDIUM_BUTTONS_BG_COLOR);
    }

    public function getMediumActionButtonFontColor()
    {
        return $this->getData(self::MEDIUM_BUTTONS_FONT_COLOR);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function getPortalBgColor()
    {
        return $this->getData(self::PORTAL_BG_COLOR);
    }

    public function getPartNumberPreference()
    {
        return $this->getData(self::PARTNUMBER_PREFERENCE);
    }

    public function getPermissionType()
    {
        return $this->getData(self::PERMISSION_TYPE);
    }

    public function getPermissions()
    {
        return $this->getData(self::PERMISSIONS);
    }

    public function getPhone()
    {
        return $this->getData(self::PHONE);
    }

    public function getPreferredDistributor()
    {
        return $this->getData(self::PREFERRED_DISTRIBUTORS);
    }

    public function getRequisitionsDefaultPaging()
    {
        return $this->getData(self::REQUISITIONS_DEFAULT_PAGING);
    }

    public function getRestockReqStatus()
    {
        return $this->getData(self::RESTOCK);
    }

    public function getSafetyitemsDefaultPaging()
    {
        return $this->getData(self::SAFETYITEMS_DEFAULT_PAGING);
    }

    public function getSmallActionButtonBgColor()
    {
        return $this->getData(self::SMALL_BUTTONS_BG_COLOR);
    }

    public function getSmallActionButtonFontColor()
    {
        return $this->getData(self::SMALL_BUTTONS_FONT_COLOR);
    }

    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    public function getUpdateAt()
    {
        return $this->getData(self::UPDATE_AT);
    }

    public function getUrl()
    {
        return $this->getData(self::URL);
    }

    public function getUsersDefaultPaging()
    {
        return $this->getData(self::USERS_DEFAULT_PAGING);
    }

    public function setApiPassword($apiPassword)
    {
        return $this->setData(self::API_PASSWORD, $apiPassword);
    }

    public function setApiUser($apiUser)
    {
        return $this->setData(self::API_USER, $apiUser);
    }

    public function setApiUsername($apiUsername)
    {
        return $this->setData(self::API_USERNAME, $apiUsername);
    }

    public function setApprovalMode($approvalMode)
    {
        return $this->setData(self::APPROVAL_MODE, $approvalMode);
    }

    public function setPortalFontColor($portalFontColor)
    {
        return $this->setData(self::PORTAL_FONT_COLOR, $portalFontColor);
    }

    public function setCodes($codes)
    {
        return $this->setData(self::CODES, $codes);
    }

    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function setDefaultPaging($defaultPaging)
    {
        return $this->setData(self::DEFAULT_PAGING, $defaultPaging);
    }

    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    public function setEmailTemplateContent($emailTemplateContent)
    {
        return $this->setData(self::EMAIL_TEMPLATE_CONTENT, $emailTemplateContent);
    }

    public function setEmailTemplateStyle($emailTemplateStyle)
    {
        return $this->setData(self::EMAIL_TEMPLATE_STYLE, $emailTemplateStyle);
    }

    public function setEmailTemplateSubject($emailTemplateSubject)
    {
        return $this->setData(self::EMAIL_TEMPLATE_SUBJECT, $emailTemplateSubject);
    }

    public function setExtensionAttributes(\Vgroup\SafetyHubApp\Api\Data\CompanyExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    public function setHeadingFontColor($headingFontColor)
    {
        return $this->setData(self::EMAIL_TEMPLATE_SUBJECT, $headingFontColor);
    }

    public function setHours($hours)
    {
        return $this->setData(self::HOURS, $hours);
    }

    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    public function setInterval($interval)
    {
        return $this->setData(self::INTERVAL, $interval);
    }

    public function setIsPreferredDistributor($isPreferredDistributor)
    {
        return $this->setData(self::IS_PREFERRED_DISTRIBUTOR, $isPreferredDistributor);
    }

    public function setLargeActionButtonBgBolor($largeActionButtonBgColor)
    {
        return $this->setData(self::LARGE_BUTTONS_BG_COLOR, $largeActionButtonBgColor);
    }

    public function setLargeActionButtonFontColor($largeActionButtonFontColor)
    {
        return $this->setData(self::LARGE_BUTTONS_FONT_COLOR, $largeActionButtonFontColor);
    }

    public function setLogo($logo)
    {
        return $this->setData(self::LOGO, $logo);
    }

    public function setMediumActionButtonBgColor($mediumActionButtonBgColor)
    {
        return $this->setData(self::MEDIUM_BUTTONS_BG_COLOR, $mediumActionButtonBgColor);
    }

    public function setMediumActionButtonFontColor($mediumActionButtonFontColor)
    {
        return $this->setData(self::MEDIUM_BUTTONS_FONT_COLOR, $mediumActionButtonFontColor);
    }

    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    public function setPartNumberPreference($partNumberPreference)
    {
        return $this->setData(self::PARTNUMBER_PREFERENCE, $partNumberPreference);
    }

    public function setPermissionType($permissionType)
    {
        return $this->setData(self::PERMISSION_TYPE, $permissionType);
    }

    public function setPermissions($permissions)
    {
        return $this->setData(self::PERMISSIONS, $permissions);
    }

    public function setPhone($phone)
    {
        return $this->setData(self::PHONE, $phone);
    }

    public function setPortalBgColor($portalBgColor)
    {
        return $this->setData(self::PORTAL_BG_COLOR, $portalBgColor);
    }

    public function setPreferredDistributor($preferredDistributor)
    {
        return $this->setData(self::PREFERRED_DISTRIBUTORS, $preferredDistributor);
    }

    public function setRequisitionsDefaultPaging($requisitionsDefaultPaging)
    {
        return $this->setData(self::REQUISITIONS_DEFAULT_PAGING, $requisitionsDefaultPaging);
    }

    public function setRestockReqStatus($restock)
    {
        return $this->setData(self::RESTOCK, $restock);
    }

    public function setSafetyitemsDefaultPaging($safetyItemsDefaultPaging)
    {
        return $this->setData(self::SAFETYITEMS_DEFAULT_PAGING, $safetyItemsDefaultPaging);
    }

    public function setSmallActionButtonBgColor($smallActionButtonBgColor)
    {
        return $this->setData(self::SMALL_BUTTONS_BG_COLOR, $smallActionButtonBgColor);
    }

    public function setSmallActionButtonFontColor($smallActionButtonFontColor)
    {
        return $this->setData(self::SMALL_BUTTONS_FONT_COLOR, $smallActionButtonFontColor);
    }

    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    public function setUpdateAt($updateAt)
    {
        return $this->setData(self::UPDATE_AT, $updateAt);
    }

    public function setUrl($url)
    {
        return $this->setData(self::URL, $url);
    }

    public function setUsersDefaultPaging($usersDefaultPaging)
    {
        return $this->setData(self::USERS_DEFAULT_PAGING, $usersDefaultPaging);
    }

    public function setCompanyRequisitionEmail($companyRequisitionEmail)
    {
        return $this->setData(self::COMPANY_REQUISITIONS_EMAIL, $companyRequisitionEmail);
    }
}
