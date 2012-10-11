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
 * Users DB table row
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Model_DbTable_Users_Row
    extends Zend_Db_Table_Row
    implements Zend_Acl_Role_Interface, Zend_Acl_Resource_Interface, Bear_Auth_ValidatableIdentity
{

    /**
     * Forgot password timespan
     * @var integer
     */
    const FORGOT_PASSWORD_TIMESPAN = 1800;

    /**
     * Set the user's password by using random salting
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        if (Bear_Crypt_Blowfish::isSupported()) {
            // use Blowfish crypt
            $this->salt     = Bear_Crypt_Blowfish::generateSalt();
            $this->password = Bear_Crypt_Blowfish::hash($password, $this->salt);
        } else {
            // fall back to MD5
            $this->salt     = Bear_Crypt_Blowfish::generateSalt();
            $this->password = md5($this->salt . $password);
        }
    }
    
    /**
     * Checks if user is allowed to login based on their status
     *
     * @return boolean $canLogin
     */
    public function canLogin()
    {
        return $this->status == Users_Model_DbTable_Users::STATUS_ENABLED;
    }

    /**
     * Get a clone of this object that is suitable for storing in a session
     *
     * @return Users_Model_DbTable_Users_Row
     */
    public function getIdentity()
    {
        $className = get_class($this);
        $identity = new $className(array('data' => $this->_data));

        return $identity;
    }

    /**
     * Post-login functionality
     *
     * @return void
     */
    public function postLogin()
    {
        $this->lastLogon = date('Y-m-d H:i:s');
        $this->save();
    }

    /**
     * Returns the string identifier of the Role
     *
     * @return string
     */
    public function getRoleId()
    {
        return $this->role;
    }
    
    /**
     * Returns the string identifier of the Resource
     *
     * @return string
     */
    public function getResourceId()
    {
        return 'user';
    }
    
    
    /**
     * Generate a forgot password
     *
     * @param Zend_Date $timestamp
     * @return Users_Model_DbTable_Users_Row
     */
    public function generateForgotPassword($timestamp = null)
    {
        $code = "";

        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_";
        for ($i = 0; $i < 32; ++$i) {
            $code .= $chars[mt_rand(0, 63)];
        }

        $this->forgotPasswordCode      = $code;
        $this->forgotPasswordTimestamp = $timestamp instanceof Zend_Date ? $timestamp : date('Y-m-d H:i:s');

        return $this;
    }

    /**
     * Get the forgot password timestamp
     *
     * @param boolean $returnZendDateObject
     * @return string|Zend_Date
     */
    public function getForgotPasswordTimestamp($returnZendDateObject = false)
    {
        if ($returnZendDateObject) {
            return new Zend_Date(
                $this->forgotPasswordTimestamp,
                'Y-M-d H:mm:s'
            );
        }

        return $this->forgotPasswordTimestamp;
    }

    /**
     * Check if the forgot password code has expired
     *
     * @return boolean
     */
    public function isForgotPasswordExpired()
    {
        $nowDate = new Zend_Date();
        return $nowDate->subSecond(self::FORGOT_PASSWORD_TIMESPAN)
                       ->compare($this->getForgotPasswordTimestamp(true)) == 1;
    }

    /**
     * Do a forgot password reset
     *
     * @param string $password
     * @return Users_Model_DbTable_Users_Row
     * @throws Exception if forgot password code has expired
     */
    public function forgotPasswordReset($password)
    {
        if ($this->isForgotPasswordExpired()) {
            throw new Exception("The forgotten password code has expired");
        }

        $this->forgotPasswordCode      = null;
        $this->forgotPasswordTimestamp = null;
        $this->setPassword($password);

        $this->save();

        return $this;
    }

    /**
     * Set the forgot password timestamp
     *
     * @param string|Zend_Date $forgotPasswordTimestamp
     * @return Users_Model_DbTable_Users_Row
     */
    public function setForgotPasswordTimestamp($forgotPasswordTimestamp)
    {
        if ($forgotPasswordTimestamp instanceof Zend_Date) {
            $this->forgotPasswordTimestamp = $forgotPasswordTimestamp->toString("yyyy-MM-dd HH:mm:ss");
        } else {
            $this->forgotPasswordTimestamp = $forgotPasswordTimestamp;
        }

        return $this;
    }
    
    /**
     * Pre-update: set the updated timestamp
     *
     * @return void
     */
    protected function _update()
    {
        $this->updated = date('Y-m-d H:i:s');
        
        parent::_update();
    }
    
    /**
     * Pre-insert: set the created and updated timestamp
     *
     * @return void
     */
    protected function _insert()
    {
        $this->updated = $this->created = date('Y-m-d H:i:s');
        
        parent::_insert();
    }

    /**
     * Validate if the identity is allowed to authenticate. This method is called after
     * the identity's credentials have been verified to be valid.
     *
     * @return Zend_Auth_Result
     */
    public function validateIdentity()
    {
        // check if the user can login (has an active account)
        if (! $this->canLogin()) {
            return new Zend_Auth_Result(
                Zend_Auth_Result::FAILURE,
                $this->email,
                array("Your account is currently {$this->status}. You may not login at this time.")
            );
        }

        return new Zend_Auth_Result(
            Zend_Auth_Result::SUCCESS,
            $this->email,
            array('Authentication successful.')
        );
    }
}
