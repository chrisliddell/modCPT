<?php
/**
 * Copyright © 2017 remmote.com
 * */

namespace Remmote\Credomaticpayment\Plugin\Sales\Order\Email\Container;

/**
 * Disable emails after order are placed. Email are sent only in success page (via observer...)
 */
class OrderIdentityPlugin
{
    /**
     * @var \Magento\Checkout\Model\Session $checkoutSession
     */
    protected $checkoutSession;
 
    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     *
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession
    )
    {
        $this->checkoutSession = $checkoutSession;
    }
 
    /**
     * @param \Magento\Sales\Model\Order\Email\Container\OrderIdentity $subject
     * @param callable $proceed
     * @return bool
     */
    public function aroundIsEnabled(\Magento\Sales\Model\Order\Email\Container\OrderIdentity $subject, callable $proceed)
    {
        $returnValue = $proceed();
        $returnValue = false; // Ignoring admin panel setting (Admin -> Stores -> Configuration -> Sales -> Sales Email -> Order -> Enabled)
 
        $forceOrderMailSentOnSuccess = $this->checkoutSession->getForceOrderMailSentOnSuccess();
        if(isset($forceOrderMailSentOnSuccess) && $forceOrderMailSentOnSuccess)
        {
            if($returnValue)
                $returnValue = false;
            else
                $returnValue = true;
 
            $this->checkoutSession->unsForceOrderMailSentOnSuccess();
        }
 
        return $returnValue;
    }
}