<?php

class Acadaca_History_Helper_Data extends Mage_Core_Helper_Data
{
    // convert UTC to site's timezone
    public function convertDate(Varien_Object $row)
    {
        $updatedAt = Mage::getModel('core/date')->timestamp(strtotime($row->getUpdatedAt()));
        return date('Y-m-d H:i:s', $updatedAt);
    }
    
    public function getAdminUser()
    {
        return Mage::getSingleton('admin/session')->getUser();
    }
}