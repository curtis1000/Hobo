<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Pick
 */

/** Zend_Uri  */
require_once "Zend/Uri.php";

/**
 * Pick URI class
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Pick
 * @since 2.0.0
 */
class Bear_Pick_Uri extends Zend_Uri
{

    /**
     * Account
     * @var string
     */
    protected $_account;

    /**
     * Host
     * @var string
     */
    protected $_host;

    /**
     * Post
     * @var string
     */
    protected $_port = 8787;

    /**
     * Program (API)
     * @var string
     */
    protected $_program;

    /**
     * Query parameters
     * @var array
     */
    protected $_query = array();

    /**
     * Schema
     * @var string
     */
    protected $_scheme;

    /**
     * Creates a Bear_Uri_Pick from the given parts
     *
     * @param string $scheme
     * @param string $host
     * @param integer $port
     * @param string $account
     * @param string $program
     * @param mixed $query
     * @return Bear_Pick_Uri
     */
    public static function fromParts($scheme, $host, $port, $account, $program,
        $query = null
    )
    {
        if (is_array($query)) {
            $query = http_build_query($query);
        }

        $uri = sprintf(
            "%s://%s:%s/%s/%s",
            $scheme,
            $host,
            $port,
            $account,
            $program
        );

        if ($query) {
            $uri .= "?{$query}";
        }

        return self::fromString($uri);
    }

    /**
     * Creates a Bear_Uri_Pick from the given string
     *
     * @param  string $uri String to create URI from, must start with "pick://"
     *                     or "pick2://"
     * @throws InvalidArgumentException  When the given $uri is not a string or
     *                                   does not start with pick:// or pick2://
     * @throws Zend_Uri_Exception        When the given $uri is invalid
     * @return Bear_Pick_Uri
     */
    public static function fromString($uri)
    {
        if (is_string($uri) === false) {
            throw new InvalidArgumentException("$uri is not a string");
        }

        $uri            = explode(":", $uri, 2);
        $scheme         = strtolower($uri[0]);
        $schemeSpecific = isset($uri[1]) === true ? $uri[1] : "";

        if (in_array($scheme, array("pick", "pick2")) === false) {
            /** Zend_Uri_Exception */
            require_once "Zend/Uri/Exception.php";

            throw new Zend_Uri_Exception("Invalid scheme: '{$scheme}'");
        }

        $schemeHandler = new self($scheme, $schemeSpecific);
        return $schemeHandler;
    }

    /**
     * Zend_Uri and its subclasses cannot be instantiated directly.
     * Use Zend_Uri::factory() to return a new Zend_Uri object.
     *
     * @param string $scheme         The scheme of the URI
     * @param string $schemeSpecific The scheme-specific part of the URI
     */
    protected function __construct($scheme, $schemeSpecific = "")
    {
        $this->_scheme = $scheme;

        $url = "{$scheme}:{$schemeSpecific}";

        $parsed = parse_url($url);
        if (!$parsed) {
            /** Zend_Uri_Exception */
            require_once "Zend/Uri/Exception.php";

            throw new Zend_Uri_Exception(
                "Internal error: scheme-specific decomposition failed"
            );
        }

        if (isset($parsed["host"])) {
            $this->setHost($parsed["host"]);
        }

        if (isset($parsed["port"])) {
            $this->setPort($parsed["port"]);
        }

        if (isset($parsed["path"])) {
            $path = trim($parsed["path"], "/");
            if (preg_match("#^(.*?)/(.*)$#", $path, $matches)) {
                $this->setAccount($matches[1])
                     ->setProgram($matches[2]);
            }
        }

        if (isset($parsed["query"])) {
            parse_str($parsed["query"], $query);
            $this->setQuery($query);
        }
    }

    /**
     * Returns the Pick account.
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->_account;
    }

    /**
     * Returns the domain or host IP portion of the URL.
     *
     * @return string
     */
    public function getHost()
    {
        return $this->_host;
    }

    /**
     * Returns the TCP port, or FALSE if none.
     *
     * @return string
     */
    public function getPort()
    {
        return strlen($this->_port) > 0 ? $this->_port : false;
    }

    /**
     * Returns the Pick program.
     *
     * @return string
     */
    public function getProgram()
    {
        return $this->_program;
    }

    /**
     * Returns the Pick query, or FALSE if none.
     *
     * @return array
     */
    public function getQuery()
    {
        return empty($this->_query) ? false : (array) $this->_query;
    }

    /**
     * Returns the Pick query string, or FALSE if none
     *
     * @return string
     */
    public function getQueryString()
    {
        return empty($this->_query) ? false : http_build_query($this->_query);
    }

    /**
     * Return a string representation of this URI.
     *
     * @return string
     */
    public function getUri()
    {
        if ($this->valid() === false) {
            /** Zend_Uri_Exception */
            require_once "Zend/Uri/Exception.php";

            throw new Zend_Uri_Exception(
                "One or more parts of the URI are invalid"
            );
        }

        $uri = sprintf(
            "%s://%s:%s/%s/%s",
            $this->getScheme(),
            $this->getHost(),
            $this->getPort(),
            $this->getAccount(),
            $this->getProgram()
        );

        if ($this->getQuery()) {
            $uri .= "?" . http_build_query($this->getQuery());
        }

        return $uri;
    }

