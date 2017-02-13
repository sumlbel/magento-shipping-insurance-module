<?php
class Itransition_ShippingInsurance_Block_InsuranceField extends Mage_Checkout_Block_Onepage_Abstract
{
    public function getInsuranceValue() {
        $quote = $this->getQuote();
        $value = round(
            $quote->getShippingInsurance(),
            2,
            PHP_ROUND_HALF_UP
        );
        $value = Mage::helper('core')->currency($value, true, false);
        return $value;
    }

    public function isEnabled() {
        return Mage::getStoreConfig(
            'shippinginsurance_options/insurance/insurance_enable'
        );
    }
}
