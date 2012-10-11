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
 * Users account controller
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_AccountController extends Zend_Controller_Action
{
        
    /**
     * Login Action
     *
     * @return void
     */
    public function loginAction()
    {
        /** @var $loginHelper Users_Controller_ActionHelper_Login */
        $loginHelper = $this->_helper->login;
        
        $loginHelper->setSessionNamespace(new Zend_Session_Namespace("login"));
        
        if ($this->getRequest()->isPost()) {
            if ($loginHelper->isValid($this->getRequest()->getPost())) {
                $loginHelper->execute();
            }
        }
                
        $this->view->form = $loginHelper->getForm();
    }

    /**
     * Logout Action
     *
     * @return void
     */
    public function logoutAction()
    {
        
        $bootstrap = $this->getInvokeArg("bootstrap")
                          ->bootstrap("auth");
                          
        $bootstrap->getResource("auth")
                  ->clearIdentity();

        $this->_helper->redirector->gotoRoute(
            array(),
            "default",
            true
        );
    }

    /**
     * Forgot Password Action
     *
     * @return void
     */
    public function forgotPasswordAction()
    {
        /** @var $helper Users_Controller_ActionHelper_ForgotPassword */
        $helper = $this->_helper->forgotPassword;
                       
        $helper->setUserTable(new Users_Model_DbTable_Users());
        $helper->setView($this->view);

        if (
            $this->getRequest()->isPost() && 
            $helper->isValid($this->getRequest()->getPost())
        ) {
            $helper->execute();

            $this->_helper
                 ->viewRenderer
                 ->setRender("forgot-password-thank-you");
        }

        $this->view->form = $helper->getForm();

    }
    
    /**
     * Reset Password Action
     *
     * @return void
     */
    public function resetPasswordAction()
    {
        $this->_helper->assertHasParameter('code');

        /** @var $helper Users_Controller_ActionHelper_ResetPassword */
        $helper = $this->_helper->resetPassword;
        
        $helper->setUserTable(new Users_Model_DbTable_Users());
        $helper->setView($this->view);
        $helper->setCode($this->_getParam('code'));
        
        if (! $helper->isValidCode()) {
            $this->_helper
                 ->flashMessenger
                 ->setNamespace('error')
                 ->addMessage(
                     "The forgot password code has expired. Please try again."
                 );
            
            // redirect to login page
            $this->_helper->redirector->gotoRoute(
                array(
                    'module'     => 'users',
                    'controller' => 'account',
                    'action'     => 'forgot-password',
                ),
                "default",
                true
            );
        }
        
        if (
            $this->getRequest()->isPost() && 
            $helper->isValid($this->getRequest()->getPost())
        ) {
            $helper->execute();
            
            $this->_helper
                 ->flashMessenger
                 ->setNamespace('success')
                 ->addMessage(
                     "Password successfully changed. You may now log in."
                 );
            
            // redirect to login page
            $this->_helper->redirector->gotoRoute(
                array(
                    'module'     => 'users',
                    'controller' => 'account',
                    'action'     => 'login',
                ),
                "default",
                true
            );
        }
        
        $this->view->form = $helper->getForm();

    }

}








