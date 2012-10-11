<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Pick
 */

/** Bear_Pick_Result_Interface */
require_once "Bear/Pick/Result/Interface.php";

/**
 * Pick result class
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Pick
 * @since 2.0.0
 * @todo Use @ & $php_trackerr for better error handling
 */
class Bear_Pick_Result implements Bear_Pick_Result_Interface, SplSubject
{

    /**#@+
     * Last read modes
     * @var string
     */
    const MODE_READ  = "read";
    const MODE_WRITE = "write";
    /**#@-*/

    /**
     * Pick server account
     * @var string
     */
    private $_account;

    /**
     * Internal buffer
     * @var string
     */
    private $_buffer = "";

    /**
     * Pick connection
     * @var resource
     */
    private $_connection;

    /**
     * Is this the first line
     * @var boolean
     */
    private $_firstLine = true;

    /**
     * Has a handshake taken place
     * @var boolean
     */
    private $_handshakeComplete = false;

    /**
     * Observers
     * @var array
     */
    private $_observers = array();

    /**
     * Pick account program
     * @var string
     */
    private $_program;

    /**
     * Pick program query
     * @var string
     */
    private $_query;

    /**
     * Constructor
     *
     * @param resource $connection
     * @param Zend_Config|array $options
     * @throws Bear_Exception_Pick_Configuration
     * @throws Bear_Pick_Exception_Read
     * @throws Bear_Pick_Exception_Write
     */
    public function __construct($connection, $options = null)
    {
        $this->_connection = $connection;

        if ($options instanceof Zend_Config) {
            $this->setConfig($options);
        } elseif (is_array($options)) {
            $this->setOptions($options);
        }

        if (isset($options["observer"])) {
            if (is_array($options["observer"]) || $options["observer"] instanceof Traversable) {
                foreach ($options["observer"] as &$observer) {
                    $this->attach($observer);
                }
            } else {
                $this->attach($options["observer"]);
            }
        }

        $this->_init();
    }

    /**
     * Attach an observer
     *
     * @param SplObserver $observer
     */
    public function attach(SplObserver $observer)
    {
        $this->_observers[] = $observer;
    }

    /**
     * Detach an observer
     *
     * @param SplObserver $observer
     */
    public function detach(SplObserver $observer)
    {
        $key = array_search($observer, $this->_observers);
        if ($key != -1) {
            unset($this->_observers[$key]);
        }
    }

    /**
     * Get the account
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->_account;
    }

    /**
     * Get the connection resource
     *
     * @return resource
     */
    public function getConnection()
    {
        return $this->_connection;
    }

    /**
     * Get the last action
     *
     * @return array
     */
    public function getLastAction()
    {
        return $this->_lastAction;
    }

    /**
     * Get the program
     *
     * @return string
     */
    public function getProgram()
    {
        return $this->_program;
    }

    /**
     * Get the query
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->_query;
    }

    /**
     * Check if the end of the stream has been reached
     *
     * @return boolean
     */
    public function isEndOfFile()
    {
        return feof($this->getConnection()) && strlen($this->_buffer) == 0;
    }

    /**
     * Notify observers of an update
     */
    public function notify()
    {
        foreach ($this->_observers as &$observer) {
            $observer->update($this);
        }
    }

    /**
     * Read the next chunk from the connection
     *
     * The response is read, one ahead, and the completion footer is stripped
     * from the end of the response.
     *
     * @param integer $length
     * @return string
     * @throws Bear_Pick_Exception_Error
     * @throws Bear_Pick_Exception_Read
     * @todo Expand the handling of 500 errors
     */
    public function read($length = 8192)
    {
        $this->_handshake();
        while (!feof($this->getConnection())) {
            $line = $this->_readLine();

            if ($this->_firstLine) {
                $this->_firstLine = false;
                if (preg_match("#^500 (\d*) (.*)$#", $line, $matches)) {
                    /** Bear_Pick_Exception_Error */
                    require_once "Bear/Pick/Exception/Error.php";
                    throw new Bear_Pick_Exception_Error($matches[2], $matches[1]);
                }
            }

            if (preg_match("#^600 Request Complete\s*$#m", $line)) {
                // Strip trailing whitespace after the request is complete
                $this->_buffer = rtrim($this->_buffer, "\r\n");

                // Flush the rest of the stream
                while (!feof($this->getConnection())) {
                    $this->_readLine();
                }
            } else {
                $this->_buffer .= $line;
            }
        }

        $read          = substr($this->_buffer, 0, $length);
        $this->_buffer = substr($this->_buffer, $length);

        return $read;
    }

