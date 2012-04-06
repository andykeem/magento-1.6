<?php

class Acadaca_History_Model_Observer
{   
    /**
     * Update product attribute information if value has been changed.
     * 
     * @param Varien_Event_Observer $observer
     * @return Acadaca_History_Model_Observer 
     */
    public function updateProductAttributeHistory(Varien_Event_Observer $observer)
    {
        $event = $observer->getEvent();        
        $product = $event->getProduct();
        //$request = $event->getRequest();
                
        $adminUserId = Mage::helper('history')->getAdminUser()->getId();
        foreach ($product->getAttributes() as $attribute) {
            //Mage::log(get_class($attribute));
            //Mage::log(var_export($attribute->debug(), 1));
            $attrCode = $attribute->getAttributeCode();
            if ($product->dataHasChangedFor($attrCode)) {
                
                /**
                Mage::log('Attribute Code: ' . $attrCode);
                Mage::log('Old: ' . var_export($product->getOrigData($attrCode), 1));
                Mage::log('New: ' . var_export($product->getData($attrCode), 1));
                Mage::log('New Attr: ' . var_export($product->getResource()->getAttribute($attrCode)->getFrontend()->getValue($product), 1));
                foreach ($product->getMediaAttributes() as $attr) {
                    Mage::log('Media Attr: ' . var_export($attr->getFrontend()->getValue($product), 1));
                }
                */
                
                if ($attrCode == 'media_gallery') continue;
                try {
                    Mage::getModel('history/product_attribute')
                        ->setProductId($product->getId())
                        ->setProductTypeId($product->getTypeId())
                        ->setProductSku($product->getSku())
                        ->setProductName($product->getName())
                        ->setAttributeId($attribute->getId())
                        ->setAttributeCode($attribute->getAttributeCode())
                        ->setAttributeLabel($attribute->getFrontEndLabel())
                        ->setPreviousValue($product->getOrigData($attrCode))
                        ->setValue($product->getData($attrCode))
                        ->setAdminUserId($adminUserId)
                        ->save();
                } catch (Exception $e) {
                    Mage::log($e->getMessage());
                }
            }
        }        
        return $this;
    }
    
    // catalog product delete?
    
    // catalog category delete?
    
    
    public function updateCategoryAttributeHistory(Varien_Event_Observer $observer)
    {
        $event = $observer->getEvent();
        $category = $event->getCategory();
        $request = $event->getRequest();
//        Mage::log('request: ' . var_export($request->getPost(), 1));
        
        foreach ($category->getAttributes() as $attr) {
            
            $attrCode = $attr->getAttributeCode();
            if ($category->dataHasChangedFor($attrCode)) {
                //Mage::log('changed: ' . var_export($attr->getData(), 1));
                
                $new = $category->getData($attrCode);
                $orig = $category->getOrigData($attrCode);
                
                // check array value with scalar value since magento returns false if scalar is in array
                if (gettype($new) != gettype($orig)) {
                    if (is_array($new) && count($new) == 1) {                        
                        $new = array_pop($new);
                    }
                    if (is_array($orig) && count($orig) == 1) {
                        $orig = array_pop($orig);
                    }                   
                }
                
                if ($new != $orig) {
                    
                    Mage::log('new: ' . var_export($new, 1));
                    Mage::log('orig: ' . var_export($orig, 1));
                    
                    // create db table for category history and dump neccessary data..
                    
                    
                    
                    
                    
                    
                    
                }
            }
        }
    }
}