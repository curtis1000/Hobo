<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Pick
 */

/**
 * Pick result interface
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Pick
 * @since 2.0.0
 */
interface Bear_Pick_Result_Interface
{

    /**
     * Check if the end of the file has been reached
     *
     * @return boolean
     */
    public function isEndOfFile();

    /**
     * Read the next chunk from the connection
     *
     * @param integer $length
     * @return string
     */
    public function read($length = 8192);

}