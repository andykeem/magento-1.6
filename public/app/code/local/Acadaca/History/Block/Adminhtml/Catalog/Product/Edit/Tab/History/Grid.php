<?php

class Acadaca_History_Block_Adminhtml_Catalog_Product_Edit_Tab_History_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('historyCatalogProductGrid');
        $this->setDefaultSort('product_history_id');
        $this->setSaveParametersInSession(true);
    }
    
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('history/product_attribute')->getCollection();
        $tblAdminUser = $collection->getTable('admin/user');
        
        $collection
            ->addFieldToFilter('product_id', array('eq' => $this->getRequest()->getParam('id')))
            ->getSelect()
            ->joinLeft(array('admin' => $tblAdminUser), 'main_table.admin_user_id = admin.user_id', array('email'))
            ->order('updated_at DESC');
        
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('product_history_id', array(
            'header' => $this->__('ID'),
            'align'  => 'right',
            'width'  => '50px',
            'index'  => 'product_history_id'
        ));
        
        $this->addColumn('attribute_label', array(
            'header' => $this->__('Attribute'),
            'index'  => 'attribute_label'
        ));
        
        $this->addColumn('value', array(
            'header' => $this->__('Value'),
            'index'  => 'value'
        ));

        $this->addColumn('updated_at', array(
            'header' => $this->__('Updated Date'),
            'index'  => 'updated_at',
            'getter' => array(Mage::helper('history'), 'convertDate')
        ));
        
        $this->addColumn('email', array(
            'header'  => $this->__('Admin Email'),
            'index'   => 'email'
        ));
        
//        $this->addColumn('', array(
//            'header' => $this->__(),
//            'index'  => ''
//        ));
    }
}