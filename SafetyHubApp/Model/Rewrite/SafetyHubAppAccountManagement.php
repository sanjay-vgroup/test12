<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vgroup\SafetyHubApp\Model\Rewrite;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Customer\CredentialsValidator;
use Magento\Framework\App\ObjectManager;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerRegistry;
use Magento\Customer\Model\AddressRegistry;
use Magento\Framework\Math\Random;
use Vgroup\SafetyHubApp\Helper\Email;
use Vgroup\SafetyHubApp\Model\EmailNotificationInterface;
use Psr\Log\LoggerInterface as PsrLogger;
use Magento\Framework\Exception\InvalidEmailOrPasswordException;
use Vgroup\SafetyHubApp\Api\Data\CommonResponseInterfaceFactory;

class SafetyHubAppAccountManagement extends \Magento\Customer\Model\AccountManagement {

    /**
     * @var EmailNotificationInterface
     */
    private $emailNotification;

    public function __construct(
    CustomerRegistry $customerRegistry, CustomerRepositoryInterface $customerRepository, CredentialsValidator $credentialsValidator = null, AddressRegistry $addressRegistry = null, Random $mathRandom, \Vgroup\SafetyHubApp\Helper\Email $mailHelper, PsrLogger $logger, CommonResponseInterfaceFactory $response
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerRegistry = $customerRegistry;
        $this->credentialsValidator = $credentialsValidator ?:
                ObjectManager::getInstance()->get(CredentialsValidator::class);
        $this->addressRegistry = $addressRegistry ?: ObjectManager::getInstance()->get(AddressRegistry::class);
        $this->mathRandom = $mathRandom;
        $this->mailHelper = $mailHelper;
        $this->logger = $logger;
        $this->response = $response;
    }

    /**
     * @inheritdoc
     */
    public function changePasswordById($customerId, $currentPassword, $newPassword) {
        try {
            $result = $this->response->create();

            $customer = $this->customerRepository->getById($customerId);
            $this->getAuthentication()->authenticate($customer->getId(), $currentPassword);
            $customerEmail = $customer->getEmail();
            $this->credentialsValidator->checkPasswordDifferentFromEmail($customerEmail, $newPassword);
            $customerSecure = $this->customerRegistry->retrieveSecureData($customer->getId());
            $customerSecure->setRpToken(null);
            $customerSecure->setRpTokenCreatedAt(null);
            $accountModelInstance = ObjectManager::getInstance()->get(\Magento\Customer\Model\AccountManagement::class);
            $accountModelInstance->checkPasswordStrength($newPassword);
            $customerSecure->setPasswordHash($accountModelInstance->createPasswordHash($newPassword));
            $this->customerRepository->save($customer);

            $result->setStatus('success');
            $result->setMessage('Password changed successfully.');
            return $result;
        } catch (NoSuchEntityException $e) {
            $result->setStatus('failed');
            $result->setMessage('Invalid login or password.');
            return $result;
//            throw new InvalidEmailOrPasswordException(__('Invalid login or password.'));
        }
        $result->setStatus('failed');
        $result->setMessage('Invalid login or password.');
        return $result;
    }

    /**
     * Get authentication
     *
     * @return AuthenticationInterface
     */
    private function getAuthentication() {
        if (!($this->authentication instanceof AuthenticationInterface)) {
            return \Magento\Framework\App\ObjectManager::getInstance()->get(
                            \Magento\Customer\Model\AuthenticationInterface::class
            );
        } else {
            return $this->authentication;
        }
    }

    /**
     * @inheritdoc
     */
    public function initiatePasswordReset($email, $template, $websiteId = null) {
        $accountModelInstance = ObjectManager::getInstance()->get(\Magento\Customer\Model\AccountManagement::class);
        if ($accountModelInstance->isEmailAvailable($email, $websiteId))
            throw new InvalidEmailOrPasswordException(__('Email address is not registered'));
        // load customer by email
        $customer = $this->customerRepository->get($email, $websiteId);
        // No need to validate customer address while saving customer reset password token
        $this->disableAddressValidation($customer);
        $result = $this->response->create();

        $newPasswordToken = $this->mathRandom->getUniqueHash();

        $accountModelInstance->changeResetPasswordLinkToken($customer, $newPasswordToken);
        try {
            $this->getEmailNotification()->passwordResetConfirmation($customer);
            $result->setStatus('success')->setMessage('Password reset link has been sent to registered email address.');
            return $result;
        } catch (MailException $e) {
            // If we are not able to send a reset password email, this should be ignored
            $this->logger->critical($e);
        }
        $result->setStatus('failed');
        $result->setMessage('System configuration error.');
        return $result;
    }

    /**
     * Disable Customer Address Validation
     *
     * @param CustomerInterface $customer
     * @throws NoSuchEntityException
     */
    private function disableAddressValidation($customer) {
        $accountModelInstance = ObjectManager::getInstance()->get(\Magento\Customer\Model\AccountManagement::class);

        foreach ($customer->getAddresses() as $address) {
            $addressModel = $this->addressRegistry->retrieve($address->getId());
            $addressModel->setShouldIgnoreValidation(true);
        }
    }

    /**
     * Get email notification
     *
     * @return EmailNotificationInterface
     * @deprecated 100.1.0
     */
    private function getEmailNotification() {
        if (!($this->emailNotification instanceof \Vgroup\SafetyHubApp\Model\EmailNotificationInterface)) {
            return \Magento\Framework\App\ObjectManager::getInstance()->get(
                            \Vgroup\SafetyHubApp\Model\EmailNotificationInterface::class
            );
        } else {
            return $this->emailNotification;
        }
    }

}
