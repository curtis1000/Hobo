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
 * Compare fields validator
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Validate
 * @since 2.0.0
 */
class Bear_Validate_CompareFields extends Zend_Validate_Abstract
{

    /**
     * Not match error key
     * @var string
     */
    const NOT_MATCH = 'notMatch';

    /**
     * Field to compare against
     * @var string
     */
    protected $_field;

    /**
     * Message templates
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_MATCH => 'Confirmation field does not match'
    );

    /**
     * Constructor
     *
     * @param string $field
     */
    public function __construct($field)
    {
        $this->_field = $field;
    }

    /**
     * Validate the value
     *
     * @param string $value
     * @param array $context
     * @return boolean
     */
    public function isValid($value, $context = null)
    {
        $value = (string) $value;
        $this->_setValue($value);

        if (!$context || !isset($context[$this->_field]) || $value != $context[$this->_field]) {
            $this->_error(self::NOT_MATCH);
            return false;
        }

        return true;
    }
}