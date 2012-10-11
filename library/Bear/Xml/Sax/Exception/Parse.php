<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Xml
 */

/** Bear_Xml_Sax_Exception */
require_once 'Bear/Xml/Sax/Exception.php';

/**
 * Exception class for the SAX-based XML parser.
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Xml
 */
class Bear_Xml_Sax_Exception_Parse extends Bear_Xml_Sax_Exception
{

    /**
     * Last buffer
     * @var string
     */
    private $_lastBuffer;

    /**
     * Constructor
     *
     * Pulls the error string and code from the xml resource.
     *
     * @param resource $parser
     * @param string $lastBuffer
     */
    public function __construct($parser, $lastBuffer)
    {
        parent::__construct($parser);

        $this->_lastBuffer = $lastBuffer;
    }

    /**
     * Get the last buffer
     *
     * @return string
     */
    public function getLastBuffer()
    {
        return $this->_lastBuffer;
    }

}
