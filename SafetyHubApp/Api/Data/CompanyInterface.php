<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Api\Data;

/**
 * Company Interface.
 * @api
 * @since 100.0.2
 */
interface CompanyInterface extends \Magento\Framework\Api\ExtensibleDataInterface {

    /**
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const ID = 'entity_id';
    const NAME = 'name';
    const EMAIL = 'email';
    const COMPANY_REQUISITIONS_EMAIL = 'company_requisition_email';
    const PHONE = 'phone';
    const URL = 'url';
    const HOURS = 'hours';
    const LOGO = 'logo';
    const PORTAL_BG_COLOR = 'portal_bg_color';
    const PORTAL_FONT_COLOR = 'portal_font_color';
    const LARGE_BUTTONS_BG_COLOR = 'large_action_button_bg_color';
    const LARGE_BUTTONS_FONT_COLOR = 'large_action_button_font_color';
    const MEDIUM_BUTTONS_BG_COLOR = 'medium_action_button_bg_color';
    const MEDIUM_BUTTONS_FONT_COLOR = 'medium_action_button_font_color';
    const SMALL_BUTTONS_BG_COLOR = 'small_action_button_bg_color';
    const SMALL_BUTTONS_FONT_COLOR = 'small_action_button_font_color';
    const HEADING_FONT_COLOR = 'heading_font_color';
    const CMS_BG_COLOR = 'cms_bg_color';
    const CMS_FONT_COLOR = 'cms_font_color';
    const EMAIL_TEMPLATE_SUBJECT = 'email_template_subject';
    const EMAIL_TEMPLATE_CONTENT = 'email_template_content';
    const EMAIL_TEMPLATE_STYLE = 'email_template_style';
    const API_USER = 'api_user';
    const API_USERNAME = 'api_username';
    const API_PASSWORD = 'api_password';
    const DEFAULT_PAGING = 'default_paging';
    const REQUISITIONS_DEFAULT_PAGING = 'requisitions_default_paging';
    const SAFETYITEMS_DEFAULT_PAGING = 'safetyitems_default_paging';
    const USERS_DEFAULT_PAGING = 'users_default_paging';
    const CODES = 'codes';
    const APPROVAL_MODE = 'approval_mode';
    const INTERVAL = 'interval';
    const IS_PREFERRED_DISTRIBUTOR = 'is_preferred_distributor';
    const PREFERRED_DISTRIBUTORS = 'preferred_distributors';
    const PERMISSION_TYPE = 'permission_type';
    const PERMISSIONS = 'permissions';
    const PARTNUMBER_PREFERENCE = 'partnumber_preference';
    const PAYMENT_MODE = 'payment_mode';
    const RESTOCK = 'restock_req_status';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const UPDATE_AT = 'update_at';

    /*     * #@- */

    /**
     * Get company id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set company id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get Company Name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set Company Name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Get email id
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * Set email id
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     * Get company requisition email
     *
     * @return string|null
     */
    public function getCompanyRequisitionEmail();

    /**
     * Set company requisition email
     *
     * @param string $companyRequisitionEmail
     * @return $this
     */
    public function setCompanyRequisitionEmail($companyRequisitionEmail);

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
    public function getUpdateAt();

    /**
     * Set updated at time
     *
     * @param string $updateAt
     * @return $this
     */
    public function setUpdateAt($updateAt);

    /**
     * Get phone
     *
     * @return string|null
     */
    public function getPhone();

    /**
     * Set phone
     *
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone);

    /**
     * Get Url
     *
     * @return string|null
     */
    public function getUrl();

    /**
     * Set Url
     *
     * @param string $url
     * @return $this
     */
    public function setUrl($url);

    /**
     * Get upc
     *
     * @return string
     */
    public function getHours();

    /**
     * Set hours
     *
     * @param string $hours
     * @return $this
     */
    public function setHours($hours);

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo();

    /**
     * Set logo
     *
     * @param string $logo
     * @return $this
     */
    public function setLogo($logo);

