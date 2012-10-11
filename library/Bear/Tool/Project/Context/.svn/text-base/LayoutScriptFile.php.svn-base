<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Tool
 */

/**
 * Layout Script File Context
 *
 * @category Bear
 * @package Bear_Tool
 * @author Konr Ness <konr.ness@sierra-bravo.com>
 * @version $Id$
 */
class Bear_Tool_Project_Context_LayoutScriptFile extends Zend_Tool_Project_Context_Zf_LayoutScriptFile
{
    /**
     * Project namespace for autoloader namespace
     *
     * @var string
     */
    protected $_projectName = 'Project';
    
    /**
     * init()
     *
     * @return Zend_Tool_Project_Context_Zf_ApplicationConfigFile
     */
    public function init()
    {
        if ($this->_resource->hasAttribute('projectName')) {
            $this->_projectName = $this->_resource->getAttribute('projectName');
        }
        parent::init();
        return $this;
    }
    
    /**
     * Get default layout view contents
     *
     * @return string
     */
    public function getContents()
    {
        $contents = <<<EOS
<?php \$this->headScript()->captureStart(); ?>
var baseUrl = "<?php echo \$this->baseUrl(); ?>";
<?php \$this->headScript()->captureEnd(); ?>
<?php

\$this->headTitle()
     ->setSeparator(' - ')
     ->prepend('{$this->_projectName}');

\$this->headMeta()
     ->appendHttpEquiv("Content-Type", "text/html; charset=" . \$this->getEncoding());

\$this->headLink()
     ->prependStylesheet("{\$this->baseUrl()}/styles/global.css","all");

\$this->headScript()
     ->prependFile("//ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.js")
     ->appendFile("{\$this->baseUrl()}/js/global.js");

echo \$this->doctype();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

<?php echo \$this->headTitle(); ?>

<?php echo \$this->headMeta(); ?>

<?php echo \$this->headLink(); ?>

<?php echo \$this->headStyle(); ?>

<?php echo \$this->headScript(); ?>

    </head>
    <body>
        <?php echo \$this->flashMessages(); ?>
        <?php echo \$this->layout()->content; ?>
    </body>
</html>

EOS;

        return $contents;
    }

}
