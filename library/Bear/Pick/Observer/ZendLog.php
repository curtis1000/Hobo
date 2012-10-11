<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Pick
 */

/**
 * Zend_Log based observer
 *
 * Sends updates to a Zend_Log object.
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Pick
 * @since 2.0.0
 */
class Bear_Pick_Observer_ZendLog implements SplObserver
{

    /**
     * Logger
     * @var Zend_Log
     */
    private $_log;

    /**
     * Constructor
     *
     * @param Zend_Log $log
     */
    public function __construct(Zend_Log $log)
    {
        $this->_log = $log;
    }

    /**
     * Get the logger
     *
     * @return Zend_Log
     */
    public function getLog()
    {
        return $this->_log;
    }

    /**
     * Update
     *
     * @param SplSubject $subject
     */
    public function update(SplSubject $subject)
    {
        $action = $subject->getLastAction();

        $this->getLog()->debug(sprintf(
            "%s: %s",
            $action[0],
            $action[1]
        ));
    }

}
