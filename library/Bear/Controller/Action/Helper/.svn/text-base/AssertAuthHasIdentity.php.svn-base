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
 * Assert that the user is logged in
 *
 * @category Bear
 * @package Bear_Controller
 */
class Bear_Controller_Action_Helper_AssertAuthHasIdentity extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * Auth
     * @var Zend_Auth
     */
    protected $_auth;

    /**
     * Assert that the user is logged in
     *
     * @see assertLoggedIn()
     * @throws Zend_Controller_Action_Exception
     */
    public function direct()
    {
        return $this->assertLoggedIn();
    }

    /**
     * Assert that the user is logged in
     *
     * @throws Bear_Controller_Action_Exception_NotAuthenticated
     */
    public function assertLoggedIn()
    {
        if (!$this->getAuth()->hasIdentity()) {
            /** Bear_Controller_Action_Exception_NotAuthenticated */
            require_once "Bear/Controller/Action/Exception/NotAuthenticated.php";

            throw new Bear_Controller_Action_Exception_NotAuthenticated();
        }
    }

    /**
     * Get the auth object
     *
     * @return Zend_Auth
     * @throws Zend_Controller_Action_Exception if auth is not set
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
     * @return Bear_Controller_Action_Helper_AssertAuthHasIdentity
     */
    public function setAuth(Zend_Auth $auth)
    {
        $this->_auth = $auth;

        return $this;
    }

}