<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Filter
 */

/** Bear_Base_Abstract */
require_once "Bear/Base/Abstract.php";

/** Zend_Filter_Interface */
require_once "Zend/Filter/Interface.php";

/**
 * GD-based image filtering class
 *
 * @category Bear
 * @package Bear_Filter
 */
class Bear_Filter_Image_Gd extends Bear_Base_Abstract implements Zend_Filter_Interface
{

    /**
     * Operations
     * @var array
     */
    private $_operations = array();

    /**
     * Add an operation
     *
     * @param Bear_Filter_Image_Gd_Operation_Interface $operation
     * @return Bear_Filter_Image_Gd
     */
    public function addOperation(Bear_Filter_Image_Gd_Operation_Interface $operation)
    {
        $this->_operations[] = $operation;

        return $this;
    }

    /**
     * Add multiple operations
     *
     * @param array $operations
     * @return Bear_Filter_Image_Gd
     */
    public function addOperations(array $operations)
    {
        foreach ($operations as $operation) {
            $this->addOperation($operation);
        }

        return $this;
    }

    /**
     * Clear all the operations
     *
     * @return Bear_Filter_Image_Gd
     */
    public function clearOperations()
    {
        $this->_operations = array();

        return $this;
    }

    /**
     * Get the operations
     *
     * @return array
     */
    public function getOperations()
    {
        return $this->_operations;
    }

    /**
     * Set the operators
     *
     * @param array $operators
     * @return Bear_Filter_Image_Gd
     */
    public function setOperations(array $operators)
    {
        return $this->clearOperations()
                    ->addOperations($operators);
    }

    /**
     * Filter the value
     *
     * @param mixed $value
     * @return string
     * @throws Bear_Filter_Image_Exception_CouldNotLoadFile
     * @throws Bear_Filter_Image_Exception_CouldNotReadFile
     * @throws Bear_Filter_Image_Exception_FileNotFound
     * @throws Bear_Filter_Image_Gd_Exception_NoSaverSet
     */
    public function filter($value)
    {
        $gd = $this->_openImage($value);

        foreach ($this->getOperations() as $operation) {
            $gd = $operation->filter($gd);
        }

        return $gd;
    }

    /**
     * Open a GD resource
     *
     * @param mixed $value
     * @return resource
     * @throws Bear_Filter_Image_Exception_CouldNotLoadFile
     * @throws Bear_Filter_Image_Exception_CouldNotReadFile
     * @throws Bear_Filter_Image_Exception_FileNotFound
     */
    private function _openImage($value)
    {
        if (!extension_loaded("gd")) {
            /** Bear_Filter_Image_Exception_GdExtensionNotLoaded */
            require_once "Bear/Filter/Image/Exception/GdExtensionNotLoaded.php";

            throw new Bear_Filter_Image_Exception_GdExtensionNotLoaded();
        }

        if (!file_exists($value)) {
            /** Bear_Filter_Image_Exception_FileNotFound */
            require_once "Bear/Filter/Image/Exception/FileNotFound.php";

            throw new Bear_Filter_Image_Exception_FileNotFound($value);
        }

        $blob = @file_get_contents($value);
        if (!$blob) {
            /** Bear_Filter_Image_Exception_CouldNotReadFile */
            require_once "Bear/Filter/Image/Exception/CouldNotReadFile.php";

            throw new Bear_Filter_Image_Exception_CouldNotReadFile($value);
        }

        $gd = @imagecreatefromstring($blob);
        if (!$gd) {
            /** Bear_Filter_Image_Exception_CouldNotLoadFile */
            require_once "Bear/Filter/Image/Exception/CouldNotLoadFile.php";

            throw new Bear_Filter_Image_Exception_CouldNotLoadFile($value);
        }

        return $gd;
    }

}
