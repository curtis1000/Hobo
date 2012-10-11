<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_DisplayGroup */
require_once "Zend/Form/DisplayGroup.php";

/**
 * Display group
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_DisplayGroup extends Zend_Form_DisplayGroup
{

    /**
     * Constructor
     *
     * @param  string $name
     * @param  Zend_Loader_PluginLoader $loader
     * @param  array|Zend_Config $options
     * @return void
     */
    public function __construct($name, Zend_Loader_PluginLoader $loader, $options = null)
    {
        $loader->addPrefixPath("Bear_Form_Decorator", "Bear/Form/Decorator/", Zend_Form::DECORATOR);
        parent::__construct($name, $loader, $options);
    }

    /**
     * Load default decorators
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

}
