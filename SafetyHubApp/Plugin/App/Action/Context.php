<?php

namespace Vgroup\SafetyHubApp\Plugin\App\Action;

/**
 * Attribution
 * https://ranasohel.me/2017/05/05/how-to-get-customer-id-from-block-when-full-page-cache-enable-in-magento-2/
 */
class Context {

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $httpContext;

    /**
     * Customer authorization cache context
     */
    const CONTEXT_CUSTOMER_ID = 'logged_in_customer_id';

    /**
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\Http\Context $httpContext
     */
    public function __construct(
	    \Magento\Customer\Model\Session $customerSession,
	    \Magento\Framework\App\Http\Context $httpContext
    ) {
	$this->customerSession = $customerSession;
	$this->httpContext = $httpContext;
    }

    /**
     * @param \Magento\Framework\App\ActionInterface $subject
     * @param callable $proceed
     * @param \Magento\Framework\App\RequestInterface $request
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundDispatch(
	    \Magento\Framework\App\ActionInterface $subject,
	    \Closure $proceed,
	    \Magento\Framework\App\RequestInterface $request
    ) {
	$customerId = $this->customerSession->getCustomerId();
	if (!$customerId) {
	    $customerId = 0;
	}

	$this->httpContext->setValue(self::CONTEXT_CUSTOMER_ID, $customerId, false);	
	return $proceed($request);
    }

}
