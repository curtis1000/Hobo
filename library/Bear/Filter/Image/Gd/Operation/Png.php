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
 * Output a PNG
 *
 * Filters a GD resource to a PNG file
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Filter
 */
class Bear_Filter_Image_Gd_Operation_Png extends Bear_Base_Abstract implements Bear_Filter_Image_Gd_Operation_Interface
{

    /**
     * Filename
     * @var string
     */
    protected $_filename;

    /**
     * Filters
     * @var integer
     */
    protected $_filters;

    /**
     * Image quality
     * @var integer
     */
    protected $_quality = 9;

    /**
     * Set the filename
     *
     * @param string $filename
     * @return Bear_Filter_Image_Gd_Filter_Png
     */
    public function setFilename($filename)
    {
        $this->_filename = $filename;

        return $this;
    }

    /**
     * Set the filters
     *
     * @param integer $filters
     * @return Bear_Filter_Image_Gd_Filter_Png
     */
    public function setFilters($filters)
    {
        $this->_filters = $filters;

        return $this;
    }

    /**
     * Set the image quality
     *
     * @param integer $quality
     * @return Bear_Filter_Image_Gd_Filter_Png
     */
    public function setQuality($quality)
    {
        $this->_quality = $quality;

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
        $result = imagepng(
            $gd,
            $this->_filename,
            $this->_quality,
            $this->_filters
        );

        if (!$result) {
            /** Bear_Filter_Gd_Exception */
            require_once "Bear/Filter/Gd/Exception.php";

            throw new Bear_Filter_Gd_Exception(
                "An error occurred while saving the file"
            );
        }

        return $gd;
    }

}
