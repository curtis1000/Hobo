<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_Decorator_FormElements */
require_once 'Zend/Form/Decorator/FormElements.php';

/**
 * Form-level visible element decorator
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Decorator_FormVisibleElements extends Zend_Form_Decorator_FormElements
{

    /**
     * Render form elements
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        $elementContent = '';
        $form           = $this->getElement();
        $items          = array();
        $separator      = $this->getSeparator();

        foreach ($form as $item) {
            if (!$item instanceof Zend_Form_Element_Hidden && !$item instanceof Zend_Form_Element_Hash) {
                $items[] = $item->render();
            }
        }

        $elementContent = implode($separator, $items);

        switch ($this->getPlacement()) {
            case self::PREPEND:
                return $elementContent . $separator . $content;
            break;

            case self::APPEND:
            default:
                return $content . $separator . $elementContent;
            break;
        }
    }

}
