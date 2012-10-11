<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_Decorator_Abstract */
require_once "Zend/Form/Decorator/Abstract.php";

/**
 * Tab index decorator
 *
 * Iterates over the subforms, display groups and elements, adding a tab
 * index.
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Decorator_TabIndex extends Zend_Form_Decorator_Abstract
{

    /**
     * Decorate content and/or element
     *
     * @param string $content
     * @return string
     * @throws Zend_Dorm_Decorator_Exception
     */
    public function render($content)
    {
        $start = $this->getOption("start");
        if (!$start) {
            $start = 1;
        }

        $this->setFormElementsTabIndex(
            $this->getElement(),
            $start
        );

        return $content;
    }

    public function setFormElementsTabIndex($form, &$tabIndex)
    {
        foreach ($form as $item) {
            if ($item instanceof Zend_Form_Element_Hidden || $item instanceof Zend_Form_Element_Hash) {
                continue;
            } elseif ($item instanceof Zend_Form_Element) {
                $item->setAttrib("tabIndex", $tabIndex++);
            } elseif ($item instanceof Zend_Form) {
                $this->setFormElementsTabIndex($item, $tabIndex);
            } elseif ($item instanceof Zend_Form_DisplayGroup) {
                foreach ($item as $element) {
                    $element->setAttrib("tabIndex", $tabIndex++);
                }
            }
        }

        $this->setOption("end", $tabIndex);
    }

}
