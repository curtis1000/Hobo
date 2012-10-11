<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_View
 */

/**
 * ACL checking helper
 *
 * @category Bear
 * @package Bear_View
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 */
class Bear_View_Helper_IsAllowed
{

    /**
     * ACL object
     * 
     * @var Zend_Acl
     */
    private $_acl;

    /**
     * Get the current role
     * 
     * @var string|Zend_Acl_Role_Interface
     */
    private $_role;
    
    /**
     * Get the auth
     * 
     * @var Zend_Auth
     */
    private $_auth;

    /**
     * Get the ACL object
     *
     * @return Zend_Acl
     * @throws UnexpectedValueException
     */
    public function getAcl()
    {
        if (!$this->_acl) {
            throw new UnexpectedValueException("No ACL set");
        }

        return $this->_acl;
    }

    /**
     * Get the current role either from the directly set role, or from the auth
     *
     * @return string|Zend_Acl_Role_Interface
     */
    public function getCurrentRole()
    {
        if ($this->getAuth()) {
            return $this->getAuth()->getIdentity();
        }

        return $this->_role;
    }
    
    /**
     * Get the auth
     *
     * @return Zend_Auth
     */
    public function getAuth()
    {
        return $this->_auth;
    }

    /**
     * Check if the user is allowed
     *
     * @param string|Zend_Acl_Resource_Interface $resource
     * @param string $permission
     * @return boolean
     */
    public function isAllowed($resource, $permission = null)
    {
        return $this->getAcl()->isAllowed(
            $this->getCurrentRole(),
            $resource,
            $permission
        );
    }

    /**
     * Set the ACL object
     *
     * @param Zend_Acl $acl
     * @return Bear_View_Helper_IsAllowed
     */
    public function setAcl(Zend_Acl $acl)
    {
        $this->_acl = $acl;

        return $this;
    }

    /**
     * Set the current role
     *
     * @param string|Zend_Acl_Role_Interface $role
     * @return Bear_View_Helper_IsAllowed
     */
    public function setCurrentRole($role)
    {
        $this->_role = $role;

        return $this;
    }
    
    /**
     * Set the current role
     *
     * @param Zend_Auth $auth
     * @return Bear_View_Helper_IsAllowed
     */
    public function setAuth($auth)
    {
        $this->_auth = $auth;

        return $this;
    }

}