<?php
/**
 *
 */

/**
 *
 */
class Bear_Form_Decorator_Fieldset extends Zend_Form_Decorator_Fieldset
{

    /**
     * Render a fieldset
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $legend  = $this->getLegend();
        $attribs = $this->getOptions();
        $name    = $element->getFullyQualifiedName();
        $id      = (string)$element->getId();

        if (!array_key_exists('id', $attribs) && '' !== $id) {
            if ($element instanceof Zend_Form_Element) {
                if (null !== ($belongsTo = $element->getBelongsTo())) {
                    $belongsTo = preg_replace('/\[([^\]]+)\]/', '-$1', $belongsTo);
                    $id = $belongsTo . '-' . $id;
                }
            } elseif ($element instanceof Zend_Form) {
                if (null !== ($belongsTo = $element->getElementsBelongTo())) {
                    $belongsTo = preg_replace('/\[([^\]]+)\]/', '-$1', $belongsTo);
                    $id = $belongsTo;
                }
            }

            $attribs['id'] = 'fieldset-' . $id;
        }

        if (null !== $legend) {
            if (null !== ($translator = $element->getTranslator())) {
                $legend = $translator->translate($legend);
            }

            $attribs['legend'] = $legend;
        }

        foreach (array_keys($attribs) as $attrib) {
            $testAttrib = strtolower($attrib);
            if (in_array($testAttrib, $this->stripAttribs)) {
                unset($attribs[$attrib]);
            }
        }

        return $view->fieldset($name, $content, $attribs);
    }
}
