<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Filter
 */

/** Bear_Filter_Gd_Abstract */
require_once "Bear/Filter/Gd/Abstract.php";

/**
 * Output a GIF
 *
 * Filters a GD resource to a GIF file
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @deprecated
 * @package Bear_Filter
 */
class Bear_Filter_Gd_Gif extends Bear_Filter_Gd_Abstract
{

    /**
     * Filename
     * @var string
     */
    protected $_filename;

    /**
     * Set the filename
     *
     * @param string $filename
     * @return Bear_Filter_Gd_SaveGif
     */
    public function setFilename($filename)
    {
        $this->_filename = $filename;

        return $this;
    }

    /**
     * Draw the filter
     *
     * @param resource $gd
     * @return string
     */
    protected function _draw($gd)
    {
        $result = imagegif(
            $gd,
            $this->_filename
        );

        if (!$result) {
            /** Bear_Filter_Gd_Exception */
            require_once "Bear/Filter/Gd/Exception.php";

            throw new Bear_Filter_Gd_Exception(
                "An error occurred while saving the file"
            );
        }

        if ($this->_filename) {
            return $this->_filename;
        } else {
            return $result;
        }
    }

}
