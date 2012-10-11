<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Pick
 */

/**
 * Direct echo observer
 *
 * Directly prints observed updates.
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Pick
 * @since 2.0.0
 */
class Bear_Pick_Observer_Echo implements SplObserver
{

    /**
     * Update
     *
     * @param SplSubject $subject
     */
    public function update(SplSubject $subject)
    {
        $action = $subject->getLastAction();

        if (PHP_SAPI == "cli") {
            printf(
                "%s: %s%s",
                $action[0],
                $action[1],
                PHP_EOL
            );
        } else {
            printf(
                "%s: %s%s",
                $action[0],
                htmlspecialchars($action[1]),
                "<br />"
            );
        }
    }

}
