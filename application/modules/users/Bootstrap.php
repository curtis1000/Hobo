<?php
/**
 * Bear Users Module
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 */

/**
 * Users module bootstrap
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Bootstrap extends Zend_Application_Module_Bootstrap
{

    /**
     * Initialize the action helpers
     * 
     * @return void
     */
    protected function _initActionHelpers()
    {
        $this->getApplication()->bootstrap('frontController');

        Zend_Controller_Action_HelperBroker::addPath(
            dirname(__FILE__) . "/controllers/actionhelpers/",
            "Users_Controller_ActionHelper_"
        );
    }
        
    /**
     * Initialize auth action helpers
     *
     * @return void
     */
    protected function _initAuthHelpers()
    {
        $this->bootstrap('auth')
             ->bootstrap('acl');
        
        Zend_Controller_Action_HelperBroker::getStaticHelper("assertAuthHasIdentity")
                                           ->setAuth($this->getResource("auth"));
                                           
        Zend_Controller_Action_HelperBroker::getStaticHelper("assertIsAllowed")
                                           ->setAcl($this->getResource("acl"));
                                           
        
    }

    /**
     * Initialize the Login Action Helper
     *
     * @return void
     */
    protected function _initLoginHelper()
    {
        $this->bootstrap('authAdapter')
             ->bootstrap('auth');

        $this->getApplication()
             ->bootstrap('frontController');
                     
        $loginRoute = array(
            'module'     => 'users',
            'controller' => 'account',
            'action'     => 'login',
        );
    
        Zend_Controller_Action_HelperBroker::getStaticHelper("login")
                                           ->setFormActionUrlOptions($loginRoute)
                                           ->setAuth($this->getResource("auth"))
                                           ->setAuthAdapter($this->getResource("authAdapter"));
    }
    
    /**
     * Initialize the ACL
     * 
     * @return Zend_Acl
     */
    protected function _initAcl()
    {
        if (in_array('acl', $this->getApplication()->getClassResourceNames())) {
            // attempt to retrieve ACL from main application bootstrap
            $acl = $this->getApplication()
                        ->bootstrap('acl')
                        ->getResource('acl');
        } else {
            // main application bootstrap does not have an ACL resource, so create one
            $acl = new Zend_Acl();
            $this->_setResourceToApplication('acl', $acl);
        }

        /**
         * Roles
         */
        $adminRole = new Zend_Acl_Role(Users_Model_DbTable_Users::ROLE_ADMIN);
        $userRole  = new Zend_Acl_Role(Users_Model_DbTable_Users::ROLE_USER);
        
        $acl->addRole($userRole)
            ->addRole($adminRole, $userRole);

        /**
         * Resources
         */
        $userResource = new Zend_Acl_Resource("user");
        
        $acl->addResource($userResource);

        /**
         * Permissions
         */
        
        // admin can manage all users
        $acl->allow($adminRole, $userResource);
            
        return $acl;
    }
    
    /**
     * Initialize the auth object
     *
     * @return Zend_Auth
     */
    protected function _initAuth()
    {
        $auth = Zend_Auth::getInstance();
        
        $this->_setResourceToApplication('auth', $auth);
        
        return $auth;
    }

    /**
     * Initialize the auth adapter object
     *
     * @return Zend_Auth_Adapter_Interface
     */
    protected function _initAuthAdapter()
    {
        $this->bootstrap('userDbTable');

        $dbAdapter = $this->getApplication()
                          ->bootstrap('db')
                          ->getResource('db');

        if (Bear_Crypt_Blowfish::isSupported()) {
            $authAdapter = new Bear_Auth_Adapter_BlowfishDbTable(
                $dbAdapter,
                $this->getResource('userDbTable'),
                'email',
                'password'
            );
        } else {
            $authAdapter = new Zend_Auth_Adapter_DbTable(
                $dbAdapter,
                $this->getResource('userDbTable')->info(Zend_Db_Table::NAME),
                'email',
                'password',
                'MD5(CONCAT(salt,?))'
            );
        }

        $this->_setResourceToApplication('authAdapter', $authAdapter);

        return $authAdapter;
    }

    /**
     * Initialize user DB table
     *
     * @return Users_Model_DbTable_Users
     */
    protected function _initUserDbTable()
    {
        $this->getApplication()->bootstrap('db');

        return new Users_Model_DbTable_Users();
    }

    /**
     * Fetch the current user from the database
     *
     * @return Users_Model_DbTable_Users_Row
     */
    protected function _initCurrentUser()
    {
        $this->bootstrap('frontController')
             ->bootstrap('auth');

        $identity = $this->getResource('auth')->getIdentity();

        if (! $identity) {
            $this->_setResourceToApplication('currentuser', null);
            return null;
        }

        $currentUser = $this->getResource('userDbTable')
                            ->findByEmail($identity);

        /** @var $currentUserHelper Bear_Controller_Action_Helper_CurrentUser */
        $currentUserHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('currentUser');
        $currentUserHelper->setCurrentUser($currentUser);

        $this->_setResourceToApplication('currentuser', $currentUser);

        return $currentUser;
    }

    /**
     * Add an application resource to the main application bootstrap, so it is accessible throughout
     * the application as a first-order resource
     *
     * @param string $resourceName
     * @param mixed $resource
     * @return Users_Bootstrap
     */
    protected function _setResourceToApplication($resourceName, $resource)
    {

        $resourceName = strtolower($resourceName);

        $application = $this->getApplication();
        $application->_markRun($resourceName);
        $application->getContainer()->{$resourceName} = $resource;

        return $this;
    }

}