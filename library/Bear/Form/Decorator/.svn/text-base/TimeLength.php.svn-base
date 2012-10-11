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
 * Time length decorator
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Decorator_TimeLength extends Zend_Form_Decorator_Abstract
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
        if (!$element instanceof Bear_Form_Element_TimeLength) {
            return $content;
        }

        $view = $element->getView();
        if (!$view instanceof Zend_View_Interface) {
            return $content;
        }

        $hours     = $element->getHours();
        $minutes   = $element->getMinutes();
        $seconds   = $element->getSeconds();

        if ((int) $hours || (int) $minutes || (int) $seconds) {
            $hours = (int) $hours;
            $minutes = sprintf("%02d", $minutes);
            $seconds = sprintf("%02d", $seconds);
        } else {
            $hours   = null;
            $minutes = null;
            $seconds = null;
        }

        $name      = $element->getFullyQualifiedName();
        $separator = $this->getSeparator();

        $params = array_merge(
            array(
                "maxlength" => 2,
                "size"      => 2
            ),
            $this->getElementAttribs()
        );

        $hourParams = array_merge(
            array(
                "size" => 4
            ),
            $this->getElementAttribs()
        );

        $markup = $view->formText("{$name}[hours]", $hours, $hourParams) . " hour(s), " .
                  $view->formText("{$name}[minutes]", $minutes, $params) . " minute(s) and " .
                  $view->formText("{$name}[seconds]", $seconds, $params) . " second(s)";

        switch ($this->getPlacement()) {
            case self::PREPEND:
                return $markup . $this->getSeparator() . $content;
            case self::APPEND:
            default:
                return $content . $this->getSeparator() . $markup;
        }
    }

    /**
     * Get the attribute id
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
