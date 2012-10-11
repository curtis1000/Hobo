<?php
/**
 * Bear
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Controller
 * @since 1.1.0
 */

/** Zend_Controller_Action_Exception */
require_once "Zend/Controller/Action/Exception.php";

/**
 * Parameter missing exception
 *
 * @category Bear
 * @package Bear_Controller
 */
class Bear_Controller_Action_Exception_ParameterMissing extends Zend_Controller_Action_Exception
{

    /**
     * Missing parameter name
     * @var string
     */
    private $_parameter;

    /**
     * Construct
     *
     * @param string $parameter
     */
    public function __construct($parameter)
    {
        $this->_parameter = $parameter;

        parent::__construct(sprintf(
            "Parameter '%s' not found",
            $this->getParameter()
        ));
    }

    /**
     * Get the missing parameter name
     *
     * @return string
     */
    public function getParameter()
    {
        return $this->_parameter;
    }

}