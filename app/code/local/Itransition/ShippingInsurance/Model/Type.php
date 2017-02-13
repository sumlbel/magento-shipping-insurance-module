<?php
class Itransition_ShippingInsurance_Model_Type
{
  /**
   * Provide available options as a value/label array
   *
   * @return array
   */
  public function toOptionArray()
  {
    return array(
      array('value'=>0, 'label'=>'Procentage'),
      array('value'=>1, 'label'=>'Absolute')
    );
  }
}