<?php
/**
 * BEAR
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Application
 * @since 1.1.0
 */

/** Zend_Application_Resource_ResourceAbstract */
require_once "Zend/Application/Resource/ResourceAbstract.php";

/**
 * Email transport resource class
 *
 * @category Bear
 * @deprecated
 * @package Bear_Application
 */
class Bear_Application_Resource_Emailtransport extends Zend_Application_Resource_ResourceAbstract
{

    /**
     * Transport adapter
     * @var string
     */
    protected $_adapter;

    /**
     * Plugin loader
     * @var Zend_Loader_PluginLoader
     */
    protected $_pluginLoader;

    /**
     * Initialize resource
     *
     * @return mixed
     */
    public function init()
    {
        $classname = $this->getPluginLoader()->load($this->_adapter);
        $resource  = new $classname($this->getOptions());
        return $resource->init();
    }

    /**
     * Get the plugin loader
     *
     * @return Zend_Loader_PluginLoader
     */
    public function getPluginLoader()
    {
        if (!$this->_pluginLoader) {
            /** Zend_Loader_PluginLoader */
            require_once "Zend/Loader/PluginLoader.php";

            $this->_pluginLoader = new Zend_Loader_PluginLoader(array(
                "Bear_Application_Resource_Emailtransport_" => "Bear/Application/Resource/Emailtransport/"
            ));
        }

        return $this->_pluginLoader;
    }

    /**
     * Set the adapter
     *
     * @param string $adapter
     * @return Bear_Application_Resource_Emailtransport
     */
    public function setAdapter($adapter)
    {
        $this->_adapter = $adapter;

        return $this;
    }

    /**
     * Set the adapter prefix paths
     *
     * @param array $prefixPaths
     * @return Bear_Application_Resource_Emailtransport
     */
    public function setPrefixPaths($prefixPaths)
    {
        foreach ($prefixPaths as $prefix => $path) {
            $this->getPluginLoader()
                 ->addPrefixPath($prefix, $path);
        }

        return $this;
    }

}