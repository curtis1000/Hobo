<?php
/**
 *
 */

/**
 *
 */
class Bear_Form_Decorator_PrepareElements extends Zend_Form_Decorator_PrepareElements
{

    protected function _recursivelyPrepareForm(Zend_Form $form)
    {
        $belongsTo      = ($form instanceof Zend_Form) ? $form->getElementsBelongTo() : null;
        $elementContent = '';
        $separator      = $this->getSeparator();
        $translator     = $form->getTranslator();
        $view           = $form->getView();

        foreach ($form as $item) {
            $item->setView($view)
                 ->setTranslator($translator);
            if ($item instanceof Zend_Form_Element) {
                $item->setBelongsTo($belongsTo);
            } elseif ($item instanceof Zend_Form) {
                if (!empty($belongsTo)) {
                    if ($item->isArray()) {
                        $name = $this->mergeBelongsTo($belongsTo, $item->getElementsBelongTo());
                        $item->setElementsBelongTo($name, true);
                    } else {
                        $item->setElementsBelongTo($belongsTo, true);
                    }
                }
                $this->_recursivelyPrepareForm($item);
            } elseif (!empty($belongsTo) && ($item instanceof Zend_Form_DisplayGroup)) {
                foreach ($item as $element) {
                    $element->setBelongsTo($belongsTo);
                }
            }
        }
    }
}