    /**
     * Read the entire response
     *
     * @return string
     * @throws Bear_Pick_Exception_Read
     */
    public function readAll()
    {
        $buffer = "";
        while (!$this->isEndOfFile()) {
            $buffer .= $this->read();
        }
        return $buffer;
    }

    /**
     * Set the account
     *
     * @param string $account
     * @return Bear_Pick_Result
     */
    public function setAccount($account)
    {
        $this->_account = $account;
        return $this;
    }

    /**
     * Set options from a Zend_Config object
     *
     * @param Zend_Config $config
     * @return Bear_Pick_Result
     */
    public function setConfig(Zend_Config $config)
    {
        return $this->setOptions($config->toArray());
    }

    /**
     * Set options from an array
     *
     * @param array $options
     * @return Bear_Pick_Result
     */
    public function setOptions($options)
    {
        foreach ($options as $key => $value) {
            $method = "set" . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    /**
     * Set the program
     *
     * @param string $program
     * @return Bear_Pick_Result
     */
    public function setProgram($program)
    {
        $this->_program = $program;
        return $this;
    }

    /**
     * Set the query
     *
     * @param array|string $query
     * @return Bear_Pick_Result
     */
    public function setQuery($query)
    {
        if (is_array($query)) {
            foreach ($query as $item) {
                if (is_array($item)) {
                    /** Bear_Pick_Exception_Configuration */
                    require_once "Bear/Pick/Exception/Configuration.php";
                    throw new Bear_Pick_Exception_Configuration(
                        "Pick does not accept nested arrays"
                    );
                }
            }
            $query = http_build_query($query);
        }

        $this->_query = $query;
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
     * Ensure an expected result is returned
     *
     * @param integer $code
     * @throws Bear_Pick_Exception_Read
     * @throws Bear_Pick_Exception_Write
     */
    private function _expect($code)
    {
        preg_match("#^(\d*?)\s(.*)$#", $this->_readLine(), $matches);

        if (count($matches) < 2) {
            /** Bear_Pick_Exception_Write */
            require_once "Bear/Pick/Exception/Write.php";
            throw new Bear_Pick_Exception_Write("");
        }

        if ($matches[1] != $code) {
            /** Bear_Pick_Exception_Write */
            require_once "Bear/Pick/Exception/Write.php";
            throw new Bear_Pick_Exception_Write($matches[2]);
        }
    }

    /**
     * Handshake with the Pick DB server
     *
     * @return Bear_Pick_Result
     * @throws Bear_Pick_Exception_Read
     * @throws Bear_Pick_Exception_Write
     */
    private function _handshake()
    {
        if (!$this->_handshakeComplete) {
            try {
                $this->_expect(200);
                $this->_sendProgramRequest();
                $this->_expect(400);
            } catch (Bear_Pick_Exception $e) {
                /** Bear_Pick_Exception_Handshake */
                require_once "Bear/Pick/Exception/Handshake.php";

                throw new Bear_Pick_Exception_Handshake($e);
            }

            $this->_handshakeComplete = true;
        }

        return $this;
    }

    /**
     * Read the next line from the connection
     *
     * @return string
     * @throws Bear_Pick_Exception_Read
     * @throws Bear_Pick_Exception_Write
     */
    private function _readLine()
    {
        $line = fgets($this->getConnection());

        $this->_lastAction = array(
            self::MODE_READ,
            trim($line)
        );

        $this->notify();

        return $line;
    }

    /**
     * Write a line to the connection
     *
     * @param string $line
     * @throws Bear_Pick_Exception_Read
     * @throws Bear_Pick_Exception_Write
     */
    private function _writeLine($line)
    {
        $this->_lastAction = array(
            self::MODE_WRITE,
            trim($line)
        );

        $this->notify();

        if (!fwrite($this->getConnection(), "{$line}\n")) {
            /** Bear_Pick_Exception_Write */
            require_once "Bear/Pick/Exception/Write.php";
            throw new Bear_Pick_Exception_Write("Could not write query to the connection");
        }
    }

    /**
     * Send the program request
     *
     * @throws Bear_Pick_Exception_Read
     * @throws Bear_Pick_Exception_Write
     */
    private function _sendProgramRequest()
    {
        $message = sprintf(
            "%s %s %s",
            $this->getAccount(),
            $this->getProgram(),
            strlen($this->getQuery())
        );

        $this->_writeLine($message);
        if ($this->getQuery()) {
            $this->_expect(300);
            $this->_writeLine($this->getQuery());
        }
    }

}
