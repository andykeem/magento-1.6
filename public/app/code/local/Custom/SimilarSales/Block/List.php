<?php

class Custom_SimilarSales_Block_List extends Mage_Catalog_Block_Product_List_Upsell
{
    protected function _prepareData()
    {
        $product = Mage::registry('product');
        
        /* @var $product Mage_Catalog_Model_Product */
        $this->_itemCollection = $product->getSimilarSalesCollection()
            ->addAttributeToSort('position', Varien_Db_Select::SQL_ASC)
            ->addStoreFilter();
            
        if (Mage::helper('catalog')->isModuleEnabled('Mage_Checkout')) {
            Mage::getResourceSingleton('checkout/cart')->addExcludeProductFilter($this->_itemCollection,
                Mage::getSingleton('checkout/session')->getQuoteId()
            );

            $this->_addProductAttributesAndPrices($this->_itemCollection);
        }
		//Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($this->_itemCollection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($this->_itemCollection);

        if ($this->getItemLimit('similar_sales') > 0) {
            $this->_itemCollection->setPageSize($this->getItemLimit('similar_sales'));
        }

        $this->_itemCollection->load();

        /**
         * Updating collection with desired items
         */
        Mage::dispatchEvent('similar_sales', array(
            'product'       => $product,
            'collection'    => $this->_itemCollection,
            'limit'         => $this->getItemLimit()
        ));

        foreach ($this->_itemCollection as $product) {
            $product->setDoNotUseCategoryId(true);
        }

        return $this;
    }
}
