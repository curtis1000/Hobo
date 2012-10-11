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
 * Users DB table
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Model_DbTable_Users extends Zend_Db_Table
{

    /**
     * @var string
     */
    const ROLE_ADMIN = 'admin';

    /**
     * @var string
     */
    const ROLE_USER = 'user';
    
    /**
     * @var string
     */
    const STATUS_ENABLED = 'enabled';

    /**
     * @var string
     */
    const STATUS_DISABLED = 'disabled';
    
    /**
     * @var string
     */
    const STATUS_INACTIVE = 'inactive';

    /**
     * @var string
     */
    const STATUS_PENDING = 'pending';

    /**
     * @var array
     */
    public static $roles = array(
        self::ROLE_ADMIN => 'Administrator',
        self::ROLE_USER  => 'User',
    );

    /**
     * @var array
     */
    public static $statuses = array(
        self::STATUS_ENABLED  => 'Active',
        self::STATUS_DISABLED => 'Disabled',
        self::STATUS_PENDING  => 'Pending',
        self::STATUS_INACTIVE => 'Inactive',
    );
    
    /**
     * @var string
     */
    protected $_name = 'users';

    /**
     * @var string
     */
    protected $_rowClass = 'Users_Model_DbTable_Users_Row';
    
    protected $_dependentTables = array();

    /**
     * Find a user by forgot password code
     *
     * @param string $code Forgot password code
     * @return Users_Model_DbTable_Users_Row |null
     */
    public function findByForgotPasswordCode($code)
    {
        return $this->fetchRow(array('forgotPasswordCode  = ?' => $code));
    }
    
    /**
     * Fetch a user by email address
     *
     * @param string $email Email Address
     * @return Users_Model_DbTable_Users_Row
     */
    public function findByEmail($email)
    {
        return $this->fetchRow(array('email = ?' => $email));
    }
    
    /**
     * Checks if a user exists with this email address 
     *
     * @param string $email Email address
     * @return boolean
     */
    public function emailExists($email)
    {
        if ($this->findByEmail($email) !== null) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Fetch all enabled users
     * 
     * @return Zend_Db_Table_Rowset
     */
    public function fetchEnabledUsers()
    {
        return $this->fetchAll(array('status = ?' => self::STATUS_ENABLED));
    }
    
    /**
     * Fetch all users with admin role
     * 
     * @return Zend_Db_Table_Rowset
     */
    public function fetchAdminUsers()
    {
        return $this->fetchAll(array('role = ?' => self::ROLE_ADMIN, 'status = ?' => self::STATUS_ENABLED));
    }

}