    /**
     * Get Large Action Button Background Color
     *
     * @return string|null
     */
    public function getLargeActionButtonBgBolor();

    /**
     * Set Large Action Button Background Color
     *
     * @param string $largeActionButtonBgColor
     * @return $this
     */
    public function setLargeActionButtonBgBolor($largeActionButtonBgColor);

    /**
     * Get Large Action Button Font Color
     *
     * @return string|null
     */
    public function getLargeActionButtonFontColor();

    /**
     * Set Large Action Button Font Color
     *
     * @param string $largeactionbutton1fontcolor
     * @return $this
     */
    public function setLargeActionButtonFontColor($largeActionButtonFontColor);

    /**
     * Get Medium Action Button Background Color
     *
     * @return string|null
     */
    public function getMediumActionButtonBgColor();

    /**
     * Set Medium Action Button Background Color
     *
     * @param string $mediumActionButtonBgColor
     * @return $this
     */
    public function setMediumActionButtonBgColor($mediumActionButtonBgColor);

    /**
     * Get Medium Action Button Font Color
     *
     * @return string|null
     */
    public function getMediumActionButtonFontColor();

    /**
     * Set Medium Action Button Font Color
     *
     * @param string $largeactionbutton2fontcolor
     * @return $this
     */
    public function setMediumActionButtonFontColor($mediumActionButtonFontColor);

    /**
     * Get Small Action Button Background Color
     *
     * @return string|null
     */
    public function getSmallActionButtonBgColor();

    /**
     * Set Small Action Button Background Color
     *
     * @param string $smallActionButtonBgColor
     * @return $this
     */
    public function setSmallActionButtonBgColor($smallActionButtonBgColor);

    /**
     * Get Small Action Button Font Color
     *
     * @return string|null
     */
    public function getSmallActionButtonFontColor();

    /**
     * Set Small Action Button Font Color
     *
     * @param string $smallActionButtonFontColor
     * @return $this
     */
    public function setSmallActionButtonFontColor($smallActionButtonFontColor);

    /**
     * Get Heading Font Color
     *
     * @return string|null
     */
    public function getHeadingFontColor();

    /**
     * Set Heading Font Color
     *
     * @param string $headingFontColor
     * @return $this
     */
    public function setHeadingFontColor($headingFontColor);

    /**
     * Get Portal Background Color
     *
     * @return string|null
     */
    public function getPortalBgColor();

    /**
     * Set Portal Background Color
     *
     * @param string $portalBgColor
     * @return $this
     */
    public function setPortalBgColor($portalBgColor);

    /**
     * Get Portal Font Color
     *
     * @return string|null
     */
    public function getPortalFontColor();

    /**
     * Set Portal Font Color
     *
     * @param string $portalFontColor
     * @return $this
     */
    public function setPortalFontColor($portalFontColor);

    /**
     * Get Email Template Subject
     *
     * @return string|null
     */
    public function getEmailTemplateSubject();

    /**
     * Set Email Template Subject
     *
     * @param string $emailTemplateSubject
     * @return $this
     */
    public function setEmailTemplateSubject($emailTemplateSubject);

    /**
     * Get Email Template Content
     *
     * @return string|null
     */
    public function getEmailTemplateContent();

    /**
     * Set Email Template Content
     *
     * @param string $emailTemplateContent
     * @return $this
     */
    public function setEmailTemplateContent($emailTemplateContent);

    /**
     * Get Email Template Style
     *
     * @return string|null
     */
    public function getEmailTemplateStyle();

    /**
     * Set Email Template Style
     *
     * @param string $emailTemplateStyle
     * @return $this
     */
    public function setEmailTemplateStyle($emailTemplateStyle);

    /**
     * Get API User
     *
     * @return string|null
     */
    public function getApiUser();

    /**
     * Set API User
     *
     * @param string $apiUser
     * @return $this
     */
    public function setApiUser($apiUser);

    /**
     * Get API Username
     *
     * @return string|null
     */
    public function getApiUsername();

