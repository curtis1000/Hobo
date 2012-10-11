<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_View
 */

/** Zend_View_Helper_HeadMeta **/
require_once 'Zend/View/Helper/HeadMeta.php';

/**
 * Allow for conditionals wrapped around meta properties
 * Allow for meta tags with property keys to work for all doctypes, not just RDFa
 *
 * @category Bear
 * @package Bear_View
 * @author Tony Nelson <tony.nelson@nerdery.com>
 */
class Bear_View_Helper_HeadMeta extends Zend_View_Helper_HeadMeta
{
    /**
     * Build meta HTML string
     *
     * @param stdClass $item
     * @return string
     */
    public function itemToString(stdClass $item)
    {
        if (!in_array($item->type, $this->_typeKeys)) {
            require_once 'Zend/View/Exception.php';
            $e = new Zend_View_Exception(sprintf('Invalid type "%s" provided for meta', $item->type));
            $e->setView($this->view);
            throw $e;
        }
        $type = $item->type;

        $modifiersString = '';
        foreach ($item->modifiers as $key => $value) {
            if (!is_null($this->view) && $this->view->doctype()->isHtml5()
                && $key == 'scheme') {
                require_once 'Zend/View/Exception.php';
                throw new Zend_View_Exception('Invalid modifier '
                    . '"scheme" provided; not supported by HTML5');
            }
            if (!in_array($key, $this->_modifierKeys)) {
                continue;
            }
            $modifiersString .= $key . '="' . $this->_escape($value) . '" ';
        }

        if ($this->view instanceof Zend_View_Abstract) {
            if ($this->view->doctype()->isHtml5()
                && $type == 'charset') {
                $tpl = ($this->view->doctype()->isXhtml())
                    ? '<meta %s="%s"/>'
                    : '<meta %s="%s">';
            } elseif ($this->view->doctype()->isXhtml()) {
                $tpl = '<meta %s="%s" content="%s" %s/>';
            } else {
                $tpl = '<meta %s="%s" content="%s" %s>';
            }
        } else {
            $tpl = '<meta %s="%s" content="%s" %s/>';
        }

        $meta = sprintf(
            $tpl,
            $type,
            $this->_escape($item->$type),
            $this->_escape($item->content),
            $modifiersString
        );

        if (isset($item->modifiers['conditional'])
            && !empty($item->modifiers['conditional'])
            && is_string($item->modifiers['conditional']))
        {
            $meta = '<!--[if ' . $this->_escape($item->modifiers['conditional']) . ']>' . $meta . '<![endif]-->';
        }

        return $meta;
    }

    /**
     * Determine if item is valid
     *
     * @param  mixed $item
     * @return boolean
     */
    protected function _isValid($item)
    {
        if ((!$item instanceof stdClass)
            || !isset($item->type)
            || !isset($item->modifiers))
        {
            return false;
        }

        return true;
    }
}