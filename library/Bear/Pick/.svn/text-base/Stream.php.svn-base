<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Pick
 */

/** Bear_Pick */
require_once 'Bear/Pick.php';

/**
 * Stream class for Pick communication
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Pick
 * @since 2.0.0
 * @todo Add exception handling
 */
class Bear_Pick_Stream
{

    /**
     * Protocol name
     * @var string
     */
    const PROTOCOL = 'pick2';

    /**
     * Report boolean
     * @var boolean
     */
    private $_report;

    /**
     * Pick result object
     * @var Bear_Pick_Result
     */
    private $_result;

    /**
     * Register the stream wrapper
     */
    static public function registerWrapper()
    {
        stream_wrapper_register(
            self::PROTOCOL,
            'Bear_Pick_Stream'
        );
    }

    /**
     * Unregister the stream wrapper
     */
    static public function unregisterWrapper()
    {
        stream_wrapper_unregister(self::PROTOCOL);
    }

    /**
     * Open a connect to a Pick DB Server.
     *
     * @param string $path Path to connect to. Should be in the
     *        'pick://[server]:[port]/[account]/[program](?[params])'
     *        format
     * @param string $mode Mode to open the stream in. Only 'r' is supported
     * @param integer $options Options array passed via the streams library
     * @param string &$open_path Open path string passed via the stream
     *        library
     * @return boolean
     */
    public function stream_open($path, $mode, $options, &$open_path)
    {
        $this->_report = $options & STREAM_REPORT_ERRORS;

        if ($mode != 'r' && $mode != 'b' && $mode != 'rb' && $mode != 'br') {
            $this->_error('The Pick stream class only supports the "r" and "rb" modes.');
            return false;
        }

        // Load options from the context
        $options = array();
        if (isset($this->context)) {
            $context = stream_context_get_options($this->context);
            if (isset($context[self::PROTOCOL])) {
                $options += $context[self::PROTOCOL];
            }
        }

        $url = $this->_parsePickPath($path);

        $host = $url['host'];
        unset($url['host']);

        $options += $url;

        try {
            $pick = new Bear_Pick(
                $host,
                $options
            );

            $this->_result = $pick->execute();
        } catch (Bear_Pick_Exception $e) {
            $this->_error($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Close the connection
     */
    public function stream_close()
    {
        unset($this->_pick);
    }

    /**
     * Check for end of file
     *
     * @return boolean
     */
    public function stream_eof()
    {
        return $this->_result
                    ->isEndOfFile();
    }

    /**
     * Read the response from the Pick server.
     *
     * @param integer $count
     * @return string
     */
    public function stream_read($count)
    {
        try {
            return $this->_result
                        ->read($count);
        } catch (Bear_Pick_Exception $e) {
            $this->_error($e->getMessage());
            return false;
        }
    }

    /**
     * Seek the read/write position
     *
     * @param integer $offset
     * @param integer $whence
     * @return boolean
     */
    public function stream_seek($offset, $whence)
    {
        return fseek($this->_result->getConnection(), $offset, $whence);
    }

    /**
     * Get information about the stream
     *
     * @return array
     */
    public function stream_stat()
    {
        return fstat($this->_result->getConnection());
    }

    /**
     * Tell the read/write position
     *
     * @return integer
     */
    public function stream_tell()
    {
        return ftell($this->_result->getConnection());
    }

    /**
     * Write to the stream
     *
     * The Pick DB server does not support writing.
     *
     * @return integer
     */
    public function stream_write($data)
    {
        return 0;
    }

    /**
     * Flush the stream
     *
     * @return boolean
     */
    public function stream_flush()
    {
        return fflush($this->_result->getConnection());
    }

    /**
     * Stat for URLs
     *
     * @param string $path
     * @param integer $flags
     * @return array
     */
    public function url_stat($path, $flags)
    {
        $time = time();

        return array(
            "size"  => -1,
            "atime" => $time,
            "mtime" => $time
        );
    }

    /**
     * Trigger an error and return false
     *
     * @param string $message
     */
    private function _error($message)
    {
        if ($this->_report) {
            trigger_error($message);
        }
    }

    /**
     * Parse the Pick path
     * @param array $url
     * @return array
     */
    private function _parsePickPath($url)
    {
        $info = parse_url($url);

        $array = array(
            'host' => $info['host']
        );

        if (isset($info['port']) && $info['port']) {
            $array['port'] = $info['port'];
        } else {
            $array['port'] = Bear_Pick::DEFAULT_PORT;
        }

        preg_match('/^\/(.*?)\/(.*)$/', $info['path'], $matches);

        $array['account'] = $matches[1];
        $array['program'] = $matches[2];

        if (isset($info['query'])) {
            $array['query'] = $info['query'];
        } else {
            $array['query'] = '';
        }

        return $array;
    }

}
