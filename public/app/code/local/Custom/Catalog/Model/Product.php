<?php

class Custom_Catalog_Model_Product extends Mage_Catalog_Model_Product
{
	/**
	 * get all ordered items based on $product_id except matching $product_id (itself)
	 * 
	 * @return Mage_Catalog_Model_Resource_Product_Collection $prdouctCollection
	 */
	public function getSimilarSalesCollection()
	{
		$productId = $this->getId();
				
		$items = Mage::getModel('sales/order_item')->getCollection();
		$tblOrderItem = $items->getTable('sales/order_item');
		
		// currently simple item(s) are fetched so may need to update below query for configurables..
		$items->addFieldToFilter('main_table.product_id', $productId)
			->getSelect()->reset(Zend_Db_Select::COLUMNS)
			->joinLeft(
				array('o_item' => $tblOrderItem), 
				'main_table.order_id = o_item.order_id AND o_item.product_id <> ' . $productId, 
				array('o_item.product_id')
			)
			->group('o_item.product_id')
			->order('o_item.qty_ordered DESC');
		//echo $items->getSelect()->__toString();
		
		$productIds = array();
		foreach ($items as $item) {
			$productIds[] = $item->getProductId();
		}
		//var_dump($productIds);
		
		$products = Mage::getModel('catalog/product')->getCollection()
			->addFieldToFilter('entity_id', array('in' => $productIds));
		//echo $products->getSelectSql(); exit;
		
		return $products;
	}
}