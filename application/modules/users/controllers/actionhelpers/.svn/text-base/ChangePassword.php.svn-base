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
 * Change password action helper
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Controller_ActionHelper_ChangePassword
    extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * Change password form
     *
     * @var Users_Form_ChangePassword
     */
    protected $_form;

    /**
     * User row to change the password for
     *
     * @var Users_Model_DbTable_Users_Row
     */
    protected $_user;

    /**
     * Save the new user
     *
     * @return Users_Controller_ActionHelper_ChangePassword
     */
    public function execute()
    {
        $this->getUser()->setPassword($this->getForm()->getValue("password"));
        $this->getUser()->save();

        return $this;
    }

    /**
     * Get the form
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
     * @param array $data
     * @return boolean
     */
    public function isValid(array $data)
    {
        return $this->getForm()->isValid($data);
    }

    /**
     * Set the Doctrine base user model
     *
     * @param Users_Model_DbTable_Users_Row $user
     * @return Users_Controller_ActionHelper_ChangePassword
     */
    public function setUser(Users_Model_DbTable_Users_Row $user)
    {
        $this->_user = $user;
        return $this;
    }

}