<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_Element_MultiCheckbox */
require_once "Zend/Form/Element/MultiCheckbox.php";

/**
 * MultiCheckbox element
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Element_MultiCheckbox extends Zend_Form_Element_MultiCheckbox
{

    /**
     * Class
     * @var string
     */
    public $class = "input-type input-type-multicheckbox input-attribute-select input-attribute-multiple";

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
            $this->addDecorator("Errors")
                 ->addDecorator("ViewHelper")
                 ->addDecorator("Description", array("tag" => "p", "class" => "description"))
                 ->addDecorator("HtmlTag", array("tag" => "div", "class" => "element-content"))
                 ->addDecorator("Label", array("class" => "element-label", "disableFor" => true))
                 ->addDecorator("LiWrapper");
        }
    }

}
