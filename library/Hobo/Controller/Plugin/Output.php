<?php

class Hobo_Controller_Plugin_Output extends Zend_Controller_Plugin_Abstract
{
    /**
     * Modifying the output is only possible here because:
     * resources.frontController.returnResponse = true
     */
    public function dispatchLoopShutdown()
    {
        $front = Zend_Controller_Front::getInstance();
        $filter = new Hobo_Content_Filter();
        
        $response = $front->getResponse();
        $body = $response->getBody();
        $filteredBody = $filter->setInput($body)->filter();
        $response->setBody($filteredBody);
        $response->sendResponse();
    }
}