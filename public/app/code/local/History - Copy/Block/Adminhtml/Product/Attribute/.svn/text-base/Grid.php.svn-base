<?php

class Acadaca_History_Block_Adminhtml_Product_Attribute_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('historyProductGrid');
        $this->setDefaultSort('product_history_id');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('history/product_attribute')->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $model = Mage::getModel('history/product_attribute');
        $this->addColumn('product_history_id', array(
            'header' => $this->__('ID'),
            'align'  => 'right',
            'width'  => '50px',
            'index'  => 'product_history_id'
        ));
        
        $this->addColumn('product_type_id', array(
            'header' => $this->__('Type'),
            'index'  => 'product_type_id'
        ));
        
        $this->addColumn('product_sku', array(
            'header' => $this->__('SKU'),
            'index'  => 'product_sku'
        ));
        
        $this->addColumn('product_name', array(
            'header' => $this->__('Product'),
            'index'  => 'product_name'
        ));

        $this->addColumn('attribute_label', array(
            'header' => $this->__('Attribute'),
            'index'  => 'attribute_label'
        ));

        $this->addColumn('previous_value', array(
            'header' => $this->__('Previous Value'),
            'index'  => 'previous_value',
            'getter' => array($model, 'getAttributePrevValue')
        ));

        $this->addColumn('value', array(
            'header' => $this->__('Value'),
            'index'  => 'value',
            'getter' => array($model, 'getAttributeNewValue')
        ));

        $this->addColumn('admin_user_id', array(
            'header'  => $this->__('Admin User'),
            'index'   => 'admin_user_id',
            'getter' => array($model, 'getAdminUserName') 
        ));

        $this->addColumn('updated_at', array(
            'header' => $this->__('Updated Date'),
            'index'  => 'updated_at',
            'getter' => array(Mage::helper('history'), 'convertDate')
        ));
    }
    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}