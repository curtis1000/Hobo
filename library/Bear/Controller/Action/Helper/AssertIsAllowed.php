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
class Bear_Controller_Action_Helper_AssertIsAllowed extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * ACL
     * @var Zend_Acl
     */
    protected $_acl;

    /**
     * Assert that a user is allowed
     *
     * @param  Zend_Acl_Role_Interface|string $role
     * @param  Zend_Acl_Resource_Interface|string $resource
     * @param  string $privilege
     * @see assertIsAllowed()
     * @throws Zend_Controller_Action_Exception
     */
    public function direct($role = null, $resource = null, $permission = null)
    {
        $this->assertIsAllowed($role, $resource, $permission);
    }

    /**
     * Assert that a role can access a resource
     *
     * @param  Zend_Acl_Role_Interface|string $role
     * @param  Zend_Acl_Resource_Interface|string $resource
     * @param  string $privilege
     * @throws Zend_Controller_Action_Exception
     */
    public function assertIsAllowed($role = null, $resource = null, $permission = null)
    {
        if (!$this->getAcl()->isAllowed($role, $resource, $permission)) {
            /** Bear_Controller_Action_Exception_NotAuthorized */
            require_once "Bear/Controller/Action/Exception/NotAuthorized.php";

            throw new Bear_Controller_Action_Exception_NotAuthorized(
                $role,
                $resource,
                $permission
            );
        }
    }

    /**
     * Get the ACL
     *
     * @return Zend_Acl
     * @throws Zend_Controller_Action_Exception if acl is not set
     */
    public function getAcl()
    {
        if (!$this->_acl) {
            require_once 'Zend/Controller/Action/Exception.php';
            throw new Zend_Controller_Action_Exception("No acl set");
        }

        return $this->_acl;
    }

    /**
     * Set the ACL
     *
     * @param Zend_Acl $acl
     * @return Bear_Controller_Action_Helper_AssertIsAllowed
     */
    public function setAcl(Zend_Acl $acl)
    {
        $this->_acl = $acl;

        return $this;
    }

}