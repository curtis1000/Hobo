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
 * Thumbnail an image
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Filter
 */
class Bear_Filter_Image_Gd_Operation_Thumbnail extends Bear_Base_Abstract implements Bear_Filter_Image_Gd_Operation_Interface
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
     * @return Bear_Filter_Image_Gd_Operation_Thumbnail
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
     * @return Bear_Filter_Image_Gd_Operation_Thumbnail
     */
    public function setMaxWidth($maxWidth)
    {
        $this->_maxWidth = $maxWidth;

        return $this;
    }

    /**
     * Execute the operation on the GD resource
     *
     * @param resource $gd
     * @return resource
     */
    public function filter($gd)
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
