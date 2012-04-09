<?php

class Acadaca_History_Block_Adminhtml_Widget_Grid_Column_Renderer_Action_Revert extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
    public function render(Varien_Object $row)
    {
        return '<a href="#" onclick="history.revert(\'' . $row->getAttributeCode() . '\', \'' . $row->getValue() . '\')">Revert</a>';
    }
}