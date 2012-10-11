<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_View
 */

/** Zend_View_Helper_Abstract **/
require_once 'Zend/View/Helper/Abstract.php';

/**
 * FCKEditor helper
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_View
 */
class Bear_View_Helper_FckEditor extends Zend_View_Helper_Abstract
{

    /**
     * Base path
     * @var string
     */
    protected $_basePath;

    /**
     * Render the FCKeditor
     *
     * @param string $name
     * @return string
     */
    public function fckEditor($name, $value = null, $options = array())
    {
        $fckEditor = new FCKeditor($name);

        $fckEditor->BasePath = $this->_getBasePath() . "/fckeditor/";
        $fckEditor->Value    = $value;

        if (isset($options["height"])) {
            $fckEditor->Height = $options["height"];
            unset($options["height"]);
        }

        if (isset($options["toolbarSet"])) {
            $fckEditor->ToolbarSet = $options["toolbarSet"];
            unset($options["toolbarSet"]);
        }

        if (isset($options["width"])) {
            $fckEditor->Width = $options["width"];
            unset($options["width"]);
        }

        $fckEditor->Config = $options;

        return $fckEditor->Create();
    }

    /**
     * Set the base path
     *
     * @param string $basePath
     * @return Bear_View_Helper_FckEditor
     */
    public function setBasePath($basePath)
    {
        $this->_basePath = $basePath;
        return $this;
    }

    /**
     * Get the base path
     *
     * @return string
     */
    protected function _getBasePath()
    {
        if (!$this->_basePath) {
            $this->_basePath = Zend_Controller_Front::getInstance()
                                                    ->getRequest()
                                                    ->getBasePath();
        }

        return $this->_basePath;
    }

}