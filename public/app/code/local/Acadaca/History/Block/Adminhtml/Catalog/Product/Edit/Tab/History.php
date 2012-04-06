<?php

class Acadaca_History_Block_Adminhtml_Catalog_Product_Edit_Tab_History extends Mage_Adminhtml_Block_Widget
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('catalog/product/tab/history.phtml');
    }
    
    public function getItems()
    {
        $items = Mage::getModel('history/product_attribute')->getCollection();
        $tblAdminUser = $items->getTable('admin/user');
        $items
            ->addFieldToFilter('product_id', array('eq' => $this->getRequest()->getParam('id')))
            ->getSelect()
            ->joinLeft(array('admin' => $tblAdminUser), 'main_table.admin_user_id = admin.user_id', array('email'))
            ->order('updated_at DESC');
//        Mage::log($items->getSelectSql());
        return $items;
    }
}
