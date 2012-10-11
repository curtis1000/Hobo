<?php
/**
 * Bear
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Controller
 * @since 1.1.0
 */

/** Zend_Controller_Action_Helper_Abstract */
require_once "Zend/Controller/Action/Helper/Abstract.php";

/**
 * Assert that a parameter is present
 *
 * @category Bear
 * @package Bear_Controller
 */
class Bear_Controller_Action_Helper_AssertHasParameter extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * Allow empty flag
     * @var boolean
     */
    protected $_allowEmpty = true;

    /**
     * Assert that a parameter is present
     *
     * @param string $parameter
     * @see assertHasParameter()
     * @throws Bear_Controller_Action_Exception_ParameterMissing
     */
    public function direct($parameter)
    {
        return $this->assertHasParameter($parameter);
    }

    /**
     * Assert that a parameter is present
     *
     * @param string $parameter
     * @throws Bear_Controller_Action_Exception_ParameterMissing
     */
    public function assertHasParameter($parameter)
    {
        if ($this->getRequest()->getParam($parameter, false) === false) {
            /** Bear_Controller_Action_Exception_ParameterMissing */
            require_once "Bear/Controller/Action/Exception/ParameterMissing.php";

            throw new Bear_Controller_Action_Exception_ParameterMissing(
                $parameter
            );
        }

        if (!$this->getAllowEmpty() && !$this->getRequest()->getParam($parameter)) {
            /** Bear_Controller_Action_Exception_ParameterMissing */
            require_once "Bear/Controller/Action/Exception/ParameterMissing.php";

            throw new Bear_Controller_Action_Exception_ParameterMissing(
                $parameter
            );
        }
    }

    /**
     * Get the allow empty flag
     *
     * @return boolean
     */
    public function getAllowEmpty()
    {
        return $this->_allowEmpty;
    }

    /**
     * Set the allow empty flag
     *
     * @param boolean $allowEmpty
     * @return Bear_Controller_Action_Helper_AssertHasParameter
     */
    public function setAllowEmpty($allowEmpty)
    {
        $this->_allowEmpty = $allowEmpty;
        return $this;
    }

}
