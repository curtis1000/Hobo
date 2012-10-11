<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Validate
 */

/** Zend_Validate_Abstract */
require_once "Zend/Validate/Abstract.php";

/** Zend_Validate_EmailAddress */
require_once "Zend/Validate/EmailAddress.php";

/**
 * Simple email address validator
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Validate
 * @since 2.0.0
 */
class Bear_Validate_SimpleEmailAddress extends Zend_Validate_Abstract
{

    /**
     * Invalid email address error key
     * @var string
     */
    const INVALID = "invalid";

    /**
     * Arguements for the validator
     * @var array
     */
    protected $_arguments = array();

    /**
     * Message templates
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID => "'%value%' is not a valid email address"
    );

    /**
     * Namespaces for the validator
     * @var array
     */
    protected $_namespaces = array();

    /**
     * Validate the value
     *
     * @param string $value
     * @return boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);

        if (!Zend_Validate::is($value, "EmailAddress", $this->_arguments, $this->_namespaces)) {
            $this->_error(self::INVALID);
            return false;
        }

        return true;
    }

    /**
     * Set the arguments
     *
     * @param array $arguments
     * @return Bear_Validate_SimpleEmailAddress
     */
    public function setArguments(array $arguments)
    {
        $this->_arguments = $arguments;
        return $this;
    }

    /**
     * Set the namespaces
     *
     * @param array $namespaces
     * @return Bear_Validate_SimpleEmailAddress
     */
    public function setNamespaces(array $namespaces)
    {
        $this->_namespaces = $namespaces;
        return $this;
    }

    /**
     * get the namespaces
     *
     * @return array
     */
    public function getNamespaces()
    {
        return $this->_namespaces;
    }
    
    /**
     * get the namespaces
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->_arguments;
    }
    
}