<?php

class Acadaca_History_Block_Adminhtml_Catalog_Product_Edit_Tabs extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        
        // check if product exists in history table..
        $product = $this->getProduct();
        if (Mage::getModel('history/product_attribute')->load($product->getId(), 'product_id')->getId()) {
        
            $content = $this->_translateHtml($this->getLayout()
//                ->createBlock('history/adminhtml_catalog_product_edit_tab_history')->toHtml());
                ->createBlock('history/adminhtml_catalog_product_edit_tab_history_grid')->toHtml());
            
//            $content = addslashes($content);
//            
//            // get javascript section
//            $pattern = '/<script.*>\s*(.*)\s*/i';
//            if (preg_match($pattern, $content, $matches)) {
//                Mage::log('matches:' . var_export($matches, 1));
//            } else {
//                Mage::log('no matches..');
//            }
            
//            $content = addslashes($this->escapeHtml($content, array('script')));

//            $this->addTab('history', array(
//                'label' => Mage::helper('catalog')->__('History'),
//                'url'   => "javascript: Dialog.confirm('{$content}', {
//                                draggable:true,
//                                resizable:true,
//                                closable:true,
//                                className: 'magento',
//                                windowClassName: 'popup-window',
//                                title: 'History',
//                                width: 950,
//                                height: 555,
//                                zIndex: 1000,
//                                recenterAuto: false,
//                                hideEffect: Element.hide,
//                                showEffect: Element.show,
//                                id: 'catalog-wysiwyg-editor',
//                                buttonClass: 'form-button',
//                                okLabel: '',
//                                cancelLabel: 'Close'
//                            });
//                            void(0);"
//            ));
            
            $this->addTab('history', array(
                'label' => Mage::helper('catalog')->__('History'),
                'url' => "javascript: openDialog(); void(0);"
            ));         
        }
    }
}
