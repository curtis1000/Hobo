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
 * Thumbnail an image
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @deprecated
 * @package Bear_Filter
 */
class Bear_Filter_Gd_Thumbnail extends Bear_Filter_Gd_Abstract
{

    /**
     * Maximum height
     * @var integer
     */
    protected $_maxHeight;

    /**
     * Maximum width
     * @var integer
     */
    protected $_maxWidth;

    /**
     * Set the max height
     *
     * @param integer $maxHeight
     * @return Bear_Filter_Gd_Thumbnail
     */
    public function setMaxHeight($maxHeight)
    {
        $this->_maxHeight = $maxHeight;

        return $this;
    }

    /**
     * Set the max width
     *
     * @param integer $maxWidth
     * @return Bear_Filter_Gd_Thumbnail
     */
    public function setMaxWidth($maxWidth)
    {
        $this->_maxWidth = $maxWidth;

        return $this;
    }

    /**
     * Draw the filter
     *
     * @param resource $gd
     * @return Bear_Filter_Gd_Abstract
     */
    protected function _draw($gd)
    {
        $destinationWidth  = $sourceWidth  = imagesX($gd);
        $destinationHeight = $sourceHeight = imagesY($gd);

        $ratio = $sourceWidth / $sourceHeight;

        if ($this->_maxWidth && $destinationWidth > $this->_maxWidth) {
            $destinationWidth  = $this->_maxWidth;
            $destinationHeight = $destinationWidth / $ratio;
        }

        if ($this->_maxHeight && $destinationHeight > $this->_maxHeight) {
            $destinationHeight = $this->_maxHeight;
            $destinationWidth  = $destinationHeight * $ratio;
        }

        $destination = imagecreatetruecolor(
            $destinationWidth,
            $destinationHeight
        );

        $result = imagecopyresampled(
            $destination,
            $gd,
            0,
            0,
            0,
            0,
            $destinationWidth,
            $destinationHeight,
            $sourceWidth,
            $sourceHeight
        );

        return $destination;
    }

}
