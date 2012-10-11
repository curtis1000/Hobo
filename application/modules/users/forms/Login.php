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
 * Login form
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Form_Login extends Bear_Form
{

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
     * Base URL
     * @var string
     */
    protected $_baseUrl;

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
     * @return Zend_Auth_Adapter_DbTable
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
     * Get the base URL
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->_baseUrl;
    }

    /**
     * Initialize the form
     * 
     * @return void
     */
    public function init()
    {
        $this->addElement(
            $this->createElement("hidden", "return")
        );

        $this->addElement(
            $this->createElement("text", "emailAddress")
                 ->setLabel("Email Address")
                 ->setRequired(true)
                 ->addValidator("NotEmpty", true, array("messages" => "Cannot be empty"))
        );

        $this->addElement(
            $this->createElement("password", "password")
                 ->setLabel("Password")
                 ->setRequired(true)
                 ->addValidator("NotEmpty", true, array("messages" => "Cannot be empty"))
        );

        $this->addElement(
            $this->createElement("submit", "submit")
                 ->setIgnore(true)
        );
        
    }

    /**
     * Validate the form
     *
     * @todo Refactor to pull the authentication logic out of this form and into the login action helper
     * 
     * @param array $data Form POST data
     * @return boolean
     */
    public function isValid($data)
    {
        if (!parent::isValid($data)) {
            $this->getElement('password')->setValue('');
            return false;
        }

        $adapter = $this->getAuthAdapter()
                        ->setIdentity($this->getValue("emailAddress"))
                        ->setCredential($this->getValue("password"));

        $result = $this->getAuth()
                       ->authenticate($adapter);
                                              
        if ($result->isValid()) {
            return true;
        }
        
        switch ($result->getCode()) {
            case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
                $this->getElement("password")
                     ->addErrors($result->getMessages());
                break;

            default:
                $this->getElement("emailAddress")
                     ->addErrors($result->getMessages());
                break;
        }
        
        $this->markAsError();
                
        $this->getElement('password')->setValue('');
        
        return false;
    }

    /**
     * Set the auth
     *
     * @param Zend_Auth $auth Auth to use for storing authenticated user
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
     * @param Zend_Auth_Adapter_DbTable $authAdapter Adapter for authenticating user
     * @return Users_Controller_ActionHelper_Login
     */
    public function setAuthAdapter(Zend_Auth_Adapter_DbTable $authAdapter)
    {
        $this->_authAdapter = $authAdapter;

        return $this;
    }

    /**
     * Set the base URL
     *
     * @param string $baseUrl Form Base URL
     * @return Users_Form_Login
     */
    public function setBaseUrl($baseUrl)
    {
        $this->_baseUrl = $baseUrl;

        return $this;
    }

}