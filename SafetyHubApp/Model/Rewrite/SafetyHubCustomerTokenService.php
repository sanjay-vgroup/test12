<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Model\Rewrite;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Integration\Model\CredentialsValidator;
use Magento\Integration\Model\Oauth\Token as Token;
use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;
use Magento\Integration\Model\ResourceModel\Oauth\Token\CollectionFactory as TokenCollectionFactory;
use Magento\Integration\Model\Oauth\Token\RequestThrottler;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Event\ManagerInterface;
use Vgroup\SafetyHubApp\Model\DeviceTokenFactory;

/**
 * @inheritdoc
 */
class SafetyHubCustomerTokenService implements \Vgroup\SafetyHubApp\Api\CustomerTokenServiceInterface {

    /**
     * Token Model
     *
     * @var TokenModelFactory
     */
    private $tokenModelFactory;

    /**
     * @var Magento\Framework\Event\ManagerInterface
     */
    private $eventManager;

    /**
     * Customer Account Service
     *
     * @var AccountManagementInterface
     */
    private $accountManagement;

    /**
     * @var \Magento\Integration\Model\CredentialsValidator
     */
    private $validatorHelper;

    /**
     * Token Collection Factory
     *
     * @var TokenCollectionFactory
     */
    private $tokenModelCollectionFactory;

    /**
     * @var RequestThrottler
     */
    private $requestThrottler;

    /**
     * Initialize service
     *
     * @param TokenModelFactory $tokenModelFactory
     * @param AccountManagementInterface $accountManagement
     * @param TokenCollectionFactory $tokenModelCollectionFactory
     * @param \Magento\Integration\Model\CredentialsValidator $validatorHelper
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     */
    public function __construct(
    TokenModelFactory $tokenModelFactory, AccountManagementInterface $accountManagement, TokenCollectionFactory $tokenModelCollectionFactory, CredentialsValidator $validatorHelper, ManagerInterface $eventManager = null, DeviceTokenFactory $deviceTokenFactory, \Magento\Customer\Model\CustomerFactory $customerFactory
    ) {
        $this->tokenModelFactory = $tokenModelFactory;
        $this->accountManagement = $accountManagement;
        $this->tokenModelCollectionFactory = $tokenModelCollectionFactory;
        $this->validatorHelper = $validatorHelper;
        $this->eventManager = $eventManager ?: \Magento\Framework\App\ObjectManager::getInstance()
                        ->get(ManagerInterface::class);

        $this->deviceTokenFactory = $deviceTokenFactory;
        $this->customerFactory = $customerFactory;
    }

    /**
     * @inheritdoc
     */
    public function createCustomerAccessToken($username, $password, $device_token = NULL, $app_id = NULL, $version = NULL) {
        try {
            $this->validatorHelper->validate($username, $password);
            $this->getRequestThrottler()->throttle($username, RequestThrottler::USER_TYPE_CUSTOMER);
            $customerDataObject = $this->accountManagement->authenticate($username, $password);
            if (!empty($device_token) && $device_token !== NULL):
                $data = [
                    'customer_id' => $customerDataObject->getId(),
                    'device_token' => $device_token,
                    'app_id' => $app_id
                ];
                $this->deviceToken($data);
            endif;
        } catch (\Exception $e) {
            $this->getRequestThrottler()->logAuthenticationFailure($username, RequestThrottler::USER_TYPE_CUSTOMER);
            throw new AuthenticationException(
            __(
                    'The account sign-in was incorrect or your account is disabled temporarily. '
                    . 'Please wait and try again later.'
            )
            );
        }
        $this->eventManager->dispatch('customer_login', ['customer' => $customerDataObject]);
        $this->getRequestThrottler()->resetAuthenticationFailuresCount($username, RequestThrottler::USER_TYPE_CUSTOMER);

        return $this->tokenModelFactory->create()->createCustomerToken($customerDataObject->getId())->getToken();
    }

    /**
     * Revoke token by customer id.
     *
     * The function will delete the token from the oauth_token table.
     *
     * @param int $customerId
     * @param string $device_token
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function revokeCustomerAccessToken($customerId, $device_token = NULL) {
        $tokenCollection = $this->tokenModelCollectionFactory->create()->addFilterByCustomerId($customerId);
        if (!empty($device_token) && $device_token !== NULL):
            $data = [
                'customer_id' => $customerId,
                'device_token' => 0
            ];
            $this->deviceToken($data);
        endif;
        if ($tokenCollection->getSize() == 0) {
            throw new LocalizedException(__('This customer has no tokens.'));
        }
        try {
            foreach ($tokenCollection as $token) {
                $token->delete();
            }
        } catch (\Exception $e) {
            throw new LocalizedException(__("The tokens couldn't be revoked."));
        }
        return true;
    }

    /**
     * Get request throttler instance
     *
     * @return RequestThrottler
     * @deprecated 100.0.4
     */
    private function getRequestThrottler() {
        if (!$this->requestThrottler instanceof RequestThrottler) {
            return \Magento\Framework\App\ObjectManager::getInstance()->get(RequestThrottler::class);
        }
        return $this->requestThrottler;
    }

    /**
     * @inheritdoc
     */
    public function addDeviceToken($customer_id, $device_token = NULL, $app_id = NULL) {
        try {
            $customer = $this->customerFactory->create();
            if (!empty($customer_id) && !empty($device_token)):
                $customer = $customer->load($customer_id);
                if (!empty($customer->getId())):
                    $data = [
                        'customer_id' => $customer_id,
                        'device_token' => $device_token,
                        'app_id' => $app_id
                    ];
                    $result = $this->deviceToken($data);
                    if (empty($result)):
                        return FALSE;
                    endif;
                    return TRUE;
                endif;
            endif;
            return FALSE;
        } catch (\Exception $e) {
            throw new LocalizedException(__("The tokens couldn't be revoked."));
        }
    }

    private function deviceToken($data) {
        $deviceTokenModel = $this->deviceTokenFactory->create();
        $deviceTokenModel->setData($data);
        return $deviceTokenModel->save();
    }

}
