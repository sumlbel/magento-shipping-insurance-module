<?php

class Itransition_ShippingInsurance_Model_System_Number extends Mage_Core_Model_Config_Data
{
    public function save()
    {
        $number = $this->getValue();
        if (!is_numeric($number))  {
            Mage::getSingleton('core/session')->addError('Value has to be numeric');

            return true;
        }

        $number = floatval($number);
        if ($number < 0) {
            Mage::getSingleton('core/session')->addError('Value has to be positive');

            return true;
        }

        return parent::save();
    }
}
