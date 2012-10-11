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
 * Form-level hidden element decorator
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Decorator_FormHiddenElements extends Zend_Form_Decorator_FormElements
{

    /**
     * Default placement: append
     * @var string
     */
    protected $_placement = 'PREPEND';

    /**
     * Render form elements
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        $elementContent = '';
        $items          = array();
        $separator      = $this->getSeparator();

        foreach ($this->getElement() as $item) {
            if ($item instanceof Zend_Form_Element_Hidden || $item instanceof Zend_Form_Element_Hash) {
                $items[] = $item->render();
            }
        }

        $elementContent = implode($separator, $items);

        switch ($this->getPlacement()) {
            case self::APPEND:
                return $content . $separator . $elementContent;
            break;

            case self::PREPEND:
            default:
                return $elementContent . $separator . $content;
            break;
        }
    }

}
