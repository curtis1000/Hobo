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
 * TinyMCE decorator
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Decorator_Tinymce extends Zend_Form_Decorator_Abstract
{

    /**
     * TinyMCE script path
     * @var string
     */
    private $_scriptPath;

    /**
     * Set the TinyMCE script path
     *
     * @param string $scriptPath
     * @return Bear_Form_Decorator_Tinymce
     */
    public function setScriptPath($scriptPath)
    {
        $this->_scriptPath = $scriptPath;
        return $this;
    }

    /**
     * Render the tinymce
     */
    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        $helper  = $view->tinymce();
        $options = $this->getOptions();

        if ($this->_scriptPath) {
            $helper->setScriptPath($this->_scriptPath);
        }

        $helper->tinymce(
            $element->getId(),
            $options
        );

        return $content;
    }

}