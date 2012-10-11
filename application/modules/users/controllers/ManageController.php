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
 * Users manage controller
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_ManageController extends Zend_Controller_Action
{
    /**
     * Initialize this controller
     * Require that the user must be logged in
     *
     * @return void
     */
    public function init()
    {        
        $this->_helper->assertAuthHasIdentity();
    }

    /**
     * Forward index action request to list action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_forward('list');
    }

    /**
     * Add new user action
     *
     * @return void
     */
    public function addAction()
    {

        // create the empty user row
        $user = $this->_getUsersModel()->createRow();

        $this->_helper->assertIsAllowed($this->_helper->currentUser(), $user, 'add');

        /** @var $addUserHelper Users_Controller_ActionHelper_AddUser */
        $addUserHelper = $this->_helper->addUser;
        
        $addUserHelper->setUser($user);
        if ($this->getRequest()->isPost()) {
            if ($addUserHelper->isValid($this->getRequest()->getPost())) {
                $addUserHelper->execute();
                
                $this->_helper
                     ->flashMessenger
                     ->setNamespace('success')
                     ->addMessage("User successfully created.");

                $this->_helper
                     ->redirector
                     ->gotoRoute(array('action' => 'edit', 'id' => $user->id));

            }
            
        }
        
        $this->view->form = $addUserHelper->getForm();
    }

    /**
     * Edit a user action
     *
     * @return void
     */
    public function editAction()
    {
        $this->_helper->assertHasParameter('id');
        
        // find the user
        $user = $this->_getUsersModel()->find($this->_getParam('id'))->current();
        
        $this->_helper->assertResourceExists($user);

        $this->_helper->assertIsAllowed($this->_helper->currentUser(), $user, 'edit');

        /** @var $editUserHelper Users_Controller_ActionHelper_EditUser */
        $editUserHelper       = $this->_helper->editUser;
        /** @var $changePasswordHelper Users_Controller_ActionHelper_ChangePassword */
        $changePasswordHelper = $this->_helper->changePassword;
        
        $editUserHelper->setUser($user);
        $changePasswordHelper->setUser($user);
        
        if ($this->getRequest()->isPost()) {
            
            switch ($this->_getParam('submit')) {
                case 'Save User':
                    $this->_editUser();
                    break;
                case 'Change Password':
                    $this->_changePassword();
                    break;
            }
            
        }
        
        $this->view->editForm           = $editUserHelper->getForm();
        $this->view->changePasswordForm = $changePasswordHelper->getForm();
    }
    
    /**
     * Complete the edit user
     *
     * @return void
     */
    protected function _editUser()
    {
        /** @var $editUserHelper Users_Controller_ActionHelper_EditUser */
        $editUserHelper = $this->_helper->editUser;
        
        if ($editUserHelper->isValid($this->getRequest()->getPost())) {
            $editUserHelper->execute();
            
            $this->_helper
                 ->flashMessenger
                 ->setNamespace('success')
                 ->addMessage("User information successfully updated");

            $this->_helper
                 ->redirector
                 ->gotoRoute();

        }
    }
    
    /**
     * Complete the edit user
     *
     * @return void
     */
    protected function _changePassword()
    {
        /** @var $changePasswordHelper Users_Controller_ActionHelper_ChangePassword */
        $changePasswordHelper = $this->_helper->changePassword;
        
        if ($changePasswordHelper->isValid($this->getRequest()->getPost())) {
            $changePasswordHelper->execute();
            
            $this->_helper
                 ->flashMessenger
                 ->setNamespace('success')
                 ->addMessage("User password successfully updated");

            $this->_helper
                 ->redirector
                 ->gotoRoute();

        }
    }

    /**
     * Delete a user action
     *
     * @return void
     */
    public function deleteAction()
    {
        $this->_helper->assertHasParameter('id');

        // find the user
        $user = $this->_getUsersModel()->find($this->_getParam('id'))->current();

        $this->_helper->assertResourceExists($user);

        $this->_helper->assertIsAllowed($this->_helper->currentUser(), $user, 'delete');

        /** @var $deleteUserHelper Users_Controller_ActionHelper_DeleteUser */
        $deleteUserHelper = $this->_helper->deleteUser;
        
        $deleteUserHelper->setUser($user);
        
        $deleteUserHelper->execute();
        
        $this->_helper
             ->flashMessenger
             ->setNamespace('success')
             ->addMessage("User successfully deleted");

        $this->_helper
             ->redirector
             ->gotoRoute(array('action' => 'list'));
        
    }

    /**
     * Paginated list of users action
     *
     * @return void
     */
    public function listAction()
    {
        $this->_helper->assertIsAllowed($this->_helper->currentUser(), 'user', 'view');
        
        $userSelect = $this->_getUsersModel()
                           ->select(true)
                           ->order(array('lastName ASC', 'firstName ASC'));
                           
        $paginator = Zend_Paginator::factory($userSelect);
        
        $paginator->setItemCountPerPage(12);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        
        $this->view->paginator = $paginator;
    }

    /**
     * Get the Users Model
     *
     * @return Users_Model_DbTable_Users
     */
    protected function _getUsersModel()
    {
        return new Users_Model_DbTable_Users();
    }
}
