<?php
class Itransition_ShippingInsurance_Model_Observer
{
    public function setInsurance(Varien_Event_Observer $observer)
    {
        $enabled = Mage::getStoreConfig(
            'shippinginsurance_options/insurance/insurance_enable'
        );

        if ($enabled) {
            $quote = $observer->getQuote();
            $address = $quote->getShippingAddress();
            $accepted = Mage::app()->getRequest()->getParam('insurance_enabled', false);

            if ($accepted) {
                $shippingMethod = $address->getShippingMethod();
                $address->setInsuranceShippingMethod($shippingMethod);
                $quote->setInsuranceShippingMethod($shippingMethod);
            } else {
                $address->setInsuranceShippingMethod(null);
                $quote->setInsuranceShippingMethod(null);
            }
        }
    }
}
