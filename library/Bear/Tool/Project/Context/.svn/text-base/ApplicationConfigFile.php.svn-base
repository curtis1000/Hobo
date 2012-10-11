<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Tool
 */

/**
 * Application Config File Context
 *
 * @category Bear
 * @package Bear_Tool
 * @author Konr Ness <konr.ness@sierra-bravo.com>
 * @version $Id$
 */
class Bear_Tool_Project_Context_ApplicationConfigFile 
    extends Zend_Tool_Project_Context_Zf_ApplicationConfigFile
{

    /**
     * Project namespace for autoloader namespace
     *
     * @var string
     */
    protected $_projectNamespace = 'Project';
    
    /**
     * init()
     *
     * @return Zend_Tool_Project_Context_Zf_ApplicationConfigFile
     */
    public function init()
    {
        if ($this->_resource->hasAttribute('projectNamespace')) {
            $this->_projectNamespace = $this->_resource->getAttribute('projectNamespace');
        }
        parent::init();
        return $this;
    }

    /**
     * Get config as zend config
     *
     * @param string $section
     * @return Zend_Config
     */
    public function getAsZendConfig($section = 'base')
    {
        if ($section == 'production') {
            $section = 'base';
        }
        
        // rewrite default of $section from production to base
        return parent::getAsZendConfig($section);
    }
    
    /**
     * addStringItem()
     * 
     * @param string $key 
     * @param string $value
     * @param string $section
     * @param bool   $quoteValue
     * @return Zend_Tool_Project_Context_Zf_ApplicationConfigFile
     */
    public function addStringItem($key, $value, $section = 'base', $quoteValue = true)
    {
        if ($section == 'production') {
            $section = 'base';
        }
        
        // rewrite default of $section from production to base
        parent::addStringItem($key, $value, $section, $quoteValue);
        return $this;
    }
    
    /**
     * addItem()
     * 
     * @param array $item
     * @param string $section
     * @param bool $quoteValue
     * @return Zend_Tool_Project_Context_Zf_ApplicationConfigFile
     */
    public function addItem($item, $section = 'base', $quoteValue = true)
    {
        if ($section == 'production') {
            $section = 'base';
        }
        
        // rewrite default of $section from production to base
        parent::addItem($item, $section, $quoteValue);
        return $this;
    }
    
    /**
     * removeStringItem()
     *
     * @param string $key
     * @param string $section
     * @return void
     */
    public function removeStringItem($key, $section = 'base')
    {
        if ($section == 'production') {
            $section = 'base';
        }
        
        // rewrite default of $section from production to base
        parent::removeStringItem($key, $section);
    }
    
    /**
     * removeItem()
     *
     * @param string $item
     * @param string $section
     * @return Bear_Tool_Project_Context_ApplicationConfigFile
     */
    public function removeItem($item, $section = 'base')
    {
        if ($section == 'production') {
            $section = 'base';
        }
        
        // rewrite default of $section from production to base
        parent::removeItem($item, $section);
                
        return $this;
    }
    
    /**
     * Get default application config file contents
     *
     * @return string
     */
    protected function _getDefaultContents()
    {
        $contents =<<<EOS
[base]

includePaths.library = APPLICATION_PATH "/../library"
appnamespace = "Application"
autoloaderNamespaces[] = Bear_
autoloaderNamespaces[] = {$this->_projectNamespace}_

; PHP Settings
phpSettings.display_startup_errors = 0
phpSettings.display_errors         = 0
phpSettings.error_reporting        = 2147483647
phpSettings.log_errors             = 1
phpSettings.error_log              = APPLICATION_PATH "/../data/logs/phperrors.log"

; Bootstrap
bootstrap.path  = APPLICATION_PATH "/Bootstrap.php"
bootstrap.class = "Bootstrap"

; Resources
resources.frontController.controllerDirectory.default = APPLICATION_PATH "/controllers"
resources.frontController.actionHelperPaths.Bear_Controller_Action_Helper    = "Bear/Controller/Action/Helper"
resources.frontController.actionHelperPaths.{$this->_projectNamespace}_Controller_Action_Helper = "{$this->_projectNamespace}/Controller/Action/Helper"

resources.view.encoding = "UTF-8"
resources.view.doctype  = XHTML1_TRANSITIONAL
resources.view.helperPath.Bear_View_Helper_ = "Bear/View/Helper/"
resources.view.helperPath.{$this->_projectNamespace}_View_Helper_ = "{$this->_projectNamespace}/View/Helper/"

resources.layout.layoutPath = APPLICATION_PATH "/layouts/scripts/"

; Mail
resources.mail.transport.type       = smtp
resources.mail.transport.host       = "localhost"
resources.mail.defaultFrom.email    = no-reply@example.com 
resources.mail.defaultFrom.name     = "Example"
resources.mail.defaultReplyTo.email = no-reply@example.com
resources.mail.defaultReplyTo.name  = "Example"

; Application Log
resources.log.stream.writerName          = "Stream"
resources.log.stream.writerParams.stream = APPLICATION_PATH "/../data/logs/application.log"
resources.log.stream.writerParams.mode   = "a"


[production : base]

phpSettings.display_startup_errors = 0
phpSettings.display_errors         = 0
resources.frontController.params.displayExceptions = 0

[staging : base]

phpSettings.display_startup_errors = 0
phpSettings.display_errors         = 0
resources.frontController.params.displayExceptions = 0

[testing : base]

phpSettings.display_startup_errors = 1
phpSettings.display_errors         = 1
resources.frontController.params.displayExceptions = 1

[development : base]

phpSettings.display_startup_errors = 1
phpSettings.display_errors         = 1
resources.frontController.params.displayExceptions = 1

resources.log.firebug.writerName = "Firebug"

resources.db.adapter                 = "pdo_mysql"
resources.db.params.host             = "localhost"
resources.db.params.username         = "admin"
resources.db.params.password         = "skyd1ve"
resources.db.params.dbname           = ""
resources.db.params.profiler.enabled = true
resources.db.params.profiler.class   = "Zend_Db_Profiler_Firebug"

EOS;

        return $contents;
    }
    
}