    /**
     * Set API Username
     *
     * @param string $apiUsername
     * @return $this
     */
    public function setApiUsername($apiUsername);

    /**
     * Get API Password
     *
     * @return string|null
     */
    public function getApiPassword();

    /**
     * Set API Password
     *
     * @param string $apiPassword
     * @return $this
     */
    public function setApiPassword($apiPassword);

    /**
     * Get Default Paging
     *
     * @return string|null
     */
    public function getDefaultPaging();

    /**
     * Set Default Paging
     *
     * @param string $defaultPaging
     * @return $this
     */
    public function setDefaultPaging($defaultPaging);

    /**
     * Get Requisitions Default Paging
     *
     * @return string|null
     */
    public function getRequisitionsDefaultPaging();

    /**
     * Set Requisitions Default Paging
     *
     * @param string $requisitionsDefaultPaging
     * @return $this
     */
    public function setRequisitionsDefaultPaging($requisitionsDefaultPaging);

    /**
     * Get Safety Items Default Paging
     *
     * @return string|null
     */
    public function getSafetyitemsDefaultPaging();

    /**
     * Set Safety Items Default Paging
     *
     * @param string $safetyItemsDefaultPaging
     * @return $this
     */
    public function setSafetyitemsDefaultPaging($safetyItemsDefaultPaging);

    /**
     * Get Users Default Paging
     *
     * @return string|null
     */
    public function getUsersDefaultPaging();

    /**
     * Set Users Default Paging
     *
     * @param string $usersDefaultPaging
     * @return $this
     */
    public function setUsersDefaultPaging($usersDefaultPaging);

    /**
     * Get codes
     *
     * @return string|null
     */
    public function getCodes();

    /**
     * Set codes
     *
     * @param string $codes
     * @return $this
     */
    public function setCodes($codes);

    /**
     * Get Approval mode
     *
     * @return string|null
     */
    public function getApprovalMode();

    /**
     * Set Approval mode
     *
     * @param string $approvalMode
     * @return $this
     */
    public function setApprovalMode($approvalMode);

    /**
     * Get interval
     *
     * @return string|null
     */
    public function getInterval();

    /**
     * Set interval
     *
     * @param string $interval
     * @return $this
     */
    public function setInterval($interval);

    /**
     * Get is preferred distributor
     *
     * @return string|null
     */
    public function getIsPreferredDistributor();

    /**
     * Set is preferred distributor
     *
     * @param string $isPreferredDistributor
     * @return $this
     */
    public function setIsPreferredDistributor($isPreferredDistributor);

    /**
     * Get preferred distributor
     *
     * @return string|null
     */
    public function getPreferredDistributor();

    /**
     * Set preferred distributor
     *
     * @param string $preferredDistributor
     * @return $this
     */
    public function setPreferredDistributor($preferredDistributor);

    /**
     * Get Permission Type
     *
     * @return string|null
     */
    public function getPermissionType();

    /**
     * Set Permission Type
     *
     * @param string $permissionType
     * @return $this
     */
    public function setPermissionType($permissionType);

    /**
     * Get permissions
     *
     * @return string|null
     */
    public function getPermissions();

    /**
     * Set permissions
     *
     * @param string $permissions
     * @return $this
     */
    public function setPermissions($permissions);

    /**
     * Get part number preference
     *
     * @return string|null
     */
    public function getPartNumberPreference();

    /**
     * Set part number preference
     *
     * @param string $partNumberPreference
     * @return $this
     */
    public function setPartNumberPreference($partNumberPreference);

    /**
     * Get restock
     *
     * @return string|null
     */
    public function getRestockReqStatus();

    /**
     * Set restock
     *
     * @param string $restock
     * @return $this
     */
    public function setRestockReqStatus($restock);

    /**
     * Get status
     *
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Vgroup\SafetyHubApp\Api\Data\CompanyExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Vgroup\SafetyHubApp\Api\Data\CompanyExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
	    \Vgroup\SafetyHubApp\Api\Data\CompanyExtensionInterface $extensionAttributes
    );
    
}