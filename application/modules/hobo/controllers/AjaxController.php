<?php

class Hobo_AjaxController extends Hobo_Controller_Action
{
    public function isAdminAction()
    {
        $this->_helper->json($this->_helper->user->isAdmin());
    }
}