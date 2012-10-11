<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_Decorator_ViewScript */
require_once 'Zend/Form/Decorator/ViewScript.php';

/**
 * Extension of the default ViewScript that supports modules
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Decorator_ViewScript extends Zend_Form_Decorator_ViewScript
{

    /**
     * View script module
     * @var string
     */
    protected $_viewModule;

    /**
     * Set view script module
     *
     * @param  string $module
     * @return Zend_Form_Decorator_ViewScript
     */
    public function setViewModule($viewModule)
    {
        $this->_viewModule = (string) $viewModule;
        return $this;
    }

    /**
     * Get view script module
     *
     * @return string|null
     */
    public function getViewModule()
    {
        if (null === $this->_viewModule) {
            if (null !== ($element = $this->getElement())) {
                if (null !== ($viewModule = $element->getAttrib('viewModule'))) {
                    $this->setViewModule($viewModule);
                    return $viewModule;
                }
            }

            if (null !== ($viewModule = $this->getOption('viewModule'))) {
                $this->setViewModule($viewModule)
                     ->removeOption('viewModule');
            }
        }

        return $this->_viewModule;
    }

    /**
     * Render a view script
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

        $viewScript = $this->getViewScript();
        if (empty($viewScript)) {
            require_once 'Zend/Form/Exception.php';
            throw new Zend_Form_Exception('No view script registered with ViewScript decorator');
        }

        $separator = $this->getSeparator();
        $placement = $this->getPlacement();

        $vars              = $this->getOptions();
        $vars['element']   = $element;
        $vars['content']   = $content;
        $vars['decorator'] = $this;

        $viewModule = $this->getViewModule();
        if (empty($viewModule)) {
            $renderedContent = $view->partial($viewScript, $vars);
        } else {
            $renderedContent = $view->partial($viewScript, $viewModule, $vars);
        }
        
        // Get placement again to see if it has changed
        $placement = $this->getPlacement();

        switch ($placement) {
            case self::PREPEND:
                return $renderedContent . $separator . $content;
            case self::APPEND:
                return $content . $separator . $renderedContent;
            default:
                return $renderedContent;
        }
    }
}
