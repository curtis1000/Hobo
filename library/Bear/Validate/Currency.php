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
 * Currency validator
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Validate
 * @since 2.0.0
 */
class Bear_Validate_Currency extends Zend_Validate_Abstract
{

    /**#@+
     * Error constants
     */
    const INVALID_CURRENCY = "invalidCurrency";
    /**#@-*/

    /**
     * Error message templates
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID_CURRENCY => "'%value%' is not a valid currency"
    );

    /**
     * Currency
     * @var Zend_Currency
     */
    protected $_currency;

    /**
     * Constructor
     *
     * @param Zend_Currency $currency
     */
    public function __construct(Zend_Currency $currency)
    {
        $this->_currency = $currency;
    }

    /**
     * Validate the value is a currency
     *
     * @param string $value
     * @return boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);

        try {
            $this->_currency->toCurrency(
                preg_replace("/[^-0-9\.]/", "", $value)
            );
            return true;
        } catch (Zend_Currency_Exception $e) {
            $this->_error(self::INVALID_CURRENCY);
            return false;
        }
    }

}
