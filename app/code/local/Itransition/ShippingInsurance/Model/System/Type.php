<?php
class Itransition_ShippingInsurance_Model_System_Type
{
    /**
    * Provide available options as a value/label array
    *
    * @return array
    */
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => 'Procentage'],
            ['value' => 1, 'label' => 'Absolute']
        ];
    }
}
