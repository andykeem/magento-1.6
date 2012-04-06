<?php

class Acadaca_History_Model_Resource_Product_Attribute_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('history/product_attribute');
    }
}