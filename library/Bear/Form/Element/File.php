<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_Element_File */
require_once "Zend/Form/Element/File.php";

/**
 * File element
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Element_File extends Zend_Form_Element_File
{

    /**
     * Class
     * @var string
     */
    public $class = "input-type input-type-file input-attribute-type";

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
                 ->addDecorator("File")
                 ->addDecorator("Description", array("tag" => "p", "class" => "description"))
                 ->addDecorator("HtmlTag", array("tag" => "div", "class" => "element-content"))
                 ->addDecorator("Label", array("class" => "element-label"))
                 ->addDecorator("LiWrapper");
        }
    }

}
