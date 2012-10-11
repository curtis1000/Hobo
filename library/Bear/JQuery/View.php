<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_JQuery
 */

/** Zend_View */
require_once "Zend/View.php";

/**
 * Bear JQuery view library
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_JQuery
 * @since 2.0.0
 */
class Bear_JQuery_View extends Zend_View
{

    /**
     * Enable the filter/helper paths
     *
     * @param Zend_View_Abstract $view
     * @return Zend_View_Abstract
     */
    static public function enableView(Zend_View $view)
    {
        /** Bear_View */
        require_once "Bear/View.php";

        Bear_View::enableView($view);

        /** ZendX_JQuery */
        require_once "ZendX/JQuery.php";

        ZendX_JQuery::enableView($view);

        if (false === $view->getPluginLoader("helper")->getPaths("Bear_JQuery_View_Helper")) {
            $view->addHelperPath("Bear/JQuery/View/Helper", "Bear_JQuery_View_Helper");
        }

        if (false === $view->getPluginLoader("filter")->getPaths("Bear_JQuery_View_Filter")) {
            $view->addFilterPath("Bear/JQuery/View/Filter", "Bear_JQuery_View_Filter");
        }

        return $view;
    }

    /**
     * Constructor
     *
     * @param array $config Configuration key-value pairs.
     */
    public function __construct($config = array())
    {
        self::enableView($this);

        parent::__cosntruct($config);
    }

}
