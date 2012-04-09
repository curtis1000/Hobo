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
        $isGlobal   = ($this->_getParam('isGlobal', 0) == 'true') ? 1 : 0; // looks like the boolean comes through as string
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

    public function selectLatestAction()
    {
        // query database for content
        $data = new stdClass;
        $data->isGlobal     = $this->_getParam('isGlobal');
        $data->routeName    = $this->_getParam('routeName');
        $data->handle       = $this->_getParam('handle');

        $contentTable = new Hobo_Db_Table_Content();
        $row = $contentTable->selectLatest($data);
        $rowArray = $row->toArray();
        $this->_helper->json($rowArray);
    }
}