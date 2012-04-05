<?php
	  
class Custom_Adminhtml_Block_Report_Filter_Form_Order extends Mage_Sales_Block_Adminhtml_Report_Filter_Form_Order
{	
	protected function _prepareForm()
	{
    	parent::_prepareForm();
    	$form = $this->getForm();
    	$htmlIdPrefix = $form->getHtmlIdPrefix();
    	$fieldset = $this->getForm()->getElement('base_fieldset');
    			       
    	if (is_object($fieldset) && $fieldset instanceof Varien_Data_Form_Element_Fieldset) {
	        $fieldset->addField('customer_group', 'multiselect', array(
	        	'name' => 'customer_group',
	        	'values' => $this->_getCustomerGroups(),
	        	'label' => Mage::helper('reports')->__('Customer Group'),
	        	'title' => Mage::helper('reports')->__('Customer Group')
	        ));
    	}
    	
        return $this;
    }
    
    protected function _getCustomerGroups()
    {    
        $custGroups = array();
        $groups = Mage::getModel('customer/group')->getCollection();
        foreach ($groups as $group) {
        	$custGroups[] = array(
        		'label' => $group->getCustomerGroupCode(),
        		'value' => $group->getCustomerGroupId() 
        	);
        }
        return $custGroups;
    }
}