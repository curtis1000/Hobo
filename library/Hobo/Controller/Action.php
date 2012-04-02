<?php

class Hobo_Controller_Action extends Zend_Controller_Action
{
    public function preDispatch()
    {
        $this->view->routeName = Zend_Controller_Front::getInstance()->getRouter()->getCurrentRouteName();
    }
    
    public function postDispatch()
    {
        
        

    }
    
    public function dispatchLoopShutdown()
    {
        die(__FILE__);
    }
}