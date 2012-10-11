<?php
/**
 * Bear
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Controller
 * @since 1.1.0
 */

/** Zend_Controller_Action_Helper_Abstract */
require_once "Zend/Controller/Action/Helper/Abstract.php";

/**
 * Get the current user
 *
 * @category Bear
 * @package Bear_Controller
 */
class Bear_Controller_Action_Helper_CurrentUser extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * Current user
     * @var mixed
     */
    protected $_currentUser;

    /**
     * Auth
     * @var Zend_Auth
     */
    protected $_auth;
    
    /**
     * Loaded flag
     * @var boolean
     */
    protected $_loaded = false;

    /**
     * Assert that the user is logged in
     *
     * @see getCurrentUser()
     * @return mixed
     * @throws Zend_Controller_Action_Exception
     */
    public function direct()
    {
        return $this->getCurrentUser();
    }

    /**
     * Get the current user
     *
     * @return mixed
     */
    public function getCurrentUser()
    {
        if (!$this->_loaded) {
            $this->setCurrentUser(
                $this->getAuth()->getIdentity()
            );
        }

        return $this->_currentUser;
    }

    /**
     * Set the current user
     *
     * @param mixed $currentUser
     * @return Bear_Controller_ActionHelper_CurrentUser
     */
    public function setCurrentUser($currentUser)
    {
        $this->_currentUser = $currentUser;
        $this->_loaded      = true;

        return $this;
    }

    /**
     * Get the auth object
     *
     * @return Zend_Auth
     */
    public function getAuth()
    {
        if (!$this->_auth) {
            require_once 'Zend/Controller/Action/Exception.php';
            throw new Zend_Controller_Action_Exception("No auth set");
        }

        return $this->_auth;
    }

    /**
     * Set the auth object
     *
     * @param Zend_Auth $auth
     * @return Bear_Controller_Action_Helper_CurrentUser
     */
    public function setAuth(Zend_Auth $auth)
    {
        $this->_auth = $auth;

        return $this;
    }

}
