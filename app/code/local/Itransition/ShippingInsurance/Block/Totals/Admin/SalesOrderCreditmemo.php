<?php
class Itransition_ShippingInsurance_Block_Totals_Admin_SalesOrderCreditmemo  extends Mage_Adminhtml_Block_Sales_Order_Creditmemo_Totals
{
    protected $_code = 'shipping_insurance';

    protected function _initTotals()
    {
        parent::_initTotals();
        $order = $this->getOrder();
        $label = Mage::getStoreConfig(
            'shippinginsurance_options/insurance/insurance_label'
        );

        if ($order->getInsuranceShippingMethod()) {
            $amount = $order->getShippingInsurance();
            $this->addTotalBefore(
                new Varien_Object(
                    [
                        'code' => $this->getCode(),
                        'value' => $amount,
                        'base_value' => $amount,
                        'label' => $this->helper('shippinginsurance')->__($label)
                    ],
                    'grand_total'
                )
            );
        }

        return $this;
    }
}
