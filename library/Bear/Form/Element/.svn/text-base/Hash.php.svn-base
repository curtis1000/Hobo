<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_Element_Hash */
require_once "Zend/Form/Element/Hash.php";

/**
 * Hash element
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Element_Hash extends Zend_Form_Element_Hash
{

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
            $this->addDecorator('ViewHelper');
        }
    }

}
