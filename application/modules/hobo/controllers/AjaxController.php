<?php

class Hobo_AjaxController extends Hobo_Controller_Action
{
    public function isAdminAction()
    {
        $hoboUser = new Hobo_User();
        $this->_helper->json($hoboUser->isLoggedIn());
    }
    
    public function saveAction()
    {
        $params = array(
            'routeName'     => $this->_getParam('routeName'),
            'handle'        => $this->_getParam('handle'),
            'contentType'   => $this->_getParam('contentType'),
            'isGlobal'      => ($this->_getParam('isGlobal', 0) == 'true') ? 1 : 0, // the boolean comes through as string, filter to int
            'content'       => $this->_getParam('content'),
        );

        $contentTable = new Hobo_Db_Table_Content();
        $params['revision'] = $contentTable->getNextRevision($params);
        $contentTable->insert($params);
        $this->_helper->json(true);
    }

    public function selectLatestAction()
    {
        // query database for content
        $params = array(
            'isGlobal'  => ($this->_getParam('isGlobal', 0) == 'true') ? 1 : 0, // the boolean comes through as string, filter to int
            'routeName' => $this->_getParam('routeName'),
            'handle'    => $this->_getParam('handle'),
        );

        $contentTable = new Hobo_Db_Table_Content();
        $row = $contentTable->selectLatest($params);
        if ($row instanceof Hobo_Db_Table_Row_Content) {
            $rowArray = $row->toArray();
        } else {
            // no result, send back empty array
            $rowArray = array();
        }
        $this->_helper->json($rowArray);
    }

    public function selectAllVersionsAction()
    {
        // query database for content
        $params = array(
            'isGlobal'  => ($this->_getParam('isGlobal', 0) == 'true') ? 1 : 0, // the boolean comes through as string, filter to int
            'routeName' => $this->_getParam('routeName'),
            'handle'    => $this->_getParam('handle'),
        );

        $contentTable = new Hobo_Db_Table_Content();
        $rows = $contentTable->selectAllVersions($params);
        $rows = $rows->toArray();
        foreach ($rows as &$row) {
            // pretty-up the date format
            $row['created'] = date('F jS, Y, g:i A', strtotime($row['created']));
        }
        $this->_helper->json($rows);
    }
}