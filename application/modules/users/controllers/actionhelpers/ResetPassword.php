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
 * Reset password action helper
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Controller_ActionHelper_ResetPassword extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * Reset password form
     * 
     * @var Users_Form_ChangePassword
     */
    protected $_form;

    /**
     * User
     * 
     * @var Users_Model_DbTable_Users_Row
     */
    protected $_user;
    
    /**
     * User Table
     *
     * @var Users_Model_DbTable_Users
     */
    protected $_userTable;
    
    /**
     * Reset code
     *
     * @var string
     */
    protected $_code;
    
    /**
     * View
     *
     * @var Zend_View_Interface
     */
    protected $_view;

    /**
     * Reset the password
     *
     * @return Users_Controller_ActionHelper_ResetPassword
     */
    public function execute()
    {
        $user = $this->_loadUser();
        
        if (! $user) {
            throw new Exception('invalid user');
        }
        
        $user->forgotPasswordReset($this->getForm()->getValue('password'));
             
    }

    /**
     * Checks if the set code is a valid code
     *
     * @return boolean
     */
    public function isValidCode()
    {
        $user = $this->_loadUser();
        
        return $user && !$this->_loadUser()->isForgotPasswordExpired();
    }
    
    /**
     * Fetch user based on forgot password code
     *
     * @return Users_Model_DbTable_Users_Row $user
     */
    protected function _loadUser()
    {
        if (! $this->_user) {
            $this->_user = $this->getUserTable()->findByForgotPasswordCode($this->getCode());
        }
        
        return $this->_user;
    }
    
    /**
     * Get the change password form
     *
     * @return Users_Form_ChangePassword
     */
    public function getForm()
    {
        if (!$this->_form) {
            $this->_form = new Users_Form_ChangePassword();
        }
        return $this->_form;
    }

    /**
     * Check if the data is valid
     *
     * @param array $data
     * @return boolean
     */
    public function isValid(array $data)
    {
        return $this->getForm()
                    ->isValid($data);
    }
    
    /**
     * Set user table
     *
     * @param Users_Model_DbTable_Users $userTable
     * @return Users_Controller_ActionHelper_ResetPassword
     */
    public function setUserTable(Users_Model_DbTable_Users $userTable)
    {
        $this->_userTable = $userTable;
    }
    
    /**
     * Get user table
     *
     * @return Users_Model_DbTable_Users $userTable
     */
    public function getUserTable()
    {
        if (! $this->_userTable) {
            throw new Exception('User table not set');
        }
        
        return $this->_userTable;
    }

    /**
     * Set view
     *
     * @param Zend_View_Interface $view
     * @return Users_Controller_ActionHelper_ResetPassword
     */
    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }
    
    /**
     * Get view
     *
     * @return Zend_View_Interface $view
     */
    public function getView()
    {
        if (! $this->_view) {
            throw new Exception('View not set');
        }
        
        return $this->_view;
    }

    /**
     * Set reset code
     *
     * @param string $code
     * @return Users_Controller_ActionHelper_ResetPassword
     */
    public function setCode($code)
    {
        $this->_code = $code;
    }
    
    /**
     * Get reset code
     *
     * @return string $code
     */
    public function getCode()
    {
        if (! $this->_code) {
            throw new Exception('Code not set');
        }
        
        return $this->_code;
    }

}