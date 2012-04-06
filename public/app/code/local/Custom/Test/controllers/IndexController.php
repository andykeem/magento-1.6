<?php

class Custom_Test_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
//        $this->_response->setBody(__CLASS__);
        $config = Mage::getConfig();
        $confs = $config->getNode()->asArray();
//        var_dump($confs);
//        var_dump($confs['global']['events']);       
        $events = $confs['global']['events'];
        $eventKeys = array_keys($events);
        asort($eventKeys);
        var_dump($eventKeys);
    }
}