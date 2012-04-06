<?php

class Acadaca_History_Model_Product_Attribute extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('history/product_attribute');
    }
    
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $this->setUpdatedAt(now());
    }
    
    public function getAttributePrevValue(Varien_Object $row)
    {
        if ($value = $this->_getAttributeValue($row, 'previous_value')) {
            return $value;
        }
        return $row->getData('previous_value');
    }
    
    public function getAttributeNewValue(Varien_Object $row)
    {
        if ($value = $this->_getAttributeValue($row, 'value')) {
            return $value;
        }
        return $row->getData('value');
    }
    
    protected function _getAttributeValue(Varien_Object $row, $field)
    {
        $attrCode = $row->getAttributeCode();
        $attrValue = $row->getData($field);
        
        $product = Mage::getModel('catalog/product')->load($row->getProductId());
        
        /**
        //if ($attr = $this->_getProductAttribute($product, $row)) {
        if ($attr = $product->getResource()->getAttribute($attrCode)) {
            if ($attr->getFrontendInput() == 'select') {
                $options = $attr->getSource()->getAllOptions();
                return $this->_getAttrOptionValue($options, $attrValue);
            } else {
                return $attrValue;
            }
        }
        */
        
        $product->setData($attrCode, $attrValue); // set product data based on saved data from history table..
        return $product->getResource()->getAttribute($attrCode)->getFrontend()->getValue($product);
    }
    
    /**
    protected function _getProductAttribute(Mage_Catalog_Model_Product $product, Varien_Object $row)
    {
        foreach ($product->getAttributes() as $attr) {
            if ($attr->getAttributeCode() == $row->getAttributeCode()) {
                return $attr;
            }
        }
        return $false;
    }
    
    protected function _getAttrOptionValue(array $options, $value)
    {
        foreach ($options as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
    */
    
    public function getAdminUserName(Varien_Object $row)
    {
        $admin = Mage::getModel('admin/user')->load($row->getAdminUserId());
        return $admin->getFirstname() . ' ' . $admin->getLastname();
    }
}