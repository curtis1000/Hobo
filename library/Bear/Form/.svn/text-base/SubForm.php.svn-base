<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_SubForm */
require_once "Zend/Form/SubForm.php";

/**
 * Extension of the Zend_Form_SubForm class
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_SubForm extends Zend_Form_SubForm
{

    /**
     * Constructor
     *
     * @param  array|Zend_Config|null $options
     * @return void
     */
    public function __construct($options = null)
    {
        /** Bear_Form */
        require_once "Bear/Form.php";
        Bear_Form::enableForm($this);
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
            $this->addDecorator("FormVisibleElements")
                 ->addDecorator("HtmlTag", array("tag" => "ol", "class" => "bear-form"))
                 ->addDecorator("FormHiddenElements")
                 ->addDecorator("LiWrapper");
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
