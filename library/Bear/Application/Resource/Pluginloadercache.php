<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Application
 */

/** Zend_Loader_PluginLoader */
require_once "Zend/Loader/PluginLoader.php";

/**
 * Application resource for the plugin loader cache
 *
 * @author Justin Hendrickson <justin.hendrickson@nerdery.com>
 * @category Bear
 * @package Bear_Application
 * @since 1.4.1
 */
class Bear_Application_Resource_Pluginloadercache extends Zend_Application_Resource_ResourceAbstract
{

    /**
     * Enabled flag
     * @var boolean
     */
    protected $_enabled = false;

    /**
     * Filename
     * @var string
     */
    protected $_filename;

    /**
     * Get the enabled flag
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->_enabled;
    }

    /**
     * Get the filename
     *
     * @return string
     * @throws UnexpectedValueException
     */
    public function getFilename()
    {
        if (!$this->_filename) {
            throw new UnexpectedValueException("Filename not set");
        }
        return $this->_filename;
    }

    /**
     * Initialize resource
     */
    public function init()
    {
        if ($this->getEnabled()) {
            Zend_Loader_PluginLoader::setIncludeFileCache($this->getFilename());
        }
    }

    /**
     * Set the enabled flag
     *
     * @param boolean $enabled
     * @return Bear_Application_Resource_PluginLoaderCache
     */
    public function setEnabled($enabled)
    {
        $this->_enabled = $enabled;
        return $this;
    }

    /**
     * Set the path to the cache file
     *
     * @param string $filename
     * @return Bear_Application_Resource_PluginLoaderCache
     */
    public function setFilename($filename)
    {
        $this->_filename = $filename;
        return $this;
    }

}
