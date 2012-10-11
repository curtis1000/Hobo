<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Csv
 */

/** Bear_Base_Abstract */
require_once "Bear/Base/Abstract.php";

/**
 * CSV iterator aggrecate class
 *
 * @category Bear
 * @package Bear_Csv
 */
class Bear_Csv_IteratorAggregate extends Bear_Base_Abstract implements IteratorAggregate
{

    /**
     * Context
     * @var resource
     */
    protected $_context;

    /**
     * CSV delimiter
     * @var string
     */
    protected $_delimiter = ",";

    /**
     * CSV enclosure
     * @var string
     */
    protected $_enclosure = "\"";

    /**
     * CSV filename
     * @var string
     */
    protected $_filename;

    /**
     * File object
     * @var SplFileObject
     */
    protected $_fileObject;

    /**
     * Open mode
     * @var string
     */
    protected $_openMode = "r";

    /**
     * Skip empty lines flag
     * @bar boolean
     */
    protected $_skipEmptyLines = false;

    /**
     * Use include path flag
     * @var boolean
     */
    protected $_useIncludePath = false;

    /**
     * Get the context
     *
     * @return resource
     */
    public function getContext()
    {
        return $this->_context;
    }

    /**
     * Get the delimiter character
     *
     * @return string
     */
    public function getDelimiter()
    {
        return $this->_delimiter;
    }

    /**
     * Get the enclosure character
     *
     * @return string
     */
    public function getEnclosure()
    {
        return $this->_enclosure;
    }

    /**
     * Get the CSV filename
     *
     * @return string
     * @throws Exception
     */
    public function getFilename()
    {
        if (!$this->_filename) {
            throw new Exception("No filename set");
        }

        return $this->_filename;
    }

    /**
     * Get the CSV iterator
     *
     * @return SplFileObject
     */
    public function getIterator()
    {
        $context = $this->getContext();

        if ($context) {
            $csv = new SplFileObject(
                $this->getFilename(),
                $this->getOpenMode(),
                $this->getUseIncludePath(),
                $context
            );
        } else {
            $csv = new SplFileObject(
                $this->getFilename(),
                $this->getOpenMode(),
                $this->getUseIncludePath()
            );
        }

        $flags = SplFileObject::DROP_NEW_LINE |
                 SplFileObject::READ_CSV;

        if ($this->getSkipEmptyLines()) {
            $flags |= SplFileObject::SKIP_EMPTY;
        }

        $csv->setFlags($flags);

        $csv->setCsvControl(
            $this->getDelimiter(),
            $this->getEnclosure()
        );

        return $csv;
    }

    /**
     * Get the open mode
     *
     * @return string
     */
    public function getOpenMode()
    {
        return $this->_openMode;
    }

    /**
     * Get the skip empty lines flag
     *
     * @return boolean
     */
    public function getSkipEmptyLines()
    {
        return $this->_skipEmptyLines;
    }

    /**
     * Get the use include path flag
     *
     * @return boolean
     */
    public function getUseIncludePath()
    {
        return $this->_useIncludePath;
    }

    /**
     * Set the CSV delimiter
     *
     * @param string $delimiter
     * @return Bear_Csv_Importer
     */
    public function setDelimiter($delimiter)
    {
        $this->_delimiter = $delimiter;

        return $this;
    }

    /**
     * Set the CSV enclosure
     *
     * @param string $enclosure
     * @return Bear_Csv_Importer
     */
    public function setEnclosure($enclosure)
    {
        $this->_enclosure = $enclosure;

        return $this;
    }

    /**
     * Set the CSV filename
     *
     * @param string $filename
     * @return Bear_Csv_Importer
     */
    public function setFilename($filename)
    {
        $this->_filename = $filename;

        return $this;
    }

    /**
     * Set the open mode for the CSV
     *
     * @param string $openMode
     * @return Bear_Csv_Importer
     */
    public function setOpenMode($openMode)
    {
        $this->_openMode = $openMode;

        return $this;
    }

    /**
     * Set the skip empty lines flag
     *
     * @param boolean $skipEmptyLines
     * @return Bear_Csv_Importer
     */
    public function setSkipEmptyLines($skipEmptyLines)
    {
        $this->_skipEmptyLines = $skipEmptyLines;

        return $this;
    }

    /**
     * Set the flag for using the include path
     *
     * @param boolean $useIncludePath
     * @return Bear_Csv_Importer
     */
    public function setUseIncludePath($useIncludePath)
    {
        $this->_useIncludePath = $useIncludePath;

        return $this;
    }

}
