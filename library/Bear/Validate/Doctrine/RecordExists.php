<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Validate
 */

/** Bear_Validate_Doctrine_Abstract */
require_once "Bear/Validate/Doctrine/Abstract.php";

/**
 * Confirms a record exists in a table.
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Validate
 * @since 2.0.0
 */
class Bear_Validate_Doctrine_RecordExists extends Bear_Validate_Doctrine_Abstract
{

    public function isValid($value)
    {
        $this->_setValue($value);

        if (count($this->_query($value)) != 1) {
            $this->_error(self::ERROR_NO_RECORD_FOUND);
            return false;
        }

        return true;
    }

}
