<?php

class Custom_Adminhtml_Block_Report_Sales_Sales_Grid extends Mage_Adminhtml_Block_Report_Sales_Sales_Grid
{	
	protected function _prepareCollection()
    {
        $filterData = $this->getFilterData();

        if ($filterData->getData('from') == null || $filterData->getData('to') == null) {
            $this->setCountTotals(false);
            $this->setCountSubTotals(false);
            return parent::_prepareCollection();
        }

        $storeIds = $this->_getStoreIds();;

        $orderStatuses = $filterData->getData('order_statuses');
        if (is_array($orderStatuses)) {
            if (count($orderStatuses) == 1 && strpos($orderStatuses[0],',')!== false) {
                $filterData->setData('order_statuses', explode(',',$orderStatuses[0]));
            }
        }

        $resourceCollection = Mage::getResourceModel($this->getResourceCollectionName())
            ->setPeriod($filterData->getData('period_type'))
            ->setDateRange($filterData->getData('from', null), $filterData->getData('to', null))
            ->addStoreFilter($storeIds)
            ->addOrderStatusFilter($filterData->getData('order_statuses'))
            ->addCustomerGroupFilter($filterData->getData('customer_group'))
            ->setAggregatedColumns($this->_getAggregatedColumns());

        if ($this->_isExport) {
            $this->setCollection($resourceCollection);
            return $this;
        }

        if ($filterData->getData('show_empty_rows', false)) {
            Mage::helper('reports')->prepareIntervalsCollection(
                $this->getCollection(),
                $filterData->getData('from', null),
                $filterData->getData('to', null),
                $filterData->getData('period_type')
            );
        }
                        
		if ($this->getCountSubTotals()) {
            $this->getSubTotals();
        }

        if ($this->getCountTotals()) {
            $totalsCollection = Mage::getResourceModel($this->getResourceCollectionName())
                ->setPeriod($filterData->getData('period_type'))
                ->setDateRange($filterData->getData('from', null), $filterData->getData('to', null))
                ->addStoreFilter($storeIds)
                ->addOrderStatusFilter($filterData->getData('order_statuses'))
                ->setAggregatedColumns($this->_getAggregatedColumns())
                ->isTotals(true);
            foreach ($totalsCollection as $item) {
                $this->setTotals($item);
                break;
            }
        }

        $this->getCollection()->setColumnGroupBy($this->_columnGroupBy);
        $this->getCollection()->setResourceCollection($resourceCollection);

        return parent::_prepareCollection();
    }
    
    /**
	protected function _prepareColumns()
	{
		parent::_prepareColumns();

		$this->addColumn('customer_group_code', array(
			'header' => Mage::helper('sales')->__('Customer Group'),
			'index'	 => 'customer_group_code',
			'sortable' => false
		));
	}
	*/
}