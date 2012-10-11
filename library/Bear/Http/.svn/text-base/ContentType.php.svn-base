<?php
/**
 * BEAR
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Http
 * @since 1.2.2
 */

/**
 * Content type handler
 *
 * Determines the content type of a response via HTTP protocol and RFC 3023
 * rules.
 *
 * @category Bear
 * @package Bear_Http
 */
class Bear_Http_ContentType
{

    /**
     * ISO-8859-1
     * @var string
     */
    const ISO_8859_1 = "ISO-8859-1";

    /**
     * US-ASCII
     * @var string
     */
    const US_ASCII = "US-ASCII";

    /**
     * UTF-8
     * @var string
     */
    const UTF_8 = "UTF-8";

    /**
     * Body
     * @var string
     */
    protected $_body;

    /**
     * Media type
     * @var string
     */
    protected $_mediaType;

    /**
     * Content type parameters
     * @var array
     */
    protected $_parameters = array();

    /**
     * Default charsets for various media-types
     * @var array
     */
    protected $_defaultCharsets = array(
        "application/xml" => self::UTF_8, // RFC 3023
        "application/xml-dtd" => self::UTF_8, // RFC 3023
        "application/xml-external-parsed-entity" => self::UTF_8, // RFC 3023
        "text/xml" => self::US_ASCII, // RFC 3023
        "text/xml-dtd" => self::US_ASCII, // RFC 3023
        "text/xml-external-parsed-entity" => self::US_ASCII, // RFC 3023
        "text/calendar" => self::UTF_8 // RFC 5545
    );

    /**
     * Default charsets for various media-type patterns
     * @var array
     */
    protected $_defaultCharsetPatterns = array(
        "application/.*-xml" => self::UTF_8, // RFC 3023
        "text/.*-xml" => self::US_ASCII, // RFC 3023
        "text/.*" => self::ISO_8859_1, // HTTP protocol
        ".*" => null // HTTP protocol
    );

    /**
     * Get a string representation of the content type
     *
     * @return string
     */
    public function __toString()
    {
        $contentType = $this->getMediaType();

        if ($this->getParameters()) {
            foreach ($this->getParameters() as $k => $v) {
                $contentType .= "; {$k}={$v}";
            }
        }

        return $contentType;
    }

    /**
     * Get the body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->_body;
    }

    /**
     * Get the charset from the content type
     *
     * Returns the authoritative charset from the content type, if present, or
     * determines the default based on various protocol and RFC documents.
     *
     * @return string
     */
    public function getCharset()
    {
        // Use the authoritative charset, if present
        $parameters = $this->getParameters();
        if (isset($parameters["charset"])) {
            return $parameters["charset"];
        }

        // RFC 3023 handling
        if ($this->isXML()) {
            $dom = new DomDocument();

            if (@$dom->loadXml($this->getBody())) {
                return $dom->encoding;
            }
        }

        // Check the list of known media type/charset defaults
        if (isset($this->_defaultCharsets[$this->getMediaType()])) {
            return $this->_defaultCharsets[$this->getMediaType()];
        }

        // Check the list of known media type patterns/charset defaults
        foreach ($this->_defaultCharsetPatterns as $pattern => $charset) {
            if (preg_match("#^{$pattern}$#", $this->getMediaType())) {
                return $charset;
            }
        }
    }

    /**
     * Get the media type from the content type
     *
     * @return string
     */
    public function getMediaType()
    {
        return $this->_mediaType;
    }

    /**
     * Get the parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->_parameters;
    }

    /**
     * Set the body
     *
     * @param string $body
     * @return Bear_Http_ContentType
     */
    public function setBody($body)
    {
        $this->_body = $body;
        return $this;
    }

    /**
     * Set the content type
     *
     * @param string $contentType
     * @return Bear_Http_ContentType
     */
    public function setContentType($contentType)
    {
        $parts = explode(";", $contentType);

        $this->setMediaType(array_shift($parts));

        $parameters = array();
        foreach ($parts as $part) {
            $parameterParts = explode("=", trim($part));

            $parameters[$parameterParts[0]] = $parameterParts[1];
        }

        $this->setParameters($parameters);

        return $this;
    }

    /**
     * Set the media type
     *
     * @param string $mediaType
     * @return Bear_Http_ContentType
     */
    public function setMediaType($mediaType)
    {
        $this->_mediaType = $mediaType;
        return $this;
    }

    /**
     * Set the parameters
     *
     * @param array $parameters
     * @return Bear_Http_ContentType
     */
    public function setParameters(array $parameters)
    {
        $this->_parameters = $parameters;
        return $this;
    }

    /**
     * Set the response
     *
     * @param Zend_Http_Response $response
     * @return Bear_Http_ContentType
     */
    public function setResponse(Zend_Http_Response $response)
    {
        $this->setBody($response->getBody());

        if ($response->getHeader("Content-Type")) {
            $this->setContentType($response->getHeader("Content-Type"));
        }

        return $this;
    }

    /**
     * Check if the media type is an XML type
     *
     * @return boolean
     */
    public function isXml()
    {
        return $this->getMediaType() == "text/xml" ||
               $this->getMediaType() == "text/xml-dtd" ||
               $this->getMediaType() == "text/xml-external-parsed-entity" ||
               preg_match("#^text/.*-xml$#", $this->getMediaType()) ||
               $this->getMediaType() == "application/xml" ||
               $this->getMediaType() == "application/xml-dtd" ||
               $this->getMediaType() == "application/xml-external-parsed-entity" ||
               preg_match("#^application/.*-xml$#", $this->getMediaType());
    }

}
