<?php

class Hobo_AjaxController extends Hobo_Controller_Action
{
    public function isAdminAction()
    {
        $this->_helper->json($this->_helper->user->isAdmin());
    }
    
    public function saveAction()
    {
        $routeName  = $this->_getParam('routeName', 'public-home');
        $handle     = $this->_getParam('handle', 'main');
        $isGlobal   = (int) $this->_getParam('isGlobal', 0);
        $content    = $this->_getParam('content', '');
        
        $revision = $this->_helper->revision->getNext($routeName, $handle, $isGlobal);
        
        $contentTable = new Hobo_Db_Table_Content();

        $contentTable->insert(array(
            'routeName'     => $routeName,
            'handle'        => $handle,
            'isGlobal'      => $isGlobal,
            'content'       => $content,
            'revision'      => $revision,
        ));
        
        $this->_helper->json(true);
    }
}