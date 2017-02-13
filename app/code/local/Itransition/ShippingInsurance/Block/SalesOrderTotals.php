<?php
class Itransition_ShippingInsurance_Block_SalesOrderTotals extends Mage_Sales_Block_Order_Totals
{
    protected function _initTotals()
    {
        parent::_initTotals();
        $order = $this->getOrder();
        $enabled = Mage::getStoreConfig(
            'shippinginsurance_options/insurance/insurance_enable'
        );
        if ($enabled && $order->getInsuranceShippingMethod()) {
            $amount = $order->getShippingInsurance();
            $this->addTotalBefore(
                new Varien_Object(
                    ['code'      => 'shipping_insurance',
                        'value'     => $amount,
                        'base_value'=> $amount,
                        'label'     => $this->helper('shippinginsurance')->__('Shipping Insurance')],
                    'grand_total'
                )
            );
        }

        return $this;
    }
}
