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
 * Delete user action helper
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Controller_ActionHelper_DeleteUser
    extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * User row to delete
     *
     * @var Users_Model_DbTable_Users_Row
     */
    protected $_user;

    /**
     * Save the new user
     *
     * @return Users_Controller_ActionHelper_DeleteUser
     */
    public function execute()
    {
        $this->getUser()->delete();

        return $this;
    }

    /**
     * Get the user record
     *
     * @return Users_Model_DbTable_Users_Row
     */
    public function getUser()
    {
        if (!$this->_user) {
            throw new Zend_Controller_Action_Exception(
                "No user set",
                500
            );
        }

        return $this->_user;
    }

    /**
     * Set the Doctrine base user model
     *
     * @param Users_Model_DbTable_Users_Row $user
     * @return Users_Controller_ActionHelper_EditUser
     */
    public function setUser(Users_Model_DbTable_Users_Row $user)
    {
        $this->_user = $user;

        return $this;
    }

}