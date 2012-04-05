<?php require_once(realpath(dirname(__FILE__) . '/app/Mage.php'));
Mage::app();

function getSimilarSales($pid)
{
	$p = Mage::getModel('catalog/product')->load($pid);
	//var_dump($p->debug());
	
	$items = Mage::getModel('sales/order_item')->getCollection();
	$tblOrderItem = $items->getTable('sales/order_item');
	
	$items
		->addFieldToFilter('main_table.product_id', $p->getId())
		->getSelect()->reset(Zend_Db_Select::COLUMNS)
		->join(array('o_item' => $tblOrderItem), 'main_table.order_id = o_item.order_id AND o_item.product_id <> ' . $p->getId(), array('o_item.product_id'))
		;
	//echo $collection->getSelectSql();
	
	$productIds = array();
	foreach ($items as $item) {
		$productIds[] = $item->getProductId();
	}
	//var_dump($productIds);
		
	$products = Mage::getModel('catalog/product')->getCollection()
		->addFieldToFilter('entity_id', array('in' => $productIds));
	//echo $products->getSelectSql();
	
	return $products;	
}
//getSimilarSales(27);