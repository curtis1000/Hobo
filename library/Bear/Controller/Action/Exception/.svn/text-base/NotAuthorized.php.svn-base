<?php
/**
 * Bear
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Controller
 * @since 1.1.0
 */

/** Zend_Controller_Action_Exception */
require_once "Zend/Controller/Action/Exception.php";

/**
 * Not authorized exception
 *
 * @category Bear
 * @package Bear_Controller
 */
class Bear_Controller_Action_Exception_NotAuthorized extends Zend_Controller_Action_Exception
{

    /**
     * Permission
     * @var string
     */
    private $_permission;

    /**
     * Resource
     * @var Zend_Acl_Resource_Interface|string
     */
    private $_resource;

    /**
     * Role
     * @var Zend_Acl_Role_Interface|string
     */
    private $_role;

    /**
     * Constructor
     *
     * @param Zend_Acl_Role_Interface|string $role
     * @param Zend_Acl_Resource_Interface|string $resource
     * @param string $privilege
     */
    public function __construct($role = null, $resource = null, $permission = null)
    {
        $this->_role       = $role;
        $this->_resource   = $resource;
        $this->_permission = $permission;

        parent::__construct(sprintf(
            "Role '%s' does not have permission '%s' on resource '%s'",
            $this->getRoleString(),
            $this->getPermissionString(),
            $this->getResourceString()
        ));
    }

    /**
     * Get the permission
     *
     * @return string
     */
    public function getPermission()
    {
        return $this->_permission;
    }

    /**
     * Get the permission string
     *
     * @return string
     */
    public function getPermissionString()
    {
        $permission = $this->getPermission();

        if (!$permission) {
            return "*";
        }

        return $permission;
    }

    /**
     * Get the resource
     *
     * @return Zend_Acl_Resource_Interface|string
     */
    public function getResource()
    {
        return $this->_resource;
    }

    /**
     * Get the resource as a string
     *
     * @return string
     */
    public function getResourceString()
    {
        $resource = $this->getResource();

        if (!$resource) {
            return "*";
        }

        if ($resource instanceof Zend_Acl_Resource_Interface) {
            return $resource->getResourceId();
        }

        return $resource;
    }

    /**
     * Get the role
     *
     * @return Zend_Acl_Role_Interface|string
     */
    public function getRole()
    {
        return $this->_role;
    }

    /**
     * Get the role as a string
     *
     * @return string
     */
    public function getRoleString()
    {
        $role = $this->getRole();

        if (!$role) {
            return "*";
        }

        if ($role instanceof Zend_Acl_Role_Interface) {
            return $role->getRoleId();
        }

        return $role;
    }

}