<?php
class Itransition_ShippingInsurance_Model_Observer
{
    public function calculateValue(Varien_Event_Observer $observer) {
        $enabled = Mage::getStoreConfig(
            'shippinginsurance_options/insurance/insurance_enable'
        );

        if ($enabled) {
            $quote = $observer->getQuote();
            $address = $quote->getShippingAddress();
            $accepted = Mage::app()->getRequest()->getParam('insurance_enabled', false);

            if ($address->getInsuranceShippingMethod()) {
                $oldRate = $address->getShippingRateByCode(
                    $address->getInsuranceShippingMethod()
                );
                $oldRate->setPrice($address->getShippingValueWithoutInsurance());
            }

            if ($accepted) {
                $address->setShippingInsurance(
                    $quote->getShippingInsurance()
                );
                $address->setInsuranceShippingMethod(
                    $address->getShippingMethod()
                );
                $shippingMethod = $address->getShippingMethod();
                $quote->setInsuranceShippingMethod($shippingMethod);
                $rate = $address->getShippingRateByCode($shippingMethod);
                $address->setShippingValueWithoutInsurance($rate->getPrice());
            } else {
                $address->setInsuranceShippingMethod(null);
            }
            $quote->setTotalsCollectedFlag(false);
            $quote->collectTotals()->save();
        }
    }

    public function addValue(Varien_Event_Observer $observer) {
        $enabled = Mage::getStoreConfig(
            'shippinginsurance_options/insurance/insurance_enable'
        );

        $quote = $observer->getQuote();
        $address = $quote->getShippingAddress();
        $rate = $address->getShippingRateByCode($address->getInsuranceShippingMethod());

        if ($enabled && $address->getInsuranceShippingMethod() && $rate) {
            $rate->setPrice(
                $address->getShippingValueWithoutInsurance() +
                $address->getShippingInsurance()
            );
        }
    }

    public function preventRecalculate(Varien_Event_Observer $observer) {
        $quote = $observer->getQuote();
        $quote->setTotalsCollectedFlag(false);
        $quote->collectTotals()->save();
    }

}