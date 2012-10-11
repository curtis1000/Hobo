<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Filter
 */

/** Bear_Base_Abstract */
require_once "Bear/Base/Abstract.php";

/** Bear_Filter_Image_Gd_Operation_Interface */
require_once "Bear/Filter/Image/Gd/Operation/Interface.php";

/**
 * Output a GIF
 *
 * Filters a GD resource to a GIF file
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Filter
 */
class Bear_Filter_Image_Gd_Operation_Gif extends Bear_Base_Abstract implements Bear_Filter_Image_Gd_Operation_Interface
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
     * @return Bear_Filter_Image_Gd_Filter_Gif
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
     * @return resource
     */
    public function filter($gd)
    {
        $result = imagegif(
            $gd,
            $this->_filename
        );

        if (!$result) {
            /** Bear_Filter_Image_Gd_Exception_ErrorWhileSaving */
            require_once "Bear/Fitler/Image/Gd/Exception/ErrorWhileSaving.php";

            throw new Bear_Filter_Image_Gd_Exception_ErrorWhileSaving();
        }

        return $gd;
    }

}
