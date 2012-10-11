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
 * Assert that a resource exists
 *
 * @category Bear
 * @package Bear_Controller
 */
class Bear_Controller_Action_Helper_AssertResourceExists extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * Assert that a resource exists
     *
     * @param mixed $resource
     * @see assertResourceExists()
     * @throws Zend_Controller_Action_Exception
     */
    public function direct($resource = null)
    {
        return $this->assertResourceExists($resource);
    }

    /**
     * Assert that a resource exists
     *
     * @param mixed $resource
     * @throws Zend_Controller_Action_Exception
     */
    public function assertResourceExists($resource)
    {
        if (!$resource) {
            /** Bear_Controller_Action_Exception_ResourceNotFound */
            require_once "Bear/Controller/Action/Exception/ResourceNotFound.php";

            throw new Bear_Controller_Action_Exception_ResourceNotFound();
        }
    }

}