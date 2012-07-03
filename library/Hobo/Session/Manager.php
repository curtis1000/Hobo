<?php
/**
 * Used by Hobo_User
 */
class Hobo_Session_Manager
{
    protected $_session;

    public function get()
    {
        if (empty($this->_session)) {
            $this->_session = new Zend_Session_Namespace('hobo_' . APPLICATION_ENV);
        }
        return $this->_session;
    }

    public function destroy()
    {
        $session = $this->get();
        $session = new stdClass();
    }
}
