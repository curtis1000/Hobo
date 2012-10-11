<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_JQuery
 */

/** Bear_Form_SubForm */
require_once "Bear/Form.php";

/**
 * JQuery-enabled Bear_Form_SubForm class
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_JQuery
 * @since 2.0.0
 */
class Bear_JQuery_Form_SubForm extends Bear_Form_SubForm
{

    /**
     * Constructor
     *
     * @param  array|Zend_Config|null $options
     * @return void
     */
    public function __construct($options = null)
    {
        $this->addDisplayGroupPrefixPath("ZendX_JQuery_Form", "ZendX/JQuery/Form")
             ->addDisplayGroupPrefixPath("Bear_JQuery_Form", "Bear/JQuery/Form")
             ->addPrefixPath("ZendX_JQuery_Form", "ZendX/JQuery/Form")
             ->addPrefixPath("Bear_JQuery_Form", "Bear/JQuery/Form");

 		parent::__construct($options);
    }

    /**
     * Set the view object
     *
     * Ensures that the view object has the dojo view helper path set.
     *
     * @param  Zend_View_Interface $view
     * @return Zend_Dojo_Form_Element_Dijit
     */
    public function setView(Zend_View_Interface $view = null)
    {
        if (null !== $view) {
            if (false === $view->getPluginLoader("helper")->getPaths("Bear_JQuery_View_Helper")) {
                $view->addHelperPath("Bear/JQuery/View/Helper", "Bear_JQuery_View_Helper");
            }
            if (false === $view->getPluginLoader('helper')->getPaths('ZendX_JQuery_View_Helper')) {
                $view->addHelperPath('ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');
            }
        }
        return parent::setView($view);
    }

}