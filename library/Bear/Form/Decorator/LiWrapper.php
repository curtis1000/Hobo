<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_Decorator_Abstract */
require_once 'Zend/Form/Decorator/Abstract.php';

/**
 * <li> decorator wrapper
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Decorator_LiWrapper extends Zend_Form_Decorator_Abstract
{

    /**
     * Get the element classes
     *
     * @return string
     */
    public function getClasses()
    {
        $class = $this->getOption("class");
        if ($class) {
            $classes[] = $class;
        }

        $classes[] = "element-wrapper";
        $classes[] = $this->_getWrapperType();

        if ($this->_hasErrors()) {
            $classes[] = "element-wrapper-error";
        }

        return implode(" ", $classes);
    }

    /**
     * Get the ID
     *
     * @return string
     */
    public function getId()
    {
        if ($this->getOption("id")) {
            return $this->getOption("id");
        }

        $element = $this->getElement();

        $id = $element->getName();

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

        $id .= "-container";

        return $id;
    }

    /**
     * Render
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        $options          = $this->getOptions();
        $options["id"]    = $this->getId();
        $options["class"] = $this->getClasses();
        $options["tag"]   = "li";

        /** Zend_Form_Decorator_HtmlTag */
        require_once "Zend/Form/Decorator/HtmlTag.php";

        $htmlTag = new Zend_Form_Decorator_HtmlTag($options);

        return $htmlTag->render($content);
    }

    /**
     * Get the wrapper type
     *
     * @return string
     */
    private function _getWrapperType()
    {
        if ($this->_isWrapperType()) {
            return "element-wrapper-group";
        } elseif ($this->_isMultiElement()) {
            return "element-wrapper-multiple";
        } else {
            return "element-wrapper-single";
        }
    }

    /**
     * Is the element a wrapper type
     *
     * @return boolean
     */
    public function _isWrapperType()
    {
        return $this->getElement() instanceof Zend_Form ||
               $this->getElement() instanceof Zend_Form_SubForm ||
               $this->getElement() instanceof Zend_Form_DisplayGroup;
    }

    /**
     * Is the element a multi-element element?
     *
     * @return boolean
     */
    private function _isMultiElement()
    {
        return $this->getElement() instanceof Zend_Form_Element_Radio ||
               $this->getElement() instanceof Zend_Form_Element_MultiCheckbox;
    }

    /**
     * Does the element have errors
     *
     * @return boolean
     */
    private function _hasErrors()
    {
        return ($this->getElement() instanceof Zend_Form_Element && $this->getElement()->hasErrors());
    }

}
