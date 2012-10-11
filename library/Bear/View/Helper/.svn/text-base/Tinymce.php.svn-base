<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_View
 */

/** Zend_View_Helper_FormElement **/
require_once 'Zend/View/Helper/FormElement.php';

/**
 * TinyMCE helper
 *
 * Renders the tinymce.init() into the HeadScript container.
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_View
 */
class Bear_View_Helper_Tinymce extends Zend_View_Helper_Abstract
{

    /**
     * TinyMCE script path
     * @var string
     */
    private $_scriptPath;

    /**
     * Get the script path
     *
     * @return string
     */
    public function getScriptPath()
    {
        if (!$this->_scriptPath) {
            /** Zend_Controller_Front */
            require_once "Zend/Controller/Front.php";

            $this->_scriptPath = sprintf(
                "%s/scripts/tiny_mce/tiny_mce.js",
                Zend_Controller_Front::getInstance()
                                     ->getRequest()
                                     ->getBaseUrl()
            );
        }
        return $this->_scriptPath;
    }

    /**
     * Set the TinyMCE script path
     *
     * @param string $scriptPath
     * @return Project_View_Helper_Tinymce
     */
    public function setScriptPath($scriptPath)
    {
        $this->_scriptPath = $scriptPath;
        return $this;
    }

    /**
     * Render the TinyMCE javascript code
     *
     * @param array|string $elements
     * @param array $options
     * @return Project_View_Helper_Tinymce
     */
    public function tinymce($elements = null, $options = array())
    {
        if (!$elements) {
            return $this;
        }

        if (is_array($elements)) {
            $elements = implode(",", $elements);
        }

        $options["elements"] = $elements;
        $options["mode"]     = "exact";

        $headScript = $this->view->headScript();

        $headScript->appendFile($this->getScriptPath())
                   ->captureStart();
?>
tinyMCE.init(<?php echo Zend_Json::encode($options); ?>);
<?php
        $headScript->captureEnd();

        return $this;
    }

}