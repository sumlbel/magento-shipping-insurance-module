<?php
$installer = new Mage_Sales_Model_Resource_Setup('core_setup');
/**
 * Add 'custom_attribute' attribute for entities
 */
$entities = array(
    'quote',
    'quote_address',
    'order'
);
$valueOptions = array(
    'type'     => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'scale'     => 12,
    'precision' => 4,
    'visible'  => true,
    'required' => false
);
$methodOptions = array(
    'type'     => Varien_Db_Ddl_Table::TYPE_VARCHAR,
    'visible'  => true,
    'required' => false
);
foreach ($entities as $entity) {
    $installer->addAttribute($entity, 'shipping_insurance', $valueOptions);
    $installer->addAttribute($entity, 'insurance_shipping_method', $methodOptions);
}
$installer->endSetup();
