<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_JQuery
 */

/** Bear_Form */
require_once "Bear/Form.php";

/**
 * JQuery-enabled Bear_Form class
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_JQuery
 * @since 2.0.0
 */
class Bear_JQuery_Form extends Zend_Form
{

    /**
     * Default display group class
     * @var string
     */
    protected $_defaultDisplayGroupClass = 'Bear_Form_DisplayGroup';

    /**
     * Enable the filter/validator/decorator/element paths
     *
     * @param Zend_Form $form
     * @return Zend_Form
     */
    static public function enableForm(Zend_Form $form)
    {
        /** Bear_Form */
        require_once "Bear/Form.php";

        Bear_Form::enableForm($form);

        /** ZendX_JQuery */
        require_once "ZendX/JQuery.php";

        ZendX_JQuery::enableForm($form);

        $form->addElementPrefixPath("Bear_JQuery_Form_", "Bear/JQuery/Form/")
             ->addPrefixPath("Bear_JQuery_Form_", "Bear/JQuery/Form/");

        foreach ($form->getSubForms() as $subForm) {
            self::enableForm($subForm);
        }

        if ($form->getView()) {
            /** Bear_JQuery_View */
            require_once "Bear/JQuery/View.php";

            Bear_JQuery_View::enableView($form->getView());
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
     * Ensures that the view object has the dojo view helper path set.
     *
     * @param  Zend_View_Interface $view
     * @return Zend_View_Interface
     */
    public function setView(Zend_View_Interface $view = null)
    {
        if ($view) {
            /** Bear_JQuery_View */
            require_once "Bear/JQuery/View.php";

            Bear_JQuery_View::enableView($view);
        }

        return parent::setView($view);
    }

}
