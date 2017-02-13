<?php

class Itransition_ShippingInsurance_Model_QuoteTotal extends Mage_Sales_Model_Quote_Address_Total_Abstract {
    protected $_code = 'shipping_insurance';

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
        $enabled = Mage::getStoreConfig(
            'shippinginsurance_options/insurance/insurance_enable'
        );

        if ($enabled) {

            $items = $this->_getAddressItems($address);
            if (!count($items)) {
                return $this; //this makes only address type shipping to come through
            }

            $type = Mage::getStoreConfig(
                'shippinginsurance_options/insurance/insurance_type'
            );
            $value = Mage::getStoreConfig(
                'shippinginsurance_options/insurance/insurance_value'
            );

            $quote = $address->getQuote();

            $subTotal = floatval($address->getSubtotal());
            $countedValue = 0;

            if ($type == 1) {
                $countedValue = round($value, 4, PHP_ROUND_HALF_UP);
            }
            elseif ($type == 0) {
                $countedValue = round(
                    $subTotal * ($value / 100),
                    4,
                    PHP_ROUND_HALF_UP
                );
            }
            $quote->setShippingInsurance($countedValue);
            $address->setShippingInsurance($countedValue);
            if ($address->getInsuranceShippingMethod()) {
                $address->setGrandTotal(
                    $address->getGrandTotal() + $address->getShippingInsurance()
                );
                $address->setBaseGrandTotal(
                    $address->getBaseGrandTotal(
                    ) + $address->getShippingInsurance()
                );
            }
        }
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $enabled = Mage::getStoreConfig(
            'shippinginsurance_options/insurance/insurance_enable'
        );
        if ($enabled && $address->getInsuranceShippingMethod()) {
            $amt = $address->getShippingInsurance();
            $address->addTotal(
                array(
                    'code' => $this->getCode(),
                    'title'=>Mage::helper('shippinginsurance')->__('Shipping Insurance'),
                    'value' => $amt
                )
            );
        }
        return $this;
    }
}