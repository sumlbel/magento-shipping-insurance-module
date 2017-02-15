<?php
class Itransition_ShippingInsurance_Model_Total_Invoice extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
        $order = $invoice->getOrder();
        $amount = $order->getShippingInsurance();
        $enabled = Mage::getStoreConfig(
            'shippinginsurance_options/insurance/insurance_enable'
        );

        if ($enabled && $order->getInsuranceShippingMethod()) {
            $invoice->setGrandTotal($invoice->getGrandTotal() + $amount);
            $invoice->setBaseGrandTotal(
                $invoice->getBaseGrandTotal() + $amount
            );
        }

        return $this;
    }
}
