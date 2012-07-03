<?php

class Hobo_User
{
    protected $_session;

    protected function initSession()
    {
        if (empty($this->_session)) {
            $hoboSessionManager = new Hobo_Session_Manager();
            $this->_session = $hoboSessionManager->get();
        }
    }

    // called from external code, whichever user system the site implements will
    // need to call this to enable the cms for admin users
    public function logIn($username)
    {
        $this->initSession();
        $this->_session->username = $username;
    }

    public function isLoggedIn()
    {
        $this->initSession();
        return (! empty($this->_session->username));
    }

    public function getUsername()
    {
        $this->initSession();
        if ($this->isLoggedIn()) {
            return $this->_session->username;
        }
    }

    public function logOut()
    {
        $this->_session->destroy();
    }
}