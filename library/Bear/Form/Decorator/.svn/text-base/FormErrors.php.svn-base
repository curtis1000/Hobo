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
 * Decorator for displaying all a forms errors
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Decorator_FormErrors extends Zend_Form_Decorator_Abstract
{

    /**#@+
     * Markup
     * @var string
     */
    protected $_errorEndMarkup = "";
    protected $_errorStartMarkup = "";
    protected $_elementEndMarkup = "</b>";
    protected $_elementStartMarkup = "<b>";
    protected $_itemEndMarkup = "</li>";
    protected $_itemStartMarkup = "<li>";
    protected $_listEndMarkup = "</ul>";
    protected $_listStartMarkup = "<ul class=\"form-errors\">";
    protected $_subformEndMarkup = "</b>";
    protected $_subformStartMarkup = "<b>";
    /**#@-*/

    /**
     * Disable subform nesting
     * @var boolean
     */
    protected $_disableSubFormNesting = false;

    /**
     * View
     * @var Zend_View_Abstract
     */
    protected $_view;

    /**
     * Get the disable subform nesting flag
     *
     * @return boolean
     */
    public function getDisableSubFormNesting()
    {
        $key = "disableSubFormNesting";

        if ($this->getOption($key) !== null) {
            $this->_disableSubFormNesting = $this->getOption($key);
            $this->removeOption($key);
        }

        return $this->_disableSubFormNesting;
    }

    /**
     * Get the markup for the end of an element
     *
     * @return string
     */
    public function getElementEndMarkup()
    {
        $key = "elementEndMarkup";

        if ($this->getOption($key) !== null) {
            $this->_elementEndMarkup = $this->getOption($key);
            $this->removeOption($key);
        }

        return $this->_elementEndMarkup;
    }

    /**
     * Get the markup for the start of an element
     *
     * @return string
     */
    public function getElementStartMarkup()
    {
        $key = "elementStartMarkup";

        if ($this->getOption($key) !== null) {
            $this->_elementStartMarkup = $this->getOption($key);
            $this->removeOption($key);
        }

        return $this->_elementStartMarkup;
    }

    /**
     * Get the markup for the end of an error
     *
     * @return string
     */
    public function getErrorEndMarkup()
    {
        $key = "errorEndMarkup";

        if ($this->getOption($key) !== null) {
            $this->_errorEndMarkup = $this->getOption($key);
            $this->removeOption($key);
        }

        return $this->_errorEndMarkup;
    }

    /**
     * Get the markup for the start of an error
     *
     * @return string
     */
    public function getErrorStartMarkup()
    {
        $key = "errorStartMarkup";
        
        if ($this->getOption($key) !== null) {
            $this->_errorStartMarkup = $this->getOption($key);
            $this->removeOption($key);
        }

        return $this->_errorStartMarkup;
    }

    /**
     * Get the markup for the end of an item
     *
     * @return string
     */
    public function getItemEndMarkup()
    {
        $key = "itemEndMarkup";

        if ($this->getOption($key) !== null) {
            $this->_itemEndMarkup = $this->getOption($key);
            $this->removeOption($key);
        }

        return $this->_itemEndMarkup;
    }

    /**
     * Get the markup for the start of an item
     *
     * @return string
     */
    public function getItemStartMarkup()
    {
        $key = "itemStartMarkup";

        if ($this->getOption($key) !== null) {
            $this->_itemStartMarkup = $this->getOption($key);
            $this->removeOption($key);
        }

        return $this->_itemStartMarkup;
    }

    /**
     * Get the markup for the end of a list
     *
     * @return string
     */
    public function getListEndMarkup()
    {
        $key = "listEndMarkup";

        if ($this->getOption($key) !== null) {
            $this->_listEndMarkup = $this->getOption($key);
            $this->removeOption($key);
        }

        return $this->_listEndMarkup;
    }

    /**
     * Get the markup for the start of a list
     *
     * @return string
     */
    public function getListStartMarkup()
    {
        $key = "listStartMarkup";

        if ($this->getOption($key) !== null) {
            $this->_listStartMarkup = $this->getOption($key);
            $this->removeOption($key);
        }

        return $this->_listStartMarkup;
    }

    /**
     * Get the markup for the end of a subform
     *
     * @return string
     */
    public function getSubformEndMarkup()
    {
        $key = "subformEndMarkup";

        if ($this->getOption($key) !== null) {
            $this->_subformEndMarkup = $this->getOption($key);
            $this->removeOption($key);
        }

        return $this->_subformEndMarkup;
    }

    /**
     * Get the markup for the start of a subform
     *
     * @return string
     */
    public function getSubformStartMarkup()
    {
        $key = "subformStartMarkup";

        if ($this->getOption($key) !== null) {
            $this->_subformStartMarkup = $this->getOption($key);
            $this->removeOption($key);
        }

        return $this->_subformStartMarkup;
    }

    /**
     * Decorate content
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        if (!$this->getElement() instanceof Zend_Form && !$this->getElement() instanceof Zend_Form_SubForm) {
            return $content;
        }

        $this->_view = $this->getElement()->getView();

        $markup = $this->_recurseForm($this->getElement());

        if (!$markup) {
            return $content;
        }

        switch ($this->getPlacement()) {
            case self::PREPEND:
                return $markup . $this->getSeparator() . $content;
            case self::APPEND:
            default:
                return $content . $this->getSeparator() . $markup;
        }

        return $content;
    }

    /**
     * Set the disable subform nesting flag
     *
     * @param boolean $disableSubFormNesting
     * @return Bear_Form_Decorator_FormErrors
     */
    public function setDisableSubFormNesting($disableSubFormNesting)
    {
        $this->removeOption("disableSubFormNesting");
        $this->_disableSubFormNesting = $disableSubFormNesting;
        return $this;
    }

    /**
     * Set the markup for the end of an element
     *
     * @param string $elementEndMarkup
     * @return Bear_Form_Decorator_FormErrors
     */
    public function setElementEndMarkup($elementEndMarkup)
    {
        $this->removeOption("elementEndMarkup");
        $this->_elementEndMarkup = $elementEndMarkup;
        return $this;
    }

    /**
     * Set the markup for the start of an element
     *
     * @param string $elementStartMarkup
     * @return Bear_Form_Decorator_FormErrors
     */
    public function setElementStartMarkup($elementStartMarkup)
    {
        $this->removeOption("elementStartMarkup");
        $this->_elementStartMarkup = $elementStartMarkup;
        return $this;
    }

    /**
     * Set the markup for the end of an error
     *
     * @param string $errorEndMarkup
     * @return Bear_Form_Decorator_FormErrors
     */
    public function setErrorEndMarkup($errorEndMarkup)
    {
        $this->removeOption("errorEndMarkup");
        $this->_errorEndMarkup = $errorEndMarkup;
        return $this;
    }

    /**
     * Set the markup for the start of an error
     *
     * @param string $errorStartMarkup
     * @return Bear_Form_Decorator_FormErrors
     */
    public function setErrorStartMarkup($errorStartMarkup)
    {
        $this->removeOption("errorStartMarkup");
        $this->_errorStartMarkup = $errorStartMarkup;
        return $this;
    }

    /**
     * Set the markup for the end of an item
     *
     * @param string $itemEndMarkup
     * @return Bear_Form_Decorator_FormErrors
     */
    public function setItemEndMarkup($itemEndMarkup)
    {
        $this->removeOption("itemEndMarkup");
        $this->_itemEndMarkup = $itemEndMarkup;
        return $this;
    }

    /**
     * Set the markup for the start of a list
     *
     * @param string $itemStartMarkup
     * @return Bear_Form_Decorator_FormErrors
     */
    public function setItemStartMarkup($itemStartMarkup)
    {
        $this->removeOption("itemStartMarkup");
        $this->_itemStartMarkup = $itemStartMarkup;
        return $this;
    }

    /**
     * Set the markup for the end of a list
     *
     * @param string $listEndMarkup
     * @return Bear_Form_Decorator_FormErrors
     */
    public function setListEndMarkup($listEndMarkup)
    {
        $this->removeOption("listEndMarkup");
        $this->_listEndMarkup = $listEndMarkup;
        return $this;
    }

    /**
     * Set the markup for the start of a list
     *
     * @param string $listStartMarkup
     * @return Bear_Form_Decorator_FormErrors
     */
    public function setListStartMarkup($listStartMarkup)
    {
        $this->removeOption("listStartMarkup");
        $this->_listStartMarkup = $listStartMarkup;
        return $this;
    }

    /**
     * Set the markup for the end of a subform
     *
     * @param string $subformEndMarkup
     * @return Bear_Form_Decorator_FormErrors
     */
    public function setSubformEndMarkup($subformEndMarkup)
    {
        $this->removeOption("subformEndMarkup");
        $this->_subformEndMarkup = $subformEndMarkup;
        return $this;
    }

    /**
     * Set the markup for the start of a subform
     *
     * @param string $subformStartMarkup
     * @return Bear_Form_Decorator_FormErrors
     */
    public function setSubformStartMarkup($subformStartMarkup)
    {
        $this->removeOption("subformStartMarkup");
        $this->_subformStartMarkup = $subformStartMarkup;
        return $this;
    }

    /**
     * Recurse the form, building the error markup
     *
     * @param Zend_Form $form
     * @return string
     */
    protected function _recurseForm(Zend_Form $form)
    {
        $markup = $this->_renderFormErrors($form);

        if ($markup && $this->getDisableSubFormNesting()) {
            $markup = $this->getListStartMarkup()
                    . $markup
                    . $this->getListEndMarkup();
        }

        return $markup;
    }

    /**
     * Render a forms errors
     *
     * @param Zend_Form $form
     * @return string
     */
    protected function _renderFormErrors(Zend_Form $form)
    {
        if (!$form->isErrors()) {
            return;
        }

        $markup = "";

        foreach ($form->getErrorMessages() as $errorMessage) {
            $markup .= $this->getItemStartMarkup()
                     . $this->getErrorStartMarkup()
                     . $this->_view->escape($errorMessage)
                     . $this->getErrorEndMarkup()
                     . $this->getItemEndMarkup();
        }

        foreach ($form as $element) {
            if ($element instanceof Zend_Form_DisplayGroup) {
                $markup .= $this->_renderDisplayGroupErrors($element);
            } elseif ($element instanceof Zend_Form_SubForm) {
                $markup .= $this->_renderSubFormErrors($element);
            } elseif ($element instanceof Zend_Form_Element) {
                $markup .= $this->_renderElementErrors($element);
            }
        }

        if ($markup && !$this->getDisableSubFormNesting()) {
            $markup = $this->getListStartMarkup()
                    . $markup
                    . $this->getListEndMarkup();
        }

        return $markup;
    }

    /**
     * Render a display groups errors
     *
     * @param Zend_Form_DisplayGroup $displayGroup
     * @return string
     */
    protected function _renderDisplayGroupErrors(Zend_Form_DisplayGroup $displayGroup)
    {
        $markup = "";

        foreach ($displayGroup as $element) {
            $markup .= $this->_renderElementErrors($element);
        }

        return $markup;
    }

    /**
     * Render an elements errors
     *
     * @param Zend_Form_Element $element
     * @return string
     */
    protected function _renderElementErrors(Zend_Form_Element $element)
    {
        if (!$element->hasErrors()) {
            return;
        }
        
        $label = $element->getLabel();
        if (empty($label)) {
            $label = $element->getName();
        }

        $markup = $this->getItemStartMarkup()
                . $this->getElementStartMarkup()
                . $this->_view->escape($label)
                . $this->getElementEndMarkup()
                . $this->getListStartMarkup();

        foreach ($element->getMessages() as $message) {
            $markup .= $this->getItemStartMarkup()
                     . $this->getErrorStartMarkup()
                     . $this->_view->escape($message)
                     . $this->getErrorEndMarkup()
                     . $this->getItemEndMarkup();
        }

        $markup .= $this->getListEndMarkup()
                 . $this->getItemEndMarkup();

        return $markup;
    }

    /**
     * Render a subforms errors
     *
     * @param Zend_Form $subForm
     * @return string
     */
    protected function _renderSubFormErrors(Zend_Form $subForm)
    {
        if (!$subForm->isErrors()) {
            return "";
        }

        $markup = $this->_renderFormErrors($subForm);

        if (!$this->getDisableSubFormNesting()) {
            $markup = $this->getItemStartMarkup()
                    . $this->getSubformStartMarkup()
                    . $this->_view->escape($subForm->getLegend())
                    . $this->getSubformEndMarkup()
                    . $markup
                    . $this->getItemEndMarkup();
        }

        return $markup;
    }

}
