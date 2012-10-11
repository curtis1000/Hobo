<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Pick
 */

/** Bear_Pick_Exception */
require_once 'Bear/Pick/Exception.php';

/**
 * Pick handshake exception
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Pick
 * @since 2.0.0
 */
class Bear_Pick_Exception_Handshake extends Bear_Pick_Exception
{

    /**
     * Original exception
     * @var Bear_Pick_Exception
     */
    private $_exception;

    /**
     * Consturctor
     *
     * @param Bear_Pick_Exception $exception
     */
    public function __construct(Bear_Pick_Exception $exception)
    {
        $this->_exception = $exception;
    }

    /**
     * Get the original exception
     */
    public function getOriginalException()
    {
        return $this->_exception;
    }

}
