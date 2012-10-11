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
 * Login action helper
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Controller_ActionHelper_Login extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * Form action route parameters
     * 
     * @var array
     */
    protected $_formActionUrlOptions;

    /**
     * Auth
     * @var Zend_Auth
     */
    protected $_auth;

    /**
     * Auth adapter
     * @var Zend_Auth_Adapter_Interface
     */
    protected $_authAdapter;

    /**
     * Login form
     * @var Users_Form_Login
     */
    protected $_form;

    /**
     * Session namespace
     * @var Zend_Session_Namespace
     */
    protected $_session;

    /**
     * Log a user in and redirects to the requesting page
     *
     * @return void
     */
    public function execute()
    {
        $email = (string) $this->getAuth()->getIdentity();
        
        $userModel = new Users_Model_DbTable_Users();
        $user = $userModel->findByEmail($email);

        // record login
        $user->postLogin();

        $return = $this->getForm()->getElement("return")->getValue();
        
        $this->getActionController()->getHelper('redirector')->gotoUrl(
            $return,
            array(
                "prependBase" => empty($return)
            )
        );
        
    }

    /**
     * Get the auth
     *
     * @return Zend_Auth
     * @throws Zend_Controller_Action_Exception
     */
    public function getAuth()
    {
        if (!$this->_auth) {
            throw new Zend_Controller_Action_Exception(
                "No auth set"
            );
        }

        return $this->_auth;
    }

    /**
     * Get the auth adapter
     *
     * @return Zend_Auth_Adapter_Interface
     * @throws Zend_Controller_Action_Exception
     */
    public function getAuthAdapter()
    {
        if (!$this->_authAdapter) {
            throw new Zend_Controller_Action_Exception(
                "No auth adapter set"
            );
        }

        return $this->_authAdapter;
    }

    /**
     * Get the login form
     *
     * @return Users_Form_Login
     */
    public function getForm()
    {
        if (!$this->_form) {
            $this->_form = new Users_Form_Login(array(
                "action"      => $this->getFormAction(),
                "auth"        => $this->getAuth(),
                "authAdapter" => $this->getAuthAdapter(),
                "baseUrl"     => $this->getRequest()->getBaseUrl()
            ));

            $session = $this->getSession();

            if (isset($session->postLoginUrl)) {
                $this->_form
                     ->getElement("return")
                     ->setValue($this->getSession()->postLoginUrl);
                     
                unset($session->postLoginUrl);     
            }
        }

        return $this->_form;
    }

    /**
     * Get the session namespace
     *
     * @return Zend_Session_Namespace
     */
    public function getSession()
    {
        if (!$this->_session) {
            throw new Zend_Controller_Action_Exception(
                "No session namespace set"
            );
        }

        return $this->_session;
    }

    /**
     * Validate the data
     *
     * @param array $data
     * @return boolean
     */
    public function isValid($data)
    {
        if ($this->getForm()->isValid($data)) {
            return true;
        }

        return false;
    }
    
    /**
     * Generate URL to login handler action
     *
     * @return string URL
     */
    public function getFormAction()
    {
        $url = $this->getActionController()->getHelper('url')->url(
            $this->getFormActionUrlOptions(),
            'default',
            true
        );
        
        return $url;
    }

    /**
     * Set the form action URL parameters
     *
     * @param array $options
     * @return Users_Controller_ActionHelper_Login
     */
    public function setFormActionUrlOptions($options)
    {
        $this->_formActionUrlOptions = $options;

        return $this;
    }

    /**
     * Get the form action URL parameters
     *
     * @return array $parameters
     */
    public function getFormActionUrlOptions()
    {
        return $this->_formActionUrlOptions;
    }

    /**
     * Set the auth
     *
     * @param Zend_Auth $auth
     * @return Users_Controller_ActionHelper_Login
     */
    public function setAuth(Zend_Auth $auth)
    {
        $this->_auth = $auth;

        return $this;
    }

    /**
     * Set the Auth adapter
     *
     * @param Zend_Auth_Adapter_Interface
     * @return Users_Controller_ActionHelper_Login
     */
    public function setAuthAdapter(Zend_Auth_Adapter_Interface $authAdapter)
    {
        $this->_authAdapter = $authAdapter;

        return $this;
    }

    /**
     * Set the session namespace
     *
     * @param Zend_Session_Namespace $session
     * @return Users_Controller_ActionHelper_Login
     */
    public function setSessionNamespace(Zend_Session_Namespace $session)
    {
        $this->_session = $session;

        return $this;
    }

}
