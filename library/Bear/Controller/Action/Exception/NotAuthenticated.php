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
 * Not authenticated exception
 *
 * @category Bear
 * @package Bear_Controller
 */
class Bear_Controller_Action_Exception_NotAuthenticated extends Zend_Controller_Action_Exception
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct("No identity found");
    }

}