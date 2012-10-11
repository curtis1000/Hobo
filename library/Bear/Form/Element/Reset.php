<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_Element_Reset */
require_once "Zend/Form/Element/Reset.php";

/**
 * Reset element
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Element_Reset extends Zend_Form_Element_Reset
{

    /**
     * Class
     * @var string
     */
    public $class = "input-type input-type-reset input-attribute-click";

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
            $this->addDecorator("ViewHelper")
                 ->addDecorator("LiWrapper");
        }
    }

}
