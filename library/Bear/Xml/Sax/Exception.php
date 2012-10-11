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
 * @package  Bear_Xml
 */
class Bear_Xml_Sax_Exception extends Exception
{

    /**
     * Constructor
     *
     * @param resource $parser
     */
    public function __construct($parser)
    {
        $code = xml_get_error_code($parser);
        parent::__construct(xml_error_string($code), $code);
    }

}
