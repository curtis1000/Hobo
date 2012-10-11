<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Pick
 */

/** Bear_Base_Interface */
require_once "Bear/Base/Interface.php";

/**
 * Pick server class
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Pick
 * @since 2.0.0
 * @todo Use @ & $php_trackerr for better error handling?
 */
class Bear_Pick implements Bear_Base_Interface
{

    /**
     * Default connection timeout
     * @var integer
     */
    const DEFAULT_CONNECTION_TIMEOUT = 10;

    /**
     * Default read/write timeout
     * @var integer
     */
    const DEFAULT_READ_WRITE_TIMEOUT = 30;

    /**
     * Default Pick port
     * @var integer
     */
    const DEFAULT_PORT = 8787;

    /**
     * Result class file
     * @var string
     */
    protected $_resultClassFile = "Bear/Pick/Result.php";

    /**
     * Result classname
     * @var string
     */
    protected $_resultClassName = 'Bear_Pick_Result';

    /**
     * Connection resource
     * @var resource
     */
    private $_connection;

    /**
     * Connection timeout
     * @var integer
     */
    private $_connectionTimeout = self::DEFAULT_CONNECTION_TIMEOUT;

    /**
     * Pick server host
     * @var     string
     */
    private $_host;

    /**
     * Pick server port
     * @var     integer
     */
    private $_port = self::DEFAULT_PORT;

    /**
     * Read/write timeout
     * @var integer
     */
    private $_readWriteTimeout = self::DEFAULT_READ_WRITE_TIMEOUT;

    /**
     * Options
     * @var array
     */
    private $_resultOptions;

    /**
     * Constructor
     *
     * @param Zend_Config|string $host
     * @param Zend_Config|array $options
     * @throws Bear_Exception_Pick_Configuration
     */
    public function __construct($host, $options = null)
    {
        if ($host instanceof Zend_Config) {
            $config = $host;

            $host    = $config->host;
            $options = $config->options;
        }

        $this->setHost($host);

        if ($options instanceof Zend_Config) {
            $this->setConfig($options);
        } elseif (is_array($options)) {
            $this->setOptions($options);
        }

        $this->_init();
    }

    /**
     * Execute the request and get a result class
     *
     * @return Bear_Pick_Result_Interface
     * @throws Bear_Pick_Exception_Connect
     */
    public function execute()
    {
        $classname = $this->_loadResultClass();

        $result = new $classname(
            $this->getConnection(),
            $this->getResultOptions()
        );

        return $result;
    }

    /**
     * Get the connection resource
     *
     * @return resource
     */
    public function getConnection()
    {
        if (!$this->_connection) {
            $this->_connection = @fsockopen(
                $this->getHost(),
                $this->getPort(),
                $errno,
                $errstr,
                $this->getConnectionTimeout()
            );

            if (!$this->_connection) {
                /** Bear_Pick_Exception_Connect */
                require_once 'Bear/Pick/Exception/Connect.php';
                throw new Bear_Pick_Exception_Connect(
                    "'{$errstr}' ({$errno}) when trying to connect to {$this->getHost()}:{$this->getPort()}"
                );
            }

            stream_set_timeout($this->_connection, $this->getReadWriteTimeout());
        }
        return $this->_connection;
    }

    /**
     * Get the connection timeout
     *
     * @return integer
     */
    public function getConnectionTimeout()
    {
        return $this->_connectionTimeout;
    }

    /**
     * Get the Pick hostname
     *
     * @return string
     */
    public function getHost()
    {
        return $this->_host;
    }

    /**
     * Get the read/write timeout
     *
     * @return integer
     */
    public function getReadWriteTimeout()
    {
        return $this->_readWriteTimeout;
    }

    /**
     * Get result options
     *
     * @return array
     */
    public function getResultOptions()
    {
        return $this->_resultOptions;
    }

    /**
     * Get the Pick port
     *
     * @return integer
     */
    public function getPort()
    {
        return $this->_port;
    }

    /**
     * Setup the object from an Zend_Config object
     *
     * @param Zend_Config $config
     * @return Bear_Pick
     */
    public function setConfig(Zend_Config $config)
    {
        return $this->setOptions($config->toArray());
    }

    /**
     * Set the connection resource
     *
     * @param resource $connection
     * @return Bear_Pick
     */
    public function setConnection($connection)
    {
        $this->_connection = $connection;
        return $this;
    }

    /**
     * Set the connection timeout
     *
     * @param integer $connectionTimeout
     * @return Bear_Pick
     */
    public function setConnectionTimeout($connectionTimeout)
    {
        $this->_connectionTimeout = $connectionTimeout;
        return $this;
    }

    /**
     * Set the Pick hostname
     *
     * @param string $host
     * @return Bear_Pick
     */
    public function setHost($host)
    {
        $this->_host = $host;
        return $this;
    }

    /**
     * Setup the object from an array
     *
     * @param array $options
     * @return Bear_Pick
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            } else {
                $this->setResultOption($key, $value);
            }
        }
        return $this;
    }

    /**
     * Set the read/write timeout
     *
     * @param integer $timeout
     * @return Bear_Pick
     */
    public function setReadWriteTimeout($timeout)
    {
        $this->_readWriteTimeout = $timeout;
        return $this;
    }

    /**
     * Set the result class
     *
     * @param array|string $classname
     * @param string $filename
     * @return Bear_Pick
     */
    public function setResultClass($classname, $filename)
    {
        if (is_array($classname)) {
            $this->resultClassName = $classname['classname'];
            $this->resultClassFile = $classname['filename'];
        } else {
            $this->_resultClassName = $classname;
            $this->_resultClassFile = $filename;
        }
        return $this;
    }

    /**
     * Set options
     *
     * @param string $key
     * @param string $value
     * @return Bear_Pick
     */
    public function setResultOption($key, $value)
    {
        $this->_resultOptions[$key] = $value;
        return $this;
    }

    /**
     * Set the Pick port
     *
     * @param integer $port
     * @return Bear_Pick
     */
    public function setPort($port)
    {
        $this->_port = $port;
        return $this;
    }

    /**
     * Initialize method
     *
     * This method is called at the end of the constructor.
     */
    protected function _init()
    {
    }

    /**
     * Load the result class
     *
     * @return string
     */
    protected function _loadResultClass()
    {
        require_once $this->_resultClassFile;
        return $this->_resultClassName;
    }

}
