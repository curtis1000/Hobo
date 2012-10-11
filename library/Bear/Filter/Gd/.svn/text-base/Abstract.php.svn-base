<?php
/**
 * BEAR
 *
 * @category Bear
 * @deprecated
 * @package Bear_Filter
 */

/** Bear_Base_Abstract */
require_once "Bear/Base/Abstract.php";

/** Zend_Filter_Interface */
require_once "Zend/Filter/Interface.php";

/**
 * Bear GD filter base class
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @deprecated
 * @package Bear_Filter
 */
abstract class Bear_Filter_Gd_Abstract extends Bear_Base_Abstract implements Zend_Filter_Interface
{

    /**
     * Filter
     *
     * @param mixed $value
     * @return resource
     * @throws Bear_Filter_Gd_Exception
     */
    public function filter($value)
    {
        if (!is_resource($value)) {
            /** Bear_Filter_Gd_Exception */
            require_once "Bear/Filter/Gd/Exception.php";

            throw new Bear_Filter_Gd_Exception(
                "Filtered value is not a resource"
            );
        }

        if (get_resource_type($value) != "gd") {
            /** Bear_Filter_Gd_Exception */
            require_once "Bear/Filter/Gd/Exception.php";

            throw new Bear_Filter_Gd_Exception(
                "Filtered value is not a GD resource"
            );
        }

        return $this->_draw($value);
    }

    /**
     * Draw the filter
     *
     * @param resource $gd
     * @return mixed
     */
    abstract protected function _draw($gd);

}
