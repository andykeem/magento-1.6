<?php

class Acadaca_History_Block_Adminhtml_Catalog_Product_Edit_Tab_History_Grid_Js extends Mage_Adminhtml_Block_Widget
{
    
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('history/catalog/product/tab/history/grid/js.phtml');
    }
    
    public function getGridBlock()
    {   
        return $this->getLayout()
            ->createBlock('history/adminhtml_catalog_product_edit_tab_history_grid');
    }
}
