<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Tool
 */

/**
 * Generic Filesystem Directory Context
 *
 * @category Bear
 * @package Bear_Tool
 * @author Konr Ness <konr.ness@sierra-bravo.com>
 * @version $Id$
 */
class Bear_Tool_Project_Context_Filesystem_Directory 
    extends Zend_Tool_Project_Context_Filesystem_Directory
{
    
    /**
     * getName()
     * 
     * @return string
     */
    public function getName()
    {
        return 'directory';
    }
    
    /**
     * Support intializing the filesystemName from the project config
     * This is not supported in the ZF parent class
     *
     * @return Zend_Tool_Project_Context_Filesystem_File
     */
    public function init()
    {
        if ($this->_resource->hasAttribute('filesystemName')) {
            $this->_filesystemName = $this->_resource->getAttribute('filesystemName');
        }
        
        parent::init();
        return $this;
    }
}