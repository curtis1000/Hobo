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
 * Edit user action helper
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Controller_ActionHelper_EditUser 
    extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * Edit user form
     *
     * @var Users_Form_EditUser
     */
    protected $_form;

    /**
     * User row to edit
     *
     * @var Users_Model_DbTable_Users_Row
     */
    protected $_user;

    /**
     * Save the new user
     * 
     * @return Users_Controller_ActionHelper_EditUser
     */
    public function execute()
    {
        $this->getUser()->email     = $this->getForm()->getValue("emailAddress");
        $this->getUser()->firstName = $this->getForm()->getValue("firstName");
        $this->getUser()->lastName  = $this->getForm()->getValue("lastName");
        $this->getUser()->role      = $this->getForm()->getValue("role");
        $this->getUser()->status    = $this->getForm()->getValue("status");
        
        $this->getUser()->save();

        return $this;
    }

    /**
     * Get the form
     *
     * @return Users_Form_AddUser
     */
    public function getForm()
    {
        if (!$this->_form) {
            
            $this->_form = new Users_Form_EditUser(
                array(
                    "user" => $this->getUser(),
                )
            );

            $this->_form->populate(
                array(
                    "firstName"    => $this->getUser()->firstName,
                    "lastName"     => $this->getUser()->lastName,
                    "emailAddress" => $this->getUser()->email,
                    "role"         => $this->getUser()->role,
                    "status"       => $this->getUser()->status,
                )
            );
        }

        return $this->_form;
    }

    /**
     * Get the user record
     *
     * @return Users_Model_DbTable_Users_Row
     */
    public function getUser()
    {
        if (!$this->_user) {
            throw new Zend_Controller_Action_Exception("No user set", 500);
        }

        return $this->_user;
    }

    /**
     * Check if the data is valid
     *
     * @param array $data Form POST data
     * @return boolean
     */
    public function isValid(array $data)
    {
        return $this->getForm()->isValid($data);
    }

    /**
     * Set the user record being edited
     *
     * @param Users_Model_DbTable_Users_Row $user User being edited
     * @return Users_Controller_ActionHelper_EditUser
     */
    public function setUser(Users_Model_DbTable_Users_Row $user)
    {
        $this->_user = $user;
        return $this;
    }
}