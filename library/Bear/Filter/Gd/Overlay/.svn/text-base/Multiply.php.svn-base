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
 * Bear GD multiple overlay filter class
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @deprecated
 * @package Bear_Filter
 */
class Bear_Filter_Gd_Overlay_Multiply extends Bear_Filter_Gd_Overlay_Abstract
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
            "red"   => (int) (($bottom["red"] * $top["red"]) / 255),
            "green" => (int) (($bottom["green"] * $top["green"]) / 255),
            "blue"  => (int) (($bottom["blue"] * $top["blue"]) / 255)
        );
    }

}
