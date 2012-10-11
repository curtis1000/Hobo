<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Pick
 */

/**
 * Buffer-based observer
 *
 * Stores the observed updates in a buffer for later retrieval.
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Pick
 * @since 2.0.0
 */
class Bear_Pick_Observer_Buffer implements SplObserver
{

    /**
     * Debug buffer
     * @var     array
     */
    private $_buffer = array();

    /**
     * Get the buffer
     *
     * @return  array
     */
    public function getBuffer()
    {
        return $this->_buffer;
    }

    /**
     * Update
     *
     * @param   SplSubject  $subject
     */
    public function update(SplSubject $subject)
    {
        $action = $subject->getLastAction();

        $buffer[] = sprintf(
            "%s: %s",
            $action[0],
            $action[1]
        );
    }

}
