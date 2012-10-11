<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Validate
 */

/** Zend_Validate_Abstract */
require_once "Zend/Validate/Abstract.php";

/**
 * Phone number validator
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Validate
 * @since 2.0.0
 */
class Bear_Validate_PhoneNumber extends Zend_Validate_Abstract
{

    /**#@+
     * Error type
     * @var string
     */
    const INVALID_AREA_CODE    = "invalidAreaCode";
    const INVALID_PHONE_NUMBER = "invalidPhoneNumber";
    const INVALID_PREFIX       = "invalidPrefix";
    /**#@-*/

    /**
     * Validation failure message template definitions
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID_AREA_CODE    => "'%areaCode%' is not a valid area code",
        self::INVALID_PHONE_NUMBER => "'%value%' is not a valid phone number",
        self::INVALID_PREFIX       => "'%prefix%' is not a valid prefix"
    );

    /**
     * Additional variables available for validation failure messages
     * @var array
     */
    protected $_messageVariables = array(
        "areaCode"  => "_areaCode",
        "extension" => "_extension",
        "line"      => "_line",
        "prefix"    => "_prefix"
    );

    /**
     * Parsed area code
     * @var integer
     */
    protected $_areaCode;

    /**
     * Parsed extension
     * @var integer
     */
    protected $_extension;

    /**
     * Parsed line
     * @var integer
     */
    protected $_line;

    /**
     * Parsed prefix
     * @var integer
     */
    protected $_prefix;

    /**
     * Validates a phone number
     *
     * @param string $value
     * @return boolean
     * @throws Zend_Valid_Exception
     */
    public function isValid($value)
    {
        $this->_setValue($value);

        if (!preg_match("#^\((\d{3})\) (\d{3})-(\d{4})( ext. (\d*))?$#", $value, $matches)) {
            $this->_error(self::INVALID_PHONE_NUMBER);
            return false;
        }

        $errors = false;

        $this->_areaCode = $matches[1];
        $this->_prefix   = $matches[2];
        $this->_line     = $matches[3];

        if (isset($matches[5])) {
            $this->_extension = $matches[5];
        }

        if ($this->_areaCode[0] == 0 || $this->_areaCode[0] == 1) {
            $this->_error(self::INVALID_AREA_CODE);
            $errors = true;
        }

        if ($this->_prefix[0] == 0 || $this->_prefix[0] == 1) {
            $this->_error(self::INVALID_PREFIX);
            $errors = true;
        }

        return !$errors;
    }

}