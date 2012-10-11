<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Filter
 */

/** Zend_Filter_Interface */
require_once "Zend/Filter/Interface.php";

/**
 * Bear GD filter
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @deprecated
 * @package Bear_Filter
 */
class Bear_Filter_Gd implements Zend_Filter_Interface
{

    /**
     * Open a GD resource
     *
     * @param mixed $value
     * @return resource
     */
    public function filter($value)
    {
        $blob = file_get_contents($value);
        if (!$blob) {
            /** Bear_Filter_Gd_Exception */
            require_once "Bear/Filter/Gd/Exception.php";

            throw new Bear_Filter_Gd_Exception(
                "Could not read the file '{$value}'"
            );
        }

        $gd = imagecreatefromstring($blob);
        if (!$gd) {
            /** Bear_Filter_Gd_Exception */
            require_once "Bear/Filter/Gd/Exception.php";

            throw new Bear_Filter_Gd_Exception(
                "Could not create a GD resource from the file '{$value}'"
            );
        }

        return $gd;
    }

}
