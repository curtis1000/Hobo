<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Crypt
 */

/**
 * Static utilities for creating salts and hashing using the Blowfish crypt algorithm
 *
 * @category Bear
 * @package Bear_Crypt
 * @author Konr Ness <konr.ness@nerdery.com>
 */
class Bear_Crypt_Blowfish
{

    const PREAMBLE = '$2a$';

    const MAX_SALT_LENGTH = 22;

    /**
     * The base-2 logarithm of the iteration count for the underlying
     * Blowfish-based hashing algorithmeter
     *
     * @var string
     */
    protected static $_cost = '07';

    /**
     * Up to 22 character salt
     *
     * @var string
     */
    protected static $_salt;

    /**
     * Execute the Blowfish hash algorithm
     *
     * @param string $data The string to be hashed
     * @param string $salt OPTIONAL
     * @param string $cost OPTIONAL
     * @return string
     * @throws Zend_Crypt_Exception
     */
    public static function hash($data, $salt = null, $cost = null)
    {
        if (! self::isSupported()) {
            throw new Zend_Crypt_Exception('Blowfish is not supported on this system');
        }

        if ($salt) {
            self::setSalt($salt);
        }

        if ($cost) {
            self::setCost($cost);
        }

        return crypt($data, self::PREAMBLE . self::getCost() . '$' . self::getSalt());
    }

    /**
     * Tests if the system supports Blowfish hashing with crypt()
     *
     * @see http://us2.php.net/manual/en/function.crypt.php
     * @return boolean
     */
    public static function isSupported()
    {
        return defined('CRYPT_BLOWFISH') && (CRYPT_BLOWFISH == 1);
    }

    /**
     * Blowish cost must be in range 04-31, values outside this range will
     * cause crypt() to fail.
     *
     * @param int $cost
     * @return void
     */
    public static function setCost($cost)
    {
        $cost = (int) $cost;

        if ($cost < 4 || $cost > 31) {
            throw new Zend_Crypt_Exception('Cost must be in the range 04-31');
        }

        $cost = str_pad($cost, 2, '0', STR_PAD_LEFT);

        self::$_cost = $cost;
    }

    /**
     * @return string
     */
    public static function getCost()
    {
        return self::$_cost;
    }

    /**
     * Generate a salt appropriate for Blowfish hashing
     *
     * @static
     * @param int $length DEFAULT=22 which is the maximum length supported for Blowfish hashes
     * @return string
     */
    public static function generateSalt($length = self::MAX_SALT_LENGTH)
    {
        $random = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvxyz';

        $salt = '';

        for ($i = 0; $i < $length; ++$i) {
            $salt .= $random[rand(0, strlen($random) - 1)];
        }

        return $salt;
    }

    /**
     * Strips the salt to the maximum supported length (22 characters) and
     * verifies that only supported characters are included: [./0-9A-Za-z]
     *
     * @param string $salt
     * @return void
     * @throws Zend_Crypt_Exception if any invalid salt characters are provided
     */
    public static function setSalt($salt)
    {
        // check if the salt has a preamble on it, which indicates the salt is
        // a complete hash. If so, extract the cost and salt portion.
        if (strpos($salt, self::PREAMBLE) === 0) {
            self::setCost(substr($salt, 4,2));
            $salt = substr($salt, 7, 22);
        }

        $salt = substr($salt, 0, self::MAX_SALT_LENGTH);

        if (! preg_match("/^[\.\/0-9A-Za-z]*$/", $salt)) {
            throw new Zend_Crypt_Exception('Invalid salt character');
        }

        self::$_salt = $salt;
    }

    /**
     * @return string
     */
    public static function getSalt()
    {
        return self::$_salt;
    }

    /**
     * Reset static properties (salt, cost) to defaults
     *
     * @return void
     */
    public static function reset()
    {
        self::$_cost = '07';
        self::$_salt = null;
    }
}