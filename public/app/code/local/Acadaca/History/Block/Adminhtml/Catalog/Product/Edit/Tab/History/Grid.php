<?php

class Acadaca_History_Block_Adminhtml_Catalog_Product_Edit_Tab_History_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('historyCatalogProductGrid');
        $this->setDefaultSort('product_history_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('history/product_attribute')->getCollection();
        $tblAdminUser = $collection->getTable('admin/user');
        
        $collection
            ->addFieldToFilter('product_id', array('eq' => $this->getRequest()->getParam('id')))
            ->getSelect()
            ->joinLeft(array('admin' => $tblAdminUser), 'main_table.admin_user_id = admin.user_id', array('email'));
        
        $this->setCollection($collection);
        parent::_prepareCollection();
        
//        Mage::log('sql: ' . $this->getCollection()->getSelectSql());
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
        
        $this->addColumn('action', array(
            'header'   => $this->__('Action'),
            'index'    => 'action',
            'sortable' => false,
            'renderer' => 'Acadaca_History_Block_Adminhtml_Widget_Grid_Column_Renderer_Action_Revert'
        ));
    }
    
    public function getGridUrl()
    {
        return $this->getUrl('adminhtml/history/editProduct', array(
            'id' => $this->getRequest()->getParam('id')
        ));
    }
}
