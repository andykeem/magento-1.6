<?php

class Acadaca_History_Block_Adminhtml_Catalog_Product_Edit_Tabs extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        
        // check if product exists in history table..
        $product = $this->getProduct();
        if (Mage::getModel('history/product_attribute')->load($product->getId(), 'product_id')->getId()) {

//            $jsBlock = $this->getLayout()->createBlock('history/adminhtml_catalog_product_edit_tab_history_grid_js');
//            $this->append($jsBlock);
            
            $gridBlock = $this->getLayout()->createBlock('history/adminhtml_catalog_product_edit_tab_history_grid');

            /**            
            $this->addTab('history', array(
                'label' => Mage::helper('catalog')->__('History'),
                'url'   => "javascript: history.dialog({url: '{$this->getUrl('adminhtml/history/editProduct')}', params: {id: '{$product->getId()}', ajax: '1'}}); {$gridBlock->getJsObjectName()}.reload(); void(0);",
                'title' => ''
            ));
            */
            
            $this->addTab('history', array(
                'label' => Mage::helper('catalog')->__('History'),
                'url'   => "javascript: history.dialog({id: '{$gridBlock->getId()}'}); {$gridBlock->getJsObjectName()}.reload('{$this->getUrl('adminhtml/history/editProduct', array('id' => $product->getId(), 'ajax' => true))}'); void(0);",
                'title' => ''
            ));
        }
    }
}
