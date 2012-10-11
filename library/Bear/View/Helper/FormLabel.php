<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_View
 */

/** Zend_View_Helper_FormLabel **/
require_once 'Zend/View/Helper/FormLabel.php';

/**
 * Overloaded form label helper that added label-[id] to the <label>
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_View
 */
class Bear_View_Helper_FormLabel extends Zend_View_Helper_FormLabel
{

    /**
     * Generates a 'label' element.
     *
     * @param  string $name The form element name for which the label is being generated
     * @param  string $value The label text
     * @param  array $attribs Form element attributes (used to determine if disabled)
     * @return string The element XHTML.
     */
    public function formLabel($name, $value = null, array $attribs = array())
    {
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, value, attribs, options, listsep, disable, escape

        // build the element
        if ($disable) {
            // disabled; display nothing
            return  '';
        }

        $value = ($escape) ? $this->view->escape($value) : $value;
        $for   = (empty($attribs['disableFor']) || !$attribs['disableFor'])
               ? ' for="' . $this->view->escape($id) . '"'
               : '';
        if (array_key_exists('disableFor', $attribs)) {
            unset($attribs['disableFor']);
        }

        // enabled; display label
        $xhtml = '<label'
                . ' id="label-' . $this->view->escape($id) . '"'
                . $for
                . $this->_htmlAttribs($attribs)
                . '>' . $value . '</label>';

        return $xhtml;
    }

}
