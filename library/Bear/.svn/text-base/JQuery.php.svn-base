<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_JQuery
 */

/**
 * Bear jQuery library
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_JQuery
 * @since 2.0.0
 */
class Bear_JQuery
{

    /**
     * jQuery-enable a view instance
     *
     * @param  Zend_View_Interface $view
     * @return void
     */
    public static function enableView(Zend_View_Interface $view)
    {
        /** ZendX_JQuery */
        require_once "ZendX/JQuery.php";

        ZendX_JQuery::enableView($view);

        if (false === $view->getPluginLoader("helper")->getPaths("Bear_JQuery_View_Helper")) {
            $view->addHelperPath("Bear/JQuery/View/Helper", "Bear_JQuery_View_Helper");
        }
    }

    /**
     * jQuery-enable a form instance
     *
     * @param  Zend_Form $form
     * @return void
     */
    public static function enableForm(Zend_Form $form)
    {
        /** ZendX_JQuery */
        require_once "ZendX/JQuery.php";

        ZendX_JQuery::enableForm($form);

        $form->addPrefixPath("Bear_JQuery_Form_Decorator", "Bear/JQuery/Form/Decorator", "decorator")
             ->addPrefixPath("Bear_JQuery_Form_Element", "Bear/JQuery/Form/Element", "element")
             ->addElementPrefixPath("Bear_JQuery_Form_Decorator", "Bear/JQuery/Form/Decorator", "decorator")
             ->addDisplayGroupPrefixPath("Bear_JQuery_Form_Decorator", "Bear/JQuery/Form/Decorator");

        foreach ($form->getSubForms() as $subForm) {
            self::enableForm($subForm);
        }

        if (null !== ($view = $form->getView())) {
            self::enableView($view);
        }
    }

}
