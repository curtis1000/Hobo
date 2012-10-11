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
 * Forgot password action helper
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Controller_ActionHelper_ForgotPassword
    extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * Forgot password form
     * 
     * @var Users_Form_ForgotPassword
     */
    protected $_form;

    /**
     * User that has forgotten their password
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
     * View
     *
     * @var Zend_View_Interface
     */
    protected $_view;

    /**
     * Send the forgot password email
     *
     * @return Users_Controller_ActionHelper_ForgotPassword
     */
    public function execute()
    {
        $this->_user = $this->getUserTable()
                            ->findByEmail($this->getForm()->getValue("emailAddress"));

        // create a expirably forgot password code
        $this->_user->generateForgotPassword()->save();

        return $this->_sendForgotPasswordEmail();
    }

    /**
     * Get the forgot password form
     *
     * @return Users_Form_ForgotPassword
     */
    public function getForm()
    {
        if (!$this->_form) {
            $this->_form = new Users_Form_ForgotPassword();
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
        return $this->getForm()->isValid($data);
    }
    
    /**
     * Set user table
     *
     * @param Users_Model_DbTable_Users $userTable
     * @return Users_Controller_ActionHelper_ForgotPassword
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
            throw new Zend_Controller_Action_Exception('User table not set', 500);
        }
        
        return $this->_userTable;
    }

    /**
     * Set view
     *
     * @param Zend_View_Interface $view
     * @return Users_Controller_ActionHelper_ForgotPassword
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
     * Send the forgot password email
     *
     * @return Users_Controller_ActionHelper_ForgotPassword
     */
    protected function _sendForgotPasswordEmail()
    {
        $mail = new Zend_Mail();
        
        $view = clone $this->getView();

        $view->user = $this->_user;

        $mail->addTo($this->_user->email, $this->_user->firstName . ' ' . $this->_user->lastName)
             ->setSubject("Reset password")
             ->setBodyText($view->render("account/_forgotPassword/_email-text.phtml"))
             ->setBodyHtml($view->render("account/_forgotPassword/_email-html.phtml"))
             ->send();

        return $this;
    }

}