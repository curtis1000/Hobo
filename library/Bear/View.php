<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_View
 */

/** Zend_View */
require_once "Zend/View.php";

/**
 * Bear view library
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_View
 * @since 2.0.0
 */
class Bear_View extends Zend_View
{

    /**
     * Enable the filter/helper paths
     *
     * @param Zend_View_Abstract $view
     * @return Zend_View_Abstract
     */
    static public function enableView(Zend_View_Abstract $view)
    {
        return $view->addHelperPath("Bear/View/Helper/", "Bear_View_Helper_")
                    ->addFilterPath("Bear/View/Filter/", "Bear_View_Filter_");
    }

    /**
     * Initialize the view
     */
    public function init()
    {
        self::enableView($this);
    }

}
