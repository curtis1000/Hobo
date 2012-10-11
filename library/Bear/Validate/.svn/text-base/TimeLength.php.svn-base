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
 * Time length validator
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Validate
 * @since 2.0.0
 */
class Bear_Validate_TimeLength extends Zend_Validate_Abstract
{

    /**#@+
     * Error type
     * @var string
     */
    const INVALID_HOURS       = "invalidHours";
    const INVALID_MINUTES     = "invalidMinutes";
    const INVALID_SECONDS     = "invalidSeconds";
    const INVALID_TIME_LENGTH = "invalidTimeLength";
    /**#@-*/

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID_HOURS       => "'%hours%' is not a valid hour",
        self::INVALID_MINUTES     => "'%minutes%' is not a valid minute",
        self::INVALID_SECONDS     => "'%seconds%' is not a valid second",
        self::INVALID_TIME_LENGTH => "'%value%' is not a valid time length"
    );

    /**
     * Additional variables available for validation failure messages
     *
     * @var array
     */
    protected $_messageVariables = array(
        "hours"   => "_hours",
        "minutes" => "_minutes",
        "seconds" => "_seconds"
    );

    /**
     * Parsed hours
     * @var integer
     */
    protected $_hours;

    /**
     * Parsed minutes
     * @var integer
     */
    protected $_minutes;

    /**
     * Parsed seconds
     * @var integer
     */
    protected $_seconds;

    /**
     * Validates a time length
     *
     * @param string $value
     * @return boolean
     * @throws Zend_Valid_Exception
     */
    public function isValid($value)
    {
        $this->_setValue($value);

        if (!preg_match("#^(\d*):(\d*):(\d*)$#", $value, $matches)) {
            $this->_error(self::INVALID_TIME_LENGTH);
            return false;
        }

        $errors = false;

        $this->_hours   = $matches[1];
        $this->_minutes = $matches[2];
        $this->_seconds = $matches[3];

        if ($this->_hours < 0 || $this->_hours == '') {
            $this->_error(self::INVALID_HOURS);
            $errors = true;
        }

        if ($this->_minutes > 59) {
            $this->_error(self::INVALID_MINUTES);
            $errors = true;
        }

        if ($this->_seconds > 59) {
            $this->_error(self::INVALID_SECONDS);
            $errors = true;
        }

        return !$errors;
    }

}