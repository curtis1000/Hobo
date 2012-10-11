<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_JQuery
 */

/** ZendX_JQuery_Form_Element_DatePicker */
require_once "ZendX/JQuery/Form/Element/DatePicker.php";

/**
 * DatePicker element
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_JQuery
 * @since 2.0.0
 */
class Bear_JQuery_Form_Element_DatePicker extends ZendX_JQuery_Form_Element_DatePicker
{

    /**
     * jQuery related parameters of this form element.
     *
     * @var array
     */
    public $jQueryParams = array(
        "dateFormat" => "yy-mm-dd"
    );

    /**
     * Class
     * @var string
     */
    public $class = "input-type input-type-text input-attribute-type";

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
                 ->addDecorator('UiWidgetElement')
                 ->addDecorator("Description", array("tag" => "p", "class" => "description"))
                 ->addDecorator("HtmlTag", array("tag" => "div", "class" => "element-content"))
                 ->addDecorator("Label", array("class" => "element-label"))
                 ->addDecorator("LiWrapper");
        }
    }

}