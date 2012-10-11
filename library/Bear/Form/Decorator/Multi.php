<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_Decorator_ViewHelper */
require_once "Zend/Form/Decorator/ViewHelper.php";

/**
 * Multi-element decorator
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Decorator_Multi extends Zend_Form_Decorator_ViewHelper
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
        $attribs = parent::getElementAttribs();
        $attribs["listsep"] = "</li>\r\n<li>";
        return $attribs;
    }

    /**
     * Render the view helpers with list info surrounding it
     *
     * @param string $content
     * @return string
     */
    public function render($content)
    {
        $content = parent::render($content);

        if ($this->getElement()->options) {
            $content = "<ol><li>{$content}</li></ol>";
        }

        return $content;
    }

}
