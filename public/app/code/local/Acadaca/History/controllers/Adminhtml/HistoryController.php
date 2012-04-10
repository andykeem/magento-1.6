<?php

class Acadaca_History_Adminhtml_HistoryController extends Mage_Adminhtml_Controller_Action
{
    // run it on local or qa environment for now..
    protected function _runnable()
    {
        $host = $this->getRequest()->getHttpHost();
        return ((Mage::getIsDeveloperMode()) || (strpos('qa.acacloud.com', $host) !== false));
    }
    
    public function indexAction()
    {
        if (!$this->_runnable()) {
            $this->_forward('index', 'dashboard', 'admin');
            return;
        }
        $this->_title($this->__('History'))->_title($this->__('Product'));
        $this->loadLayout();
        $this->_setActiveMenu('history');
        $this->_addBreadcrumb($this->__('Product History'), $this->__('Product History'));
        $this->_addContent($this->getLayout()->createBlock('history/adminhtml_product_attribute_grid'));
        $this->renderLayout();
    }
    
    public function editProductAction()
    {                
        $block = $this->getLayout()
//            ->createBlock('history/adminhtml_catalog_product_edit_tab_history')->toHtml();
            ->createBlock('history/adminhtml_catalog_product_edit_tab_history_grid');

        $this->_response->setBody($block->toHtml());
    }
}
