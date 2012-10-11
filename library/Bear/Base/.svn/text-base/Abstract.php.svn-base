<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Base
 * @since 1.1.0
 */

/** Bear_Base_Interface */
require_once "Bear/Base/Interface.php";

/**
 * Bear base class
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Base
 */
abstract class Bear_Base_Abstract implements Bear_Base_Interface
{

    /**
     * Additional options
     * @var array
     */
    protected $_options = array();

    /**
     * Constructor
     *
     * @param array|Zend_Config $options
     */
    public function __construct($options = null)
    {
        if ($options instanceof Zend_Config) {
            $this->setConfig($options);
        } elseif (is_array($options)) {
            $this->setOptions($options);
        }

        $this->init();
    }

    /**
     * Set the options from a Zend_Config object
     *
     * @param Zend_Config $config
     * @return Bear_Base_Abstract
     */
    public function setConfig(Zend_Config $config)
    {
        return $this->setOptions($config->toArray());
    }

    /**
     * Set the options from an array
     *
     * @param array $options
     * @return Bear_Base_Abstract
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $method = "set" . ucFirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            } else {
                $this->_options[$key] = $value;
            }
        }
        return $this;
    }

    /**
     * Initialize the object
     */
    public function init()
    {
    }

}
