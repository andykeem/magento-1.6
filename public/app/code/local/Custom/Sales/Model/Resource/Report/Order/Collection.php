<?php

class Custom_Sales_Model_Resource_Report_Order_Collection extends Mage_Sales_Model_Resource_Report_Order_Collection
{	
	protected $_filterData = null;
	
	protected function _getSelectedColumns()
    {
        $adapter = $this->getConnection();
        if ('month' == $this->_period) {
            $this->_periodFormat = $adapter->getDateFormatSql('period', '%Y-%m');
        } elseif ('year' == $this->_period) {
            $this->_periodFormat = $adapter->getDateExtractSql('period', Varien_Db_Adapter_Interface::INTERVAL_YEAR);
        } else {
            $this->_periodFormat = $adapter->getDateFormatSql('period', '%Y-%m-%d');
        }

        if (!$this->isTotals()) {
            $this->_selectedColumns = array(
                'period'                         => $this->_periodFormat,
                'orders_count'                   => 'SUM(orders_count)',
                'total_qty_ordered'              => 'SUM(total_qty_ordered)',
                'total_qty_invoiced'             => 'SUM(total_qty_invoiced)',
                'total_income_amount'            => 'SUM(total_income_amount)',
                'total_revenue_amount'           => 'SUM(total_revenue_amount)',
                'total_profit_amount'            => 'SUM(total_profit_amount)',
                'total_invoiced_amount'          => 'SUM(total_invoiced_amount)',
                'total_canceled_amount'          => 'SUM(total_canceled_amount)',
                'total_paid_amount'              => 'SUM(total_paid_amount)',
                'total_refunded_amount'          => 'SUM(total_refunded_amount)',
                'total_tax_amount'               => 'SUM(total_tax_amount)',
                'total_tax_amount_actual'        => 'SUM(total_tax_amount_actual)',
                'total_shipping_amount'          => 'SUM(total_shipping_amount)',
                'total_shipping_amount_actual'   => 'SUM(total_shipping_amount_actual)',
                'total_discount_amount'          => 'SUM(total_discount_amount)',
                'total_discount_amount_actual'   => 'SUM(total_discount_amount_actual)',
            );
        }

        if ($this->isTotals()) {
            $this->_selectedColumns = $this->getAggregatedColumns();
        }
		
        $this->_setTableAlias('sales_order_aggregated_created');
		
        //$this->_selectedColumns['customer_group_code'] = 'c_group.customer_group_code';			
        
		return $this->_selectedColumns;
    }
    
	protected function _initSelect()
    {
    	
    	$tblOrder = $this->getResource()->getTable('sales/order');
	    $tblCustomer = $this->getResource()->getTable('customer/entity');
	    $tblCustGroup = $this->getResource()->getTable('customer/customer_group');
	    	
    	$this->getSelect()->from($this->getResource()->getMainTable(), $this->_getSelectedColumns())
	    	->joinLeft(array('order' => $tblOrder), 'sales_order_aggregated_created.period = DATE(order.created_at)', array())
	       	->joinLeft(array('cust' => $tblCustomer), 'order.customer_id = cust.entity_id', array())
	       	->joinLeft(array('c_group' => $tblCustGroup), 'cust.group_id = c_group.customer_group_id', array('customer_group_code'));            
    	    	   	
        if (!$this->isTotals()) {
            $this->getSelect()->group($this->_periodFormat);
        }
        
        return $this;
    }
	
    protected function _applyStoresFilterToSelect(Zend_Db_Select $select)
    {
        $nullCheck = false;
        $storeIds  = $this->_storesIds;

        if (!is_array($storeIds)) {
            $storeIds = array($storeIds);
        }

        $storeIds = array_unique($storeIds);

        if ($index = array_search(null, $storeIds)) {
            unset($storeIds[$index]);
            $nullCheck = true;
        }

        $storeIds[0] = ($storeIds[0] == '') ? 0 : $storeIds[0];

        if ($nullCheck) {
            $select->where('sales_order_aggregated_created.store_id IN(?) OR store_id IS NULL', $storeIds);
        } else {
            $select->where('sales_order_aggregated_created.store_id IN(?)', $storeIds);
        }

        return $this;
    }
    
    protected function _setTableAlias($alias)
    {
    	$cols = array();
    	foreach ($this->_selectedColumns as $key => $col) {
	    	$cols[$key] = str_ireplace('sum(', "sum({$alias}.", $col);
    	}
    	$this->_selectedColumns = $cols;
    }
    
    public function addCustomerGroupFilter(array $custGroups)
    {
    	
    	return $this;
    }
    
}
