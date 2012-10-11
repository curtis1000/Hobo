<?php
/**
 * Bear
 */

/** Task */
require_once "phing/Task.php";

/** Properties */
include_once 'phing/system/util/Properties.php';

/**
 * Zend_Config parser into properties
 */
class Bear_Phing_Task_ZendConfigPropertiesTask extends Task
{
    
    /**
     * Application environment
     * @var string
     */
    protected $_applicationEnvironment;
    
    /**
     * PhingFile of the Zend_Config parsable file
     * @var PhingFile
     */
    protected $_file;
    
    /**
     * Prefix for all imported properties
     * @var string
     */
    protected $_prefix = "configuration";
    
    /**
     * Zend_Config type
     * @var string
     */
    protected $_type = "ini";
    
    /**
     * Get the application environment
     *
     * @return string
     */
    public function getApplicationEnvironment()
    {
        return $this->_applicationEnvironment;
    }

    /**
     * Get the configuration file
     *
     * @return PhingFile
     */
    public function getFile()
    {
        if (!$this->_file) {
            $this->_file = new PhingFile("application/configs/application.ini");
        }
        return $this->_file;
    }
    
    /**
     * Get the prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->_prefix;
    }
    
    /**
     * Get the configuration file type
     *
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Initialize the task
     */
    public function init()
    {
    }
    
    /**
     * Run the task
     * 
     * @throws BuildException
     */
    public function main()
    {
        if (!$this->getApplicationEnvironment()) {
            throw new BuildException("The application-environment attribute is required");
        }

        if (!$this->getFile()->exists()) {
            throw new BuildException("Configuration file does not exist");
        }
        
        switch (strtolower($this->_type)) {
            case "array":
                $this->log("Loading ". $this->getFile()->getAbsolutePath(), Project::MSG_INFO);
                
                /** Zend_Config */
                require_once "Zend/Config.php";
        
                $config = new Zend_Config(
                    file_get_contents($this->getFile()->getAbsolutePath()),
                    $this->getApplicationEnvironment()
                );
                break;
                
            case "xml":
                /** Zend_Config_Xml */
                require_once "Zend/Config/Xml.php";

                $config = new Zend_Config_Xml(
                    $this->getFile()->getAbsolutePath(),
                    $this->getApplicationEnvironment()
                );
                break;
                
            case "ini":
                /** Zend_Config_Ini */
                require_once "Zend/Config/Ini.php";

                $config = new Zend_Config_Ini(
                    $this->getFile()->getAbsolutePath(),
                    $this->getApplicationEnvironment()
                );
                break;
                
            default:
                throw new BuildException("Invalid configuration type");
        }

        $this->_loadConfiguration($config);
    }
    
    /**
     * Load the configuration into properties
     *
     * @param Zend_Config
     * @return Bear_Phing_Task_ZendConfigPropertiesTask
     */
    protected function _loadConfiguration(Zend_Config $config)
    {
        foreach ($this->_convertConfig($config->toArray(), $this->getPrefix()) as $name => $value) {
            $this->project->setProperty($name, $value);
        }
    }
    
    /**
     * Convert a config object to properties
     *
     * @param array $config
     * @param string $prefix
     * @return array
     */
    protected function _convertConfig(array $config, $prefix = null)
    {
        $results = array();

        foreach ($config as $currentKey => $currentValue) {
            if ($prefix) {
                $key = "{$prefix}.{$currentKey}";
            } else {
                $key = $currentKey;
            }
        
        
            if (is_array($currentValue)) {
                foreach ($this->_convertConfig($currentValue, $key) as $subKey => $subValue) {
                    $results[$subKey] = $subValue;
                }
            } else {
                $results[$key] = $currentValue;
            }
        }
        
        return $results;
    }
    
    /**
     * Set the application environment
     *
     * @param string $applicationEnv
     */
    public function setApplicationEnvironment($applicationEnvironment)
    {
        $this->_applicationEnvironment = $applicationEnvironment;
    }
    
    /**
     * Set the Zend_Config parsable file
     * 
     * @param string|PhingFile $file
     */
    public function setFile($file)
    {
        if (is_string($file)) {
            $file = new PhingFile($file);
        }
        $this->_file = $file;
    }
    
    /**
     * Set the prefix for all imported properties
     * 
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->_prefix = $prefix;
    }
    
    /**
     * Set the type of Zend_Config file
     * 
     * @param string $type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

}
