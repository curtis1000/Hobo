<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Xml
 */

/** Bear_Base_Abstract */
require_once "Bear/Base/Abstract.php";

/** Bear_Xml_Sax_Exception */
require_once 'Bear/Xml/Sax/Exception.php';

/** Bear_Xml_Sax_Exception_Parse */
require_once 'Bear/Xml/Sax/Exception/Parse.php';

/**
 * Abstract base class for implementing a Sax-based parser in PHP.
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Xml
 */
abstract class Bear_Xml_Sax extends Bear_Base_Abstract
{

    /**
     * XML parser resource
     * @var resource
     */
    private $_parser;

    /**
     * Character data handler
     *
     * @param resource $parser
     * @param string $data
     */
    abstract protected function cdataHandler($parser, $data);

    /**
     * End tag handler
     *
     * @param resource $parser
     * @param string $name
     */
    abstract protected function endHandler($parser, $name);

    /**
     * Start tag handler
     *
     * @param resource $parser
     * @param string $name
     * @param array $attribs
     */
    abstract protected function startHandler($parser, $name, $attribs);

    /**
     * Constructor
     *
     * Calls all the xml_* setup methods.
     *
     * @param string $encoding
     * @param array $outputs
     * @throws Bear_Xml_Sax_Exception
     */
    public function __construct($encoding = "", $options = array())
    {
        $this->_parser = xml_parser_create(
            $encoding
        ) or $this->_throwException();

        // Setup the XML handler callbacks
        xml_set_object(
            $this->_parser,
            $this
        ) or $this->_throwException();

        xml_set_element_handler(
            $this->_parser,
            'startHandler',
            'endHandler'
        ) or $this->_throwException();

        xml_set_character_data_handler(
            $this->_parser,
            'cdataHandler'
        ) or $this->_throwException();

        if (isset($options["target_encoding"])) {
            $options["targetEncoding"] = $options["target_encoding"];
            unset($options["target_encoding"]);
        }

        if (isset($options["case_folding"])) {
            $options["caseFolding"] = $options["case_folding"];
            unset($options["case_folding"]);
        }

        parent::__construct($options);
    }

    /**
     * Get the XML parser resource
     *
     * @return resource
     */
    public function getParser()
    {
        return $this->_parser;
    }

    /**
     * Parse a XML chunk.
     *
     * Passes the XML chunk to the xml_parse method.
     *
     * @param string $string
     * @param boolean $eof
     * @throws Bear_Xml_Sax_Exception_Parse
     */
    public function parse($string, $eof = false)
    {
        if (!xml_parse($this->_parser, $string, $eof)) {
            throw new Bear_Xml_Sax_Exception_Parse(
                $this->_parser,
                $string
            );
        }
    }

    /**
     * Parse a XML file.
     *
     * Parses a file based on the filename. Can be any valid URI, which will
     * use the registered stream wrapper.
     *
     * @param string $filename
     * @param integer $readLength
     * @throws Bear_Xml_Sax_Exception_Parser
     * @throws RuntimeException
     */
    public function parseFile($filename, $readLength = 8192)
    {
        $fp = @fopen($filename, 'rb');

        if (!$fp) {
            throw new RuntimeException('Could not open ' . $filename);
        }

        try {
            $this->parseStream($fp, $readLength);
        } catch (Exception $e) {
            fclose($fp);
            throw $e;
        }

        fclose($fp);
    }

    /**
     * Parse a XML stream.
     *
     * Parses a PHP stream.
     *
     * @param resource $stream
     * @param integer $readLength
     * @throws Bear_Xml_Sax_Exception_Parse
     * @throws RuntimeException
     */
    public function parseStream($stream, $readLength = 8192)
    {
        if (!is_resource($stream)) {
            throw new RuntimeException(
                "Supplied stream was not a valid resource."
            );
        }

        while (!feof($stream)) {
            $this->parse(fread($stream, $readLength), false);
        }
        $this->parse("", true);
    }

    /**
     * Parse a string.
     *
     * Parses a complete XML string.
     *
     * @param string $string
     * @param integer $chunkLength
     * @throws Bear_Xml_Sax_Exception_Parse
     */
    public function parseString($string, $chunkLength = 0)
    {
        if ($chunkLength) {
            for($i = 0; $i < strlen($string); $i += $chunkLength) {
                $this->parse(substr($string, $i, $chunkLength), false);
            }
            $this->parse("", true);
        } else {
            $this->parse($string, true);
        }
    }

    /**
     * Set the case folding option
     *
     * @param boolean $caseFolding
     * @return Bear_Xml_Sax
     */
    public function setCaseFolding($caseFolding)
    {
        xml_parser_set_option(
            $this->_parser,
            XML_OPTION_CASE_FOLDING,
            $caseFolding
        ) or $this->_throwException();

        return $this;
    }

    /**
     * Set the target encoding
     *
     * @param string $targetEncoding
     * @return Bear_Xml_Sax
     */
    public function setTargetEncoding($targetEncoding)
    {
        xml_parser_set_option(
            $this->getParser(),
            XML_OPTION_TARGET_ENCODING,
            $targetEncoding
        ) or $this->_throwException();

        return $this;
    }

    /**
     * Throw an exception.
     *
     * Throws an exception with information pulled from the XML error handling
     * functions.
     *
     * @throws Bear_Xml_Sax_Exception
     */
    protected function _throwException()
    {
        throw new Bear_Xml_Sax_Exception($this->_parser);
    }

}
