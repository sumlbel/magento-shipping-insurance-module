<?php
class Itransition_ShippingInsurance_Block_PaymentMethodField extends Mage_Checkout_Block_Onepage_Abstract
{
    /**
     * Itransition_ShippingInsurance_Block_PaymentMethodField constructor.
     */
    public function __construct() {
        $enabled = $this->isEnabled();

        if ($enabled) {
            $type = Mage::getStoreConfig(
                'shippinginsurance_options/insurance/insurance_type'
            );
            $value = Mage::getStoreConfig(
                'shippinginsurance_options/insurance/insurance_value'
            );

            $quote = $this->getQuote();

            $subTotal = floatval($quote->getSubtotal());
            $countedValue = 0;

            if ($type == 1) {
                $countedValue = round($value, 4, PHP_ROUND_HALF_UP);
            } elseif ($type == 0) {
                $countedValue = round(
                    $subTotal * ($value / 100),
                    4,
                    PHP_ROUND_HALF_UP
                );
            }
            $quote->setShippingInsurance($countedValue);
            $quote->setInsurnceShippingMethod(null);
            $quote->setTotalsCollectedFlag(false);
            $quote->collectTotals()->save();
        }
        parent::_construct();
    }

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