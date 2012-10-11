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
 * @author Colin Fein <colin.fein@sierra-bravo.com>
 * @author Konr Ness <konr.ness@sierra-bravo.com>
 * @category Bear
 * @package Bear_Validate
 */
class Bear_Validate_RequiredIf extends Zend_Validate_NotEmpty
{

    /**
     * Requirement error string
     * @var string
     */
    const REQUIRED_IF = 'requiredIf';

    /**
     * Field will be required if this related field is not empty
     *
     * @var string
     */
    protected $_field;

    /**
     * Optional, field will be required if above related field is set to this value.
     *
     * If comparison is an array then the field will be required if the related field is set to one of the array's values
     *
     * @var string|array|null
     */
    protected $_comparison;

    /**
     * @var string Error message
     */
    protected $_errorMessage;

    /**
     * Message templates
     * @var array
     */
    protected $_messageTemplates = array(
        self::REQUIRED_IF => 'Field is required'
    );

    /**
     * Constructor
     *
     * @param string $field
     * @param string|array $comparison OPTIONAL, field will be required if related field is set to this value.
     */
    public function __construct($field, $comparison = null)
    {
        $this->setField($field);
        $this->setComparison($comparison);
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
        //if comparison field was not submitted, field is not required
        if (!isset($context[$this->_field])) {
            return true;
        }

        // check if field value is not empty and if not check comparison
        $required = parent::isValid($context[$this->_field])
                    && $this->_testComparison($context[$this->_field], $this->_comparison);

        $this->_setValue($value);

        if ( $required && !parent::isValid($value)) {
            $this->_error(self::REQUIRED_IF);
            return false;
        }

        return true;
    }

    protected function _testComparison($value, $comparison)
    {
        if (null == $comparison) {
            // no comparison value provided so field is always required
            return true;
        }

        if (is_array($comparison)) {
            // comparison value is an array so field is required if at
            // least one value is in comparison
            return in_array($value, $comparison);
        }

        return $value == $comparison;
    }

    /**
     * @param string $field
     */
    public function setField($field)
    {
        $this->_field = $field;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->_field;
    }

    /**
     * @param array|null|string $comparison
     */
    public function setComparison($comparison)
    {
        $this->_comparison = $comparison;
    }

    /**
     * @return array|null|string
     */
    public function getComparison()
    {
        return $this->_comparison;
    }
}