<?php

class Acadaca_History_Block_Adminhtml_Catalog_Product_Edit_Tab_History_Grid_Js extends Mage_Adminhtml_Block_Abstract
{
    protected $_gridBlock;
    protected $_request;
    
    public function setGridBlock(Acadaca_History_Block_Adminhtml_Catalog_Product_Edit_Tab_History_Grid $block)
    {
        $this->_gridBlock = $block;
        return $this;
    }
    
    public function getGridBlock()
    {
        return $this->_gridBlock;
    }
    
//    public function setRequest(Mage_Core_Controller_Request_Http $request)
//    {
//        $this->_request = $request;
//        return $this;
//    }
//    
//    public function getRequest()
//    {
//        return $this->_request;
//    }
}