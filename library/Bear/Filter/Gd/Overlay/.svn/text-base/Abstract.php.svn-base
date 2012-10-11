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
 * Bear GD overlay filter base class
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @deprecated
 * @package Bear_Filter
 */
abstract class Bear_Filter_Gd_Overlay_Abstract extends Bear_Filter_Gd_Abstract
{

    /**
     * Overlay file
     * @var string
     */
    protected $_overlay;

    /**
     * X offset
     * @var integer
     */
    protected $_x = 0;

    /**
     * Y offset
     * @var integer
     */
    protected $_y = 0;

    /**
     * Set the overlay file
     *
     * @param string $overlay
     * @return Bear_Filter_Gd_Overlay_Abstract
     */
    public function setOverlay($overlay)
    {
        $this->_overlay = $overlay;

        return $this;
    }

    /**
     * Set the X offset
     *
     * @param integer $x
     * @return Bear_Filter_Gd_Overlay_Abstract
     */
    public function setX($x)
    {
        $this->_x = $x;

        return $this;
    }

    /**
     * Set the Y offset
     *
     * @param integer $y
     * @return Bear_Filter_Gd_Overlay_Abstract
     */
    public function setY($y)
    {
        $this->_y = $y;

        return $this;
    }

    /**
     * Draw the overlay
     *
     * @param resource $bottom
     * @return Bear_Filter_Gd_Overlay_Abstract
     */
    protected function _draw($bottom)
    {
        $top = $this->_getOverlayResource();

        $width  = min(imagesx($bottom), imagesx($top) + $this->_x);
        $height = min(imagesy($bottom), imagesy($top) + $this->_y);

        for ($x = 0; $x < $width; ++$x) {
            for ($y = 0; $y < $height; ++$y) {
                $color = $this->_getMergedColor(
                    $this->_getColorAt($bottom, $this->_x + $x, $this->_y + $y),
                    $this->_getColorAt($top, $x, $y)
                );

                imagesetpixel(
                    $bottom,
                    $this->_x + $x,
                    $this->_y + $y,
                    imagecolorallocate(
                        $bottom,
                        $color["red"],
                        $color["green"],
                        $color["blue"]
                    )
                );
            }
        }

        return $bottom;
    }

    /**
     * Get the RGB values for a pixel
     *
     * @param resource $gd
     * @param integer $x
     * @param integer $y
     * @return array
     */
    protected function _getColorAt($gd, $x, $y)
    {
        $color = imagecolorat($gd, $x, $y);

        return array(
            "red"   => ($color >> 16) & 0xFF,
            "green" => ($color >> 8) & 0xFF,
            "blue"  => $color & 0xFF
        );
    }

    /**
     * Get the merged color
     *
     * @param array $bottom
     * @param array $top
     * @return array
     */
    abstract protected function _getMergedColor($bottom, $top);

    /**
     * Get the overlay resource
     *
     * @return resource
     */
    protected function _getOverlayResource()
    {
        $filter = new Bear_Filter_Gd();
        return $filter->filter($this->_overlay);
    }

}
