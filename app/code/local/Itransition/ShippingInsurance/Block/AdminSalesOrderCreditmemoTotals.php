<?php
class Itransition_ShippingInsurance_Block_AdminSalesOrderCreditmemoTotals  extends Mage_Adminhtml_Block_Sales_Order_Creditmemo_Totals {
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
