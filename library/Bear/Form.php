<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form */
require_once "Zend/Form.php";

/** Zend_Form_Element **/
require_once "Zend/Form/Element.php";

/**
 * Extension of the Zend_Form class
 *
 * @author Justin Hendrickson <justin.hendrickson@nerdery.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form extends Zend_Form
{

    /**
     * Setup a form to use Bear paths
     *
     * @param Zend_Form $form
     * @return Zend_Form
     */
    static public function enableForm(Zend_Form $form)
    {
        $form->addElementPrefixPath("Bear_Filter_", "Bear/Filter/", Zend_Form_Element::FILTER)
             ->addElementPrefixPath("Bear_Validate_", "Bear/Validate/", Zend_Form_Element::VALIDATE)
             ->addPrefixPath("Bear_Form_", "Bear/Form/")
             ->setDefaultDisplayGroupClass("Bear_Form_DisplayGroup");

        if ($form->getView()) {
            /** Bear_View */
            require_once "Bear/View.php";
            Bear_View::enableView($form->getView());
        }

        return $form;
    }

    /**
     * Constructor
     *
     * @param  array|Zend_Config|null $options
     * @return void
     */
    public function __construct($options = null)
    {
        self::enableForm($this);
        parent::__construct($options);
    }

    /**
     * Load the default decorators
     *
     * @return void
     */
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator("PrepareElements")
                 ->addDecorator("FormVisibleElements")
                 ->addDecorator("HtmlTag", array("tag" => "ol", "class" => "bear-form"))
                 ->addDecorator("FormHiddenElements")
                 ->addDecorator("Form")
                 ->addDecorator("FormErrors", array("placement" => "prepend"));
        }
    }

    /**
     * Set the view object
     *
     * Ensures that the view object has the Bear view paths set.
     *
     * @param Zend_View_Interface $view
     * @return Bear_Form
     */
    public function setView(Zend_View_Interface $view = null)
    {
        if ($view) {
            /** Bear_View */
            require_once "Bear/View.php";
            Bear_View::enableView($view);
        }
        return parent::setView($view);
    }

}