    /**
     * Sets the account for the current URI
     *
     * @param  string $account The Pick account
     * @return Bear_Pick_Uri
     */
    public function setAccount($account)
    {
        if ($this->validateAccount($account) === false) {
            /** Zend_Uri_Exception */
            require_once 'Zend/Uri/Exception.php';

            throw new Zend_Uri_Exception(
                "Account '{$account}' is not a valid Pick account."
            );
        }

        $this->_account = $account;
        return $this;
    }

    /**
     * Sets the host for the current URI
     *
     * @param  string $host The Pick host
     * @throws Zend_Uri_Exception When $host is nota valid Pick host
     * @return Bear_Pick_Uri
     */
    public function setHost($host)
    {
        if ($this->validateHost($host) === false) {
            /** Zend_Uri_Exception */
            require_once "Zend/Uri/Exception.php";

            throw new Zend_Uri_Exception(
                "Host '{$host}' is not a valid Pick host"
            );
        }

        $this->_host = $host;
        return $this;
    }

    /**
     * Sets the port for the current URI
     *
     * @param  string $port The Pick port
     * @throws Zend_Uri_Exception When $port is not a valid Pick port
     * @return Bear_Pick_Uri
     */
    public function setPort($port)
    {
        if ($this->validatePort($port) === false) {
            /** Zend_Uri_Exception */
            require_once 'Zend/Uri/Exception.php';

            throw new Zend_Uri_Exception(
                "Port '{$port}' is not a valid Pick port."
            );
        }

        $this->_port = $port;
        return $this;
    }

    /**
     * Sets the program for the current URI
     *
     * @param  string $program The Pick program
     * @return Bear_Pick_Uri
     */
    public function setProgram($program)
    {
        if ($this->validateProgram($program) === false) {
            /** Zend_Uri_Exception */
            require_once 'Zend/Uri/Exception.php';

            throw new Zend_Uri_Exception(
                "Program '{$program}' is not a valid Pick program."
            );
        }

        $this->_program = $program;
        return $this;
    }

    /**
     * Sets the query for the current URI
     *
     * @param  string $query The Pick query
     * @return Bear_Pick_Uri
     */
    public function setQuery($query)
    {
        if ($this->validateQuery($query) === false) {
            /** Zend_Uri_Exception */
            require_once 'Zend/Uri/Exception.php';

            throw new Zend_Uri_Exception("Query is not a valid.");
        }

        $this->_query = $query;
        return $this;
    }

    /**
     * Returns TRUE if this URI is valid, or FALSE otherwise.
     *
     * @return boolean
     */
    public function valid()
    {
        return $this->validateHost() &&
               $this->validatePort() &&
               $this->validateAccount() &&
               $this->validateProgram() &&
               $this->validateQuery();
    }

    /**
     * Returns true if and only if the account string passed validation. If no
     * program is passed, then the account contained in the instance variable is
     * used.
     *
     * @param  string $account The Pick account
     * @return boolean
     */
    public function validateAccount($account = null)
    {
        if ($account === null) {
            $account = $this->_account;
        }

        // If the account is empty, then it is considered invalid
        if (strlen($account) === 0) {
            return false;
        }

        // If the account has any forward-slashes in it, then it is considered
        // invalid
        if (strpos($account, "/") !== false) {
            return false;
        }

        return true;
    }

    /**
     * Returns true if and only if the host string passes validation. If no host
     * is passed, then the host contained in the instance variable is used.
     *
     * @param  string $host The HTTP host
     * @return boolean
     * @uses   Zend_Filter
     */
    public function validateHost($host = null)
    {
        if ($host === null) {
            $host = $this->_host;
        }

        // If the host is empty, then it is considered invalid
        if (strlen($host) === 0) {
            return false;
        }

        /** Zend_Validate_Hostname */
        require_once "Zend/Validate/Hostname.php";

        // Check the host against the allowed values; delegated to Zend_Filter.
        $validate = new Zend_Validate_Hostname(
            Zend_Validate_Hostname::ALLOW_ALL
        );

        return $validate->isValid($host);
    }

    /**
     * Returns true if and only if the TCP port string passes validation. If no
     * port is passed, then the port contained in the instance variable is used.
     *
     * @param  string $port The Pick port
     * @return boolean
     */
    public function validatePort($port = null)
    {
        if ($port === null) {
            $port = $this->_port;
        }

        // If the port is empty, then it is considered valid
        if (strlen($port) === 0) {
            return true;
        }

        // Check the port against the allowed values
        return ctype_digit((string) $port) and 1 <= $port and $port <= 65535;
    }

    /**
     * Returns true if and only if the program string passed validation. If no
     * program is passed, then the program contained in the instance variable is
     * used.
     *
     * @param  string $program The Pick program
     * @return boolean
     */
    public function validateProgram($program = null)
    {
        if ($program === null) {
            $program = $this->_program;
        }

        // If the program is empty, then it is considered invalid
        if (strlen($program) === 0) {
            return false;
        }

        // If the program has any forward-slashes in it, then it is considered
        // invalid
        if (strpos($program, "/") !== false) {
            return false;
        }

        return true;
    }

    /**
     * Returns true if and only if the query array passed validation. If no
     * query is passed, then the query contained in the instance variable is
     * used.
     *
     * @param  array $query The Pick query
     * @return boolean
     */
    public function validateQuery($query = null)
    {
        if ($query === null) {
            $query = $this->_query;
        }

        // If the query is not an array, it is considered invalid
        if (!is_array($query)) {
            return false;
        }

        return true;
    }

}
