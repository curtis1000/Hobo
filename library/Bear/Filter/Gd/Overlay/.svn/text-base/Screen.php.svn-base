<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Filter
 */

/** Bear_Filter_Gd_Overlay_Abstract */
require_once "Bear/Filter/Gd/Overlay/Abstract.php";

/**
 * Bear GD screen overlay filter class
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @deprecated
 * @package Bear_Filter
 */
class Bear_Filter_Gd_Overlay_Screen extends Bear_Filter_Gd_Overlay_Abstract
{

    /**
     * Get the merged color
     *
     * @param array $bottom
     * @param array $top
     * @return array
     */
    protected function _getMergedColor($bottom, $top)
    {
        return array(
            "red"   => (int) (255 - (((255 - $bottom["red"]) * (255 - $top["red"])) / 255)),
            "green" => (int) (255 - (((255 - $bottom["green"]) * (255 - $top["green"])) / 255)),
            "blue"  => (int) (255 - (((255 - $bottom["blue"]) * (255 - $top["blue"])) / 255)),
        );
    }

}
