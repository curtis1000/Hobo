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
 * Phone number decorator
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Decorator_PhoneNumber extends Zend_Form_Decorator_Abstract
{

    /**
     * Retrieve element attributes
     *
     * Set id to element name and/or array item.
     *
     * @return array
     */
    public function getElementAttribs()
    {
        if (null === ($element = $this->getElement())) {
            return null;
        }

        $attribs = $element->getAttribs();
        if (isset($attribs['helper'])) {
            unset($attribs['helper']);
        }

        return $attribs;
    }

    /**
     * Decorate content and/or element
     *
     * @param string $content
     * @return string
     * @throws Zend_Dorm_Decorator_Exception
     */
    public function render($content)
    {
        $element = $this->getElement();
        if (!$element instanceof Bear_Form_Element_PhoneNumber) {
            return $content;
        }

        $view = $element->getView();
        if (!$view instanceof Zend_View_Interface) {
            return $content;
        }

        $areaCode  = $element->getAreaCode();
        $prefix    = $element->getPrefix();
        $line      = $element->getLine();
        $extension = $element->getExtension();

        $name      = $element->getFullyQualifiedName();
        $separator = $this->getSeparator();

        $markup = sprintf(
            "(%s) %s-%s",
            $view->formText(
                "{$name}[areaCode]",
                $areaCode,
                array_merge(
                    array(
                        "maxlength" => 3,
                        "size"      => 3
                    ),
                    $this->getElementAttribs()
                )
            ),
            $view->formText(
                "{$name}[prefix]",
                $prefix,
                array_merge(
                    array(
                        "maxlength" => 3,
                        "size"      => 3
                    ),
                    $this->getElementAttribs()
                )
            ),
            $view->formText(
                "{$name}[line]",
                $line,
                array_merge(
                    array(
                        "maxlength" => 4,
                        "size"      => 4
                    ),
                    $this->getElementAttribs()
                )
            )
        );

        if ($element->allowExtension()) {
            $markup .= sprintf(
                " ext. %s",
                $view->formText(
                    "{$name}[extension]",
                    $extension,
                    array_merge(
                        array(
                            "size" => 4
                        ),
                        $this->getElementAttribs()
                    )
                )
            );
        }

        switch ($this->getPlacement()) {
            case self::PREPEND:
                return $markup . $this->getSeparator() . $content;
            case self::APPEND:
            default:
                return $content . $this->getSeparator() . $markup;
        }
    }

    /**
     * Get the attribute ID
     *
     * @return string
     */
    protected function _getId()
    {
        $id = $this->getElement()->getName();

        if ($element instanceof Zend_Form_Element) {
            if (null !== ($belongsTo = $element->getBelongsTo())) {
                $belongsTo = preg_replace('/\[([^\]]+)\]/', '-$1', $belongsTo);
                $id = $belongsTo . '-' . $id;
            }
        }

        return $id;
    }

}
