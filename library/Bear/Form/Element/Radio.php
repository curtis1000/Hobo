<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_Element_Radio */
require_once "Zend/Form/Element/Radio.php";

/**
 * Radio element
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Element_Radio extends Zend_Form_Element_Radio
{

    /**
     * Class
     * @var string
     */
    public $class = "input-type input-type-radio input-generic-select input-generic-single";

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
            $this->addDecorator("Multi")
                 ->addDecorator("Description", array("tag" => "p", "class" => "description"))
                 ->addDecorator("Errors", array("placement" => "prepend"))
                 ->addDecorator("LabelLegendFieldset")
                 ->addDecorator("LiWrapper");
        }
    }

}
