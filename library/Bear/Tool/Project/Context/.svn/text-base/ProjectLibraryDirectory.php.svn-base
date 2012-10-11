<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Tool
 */

/**
 * Project Library Directory Context
 *
 * @category Bear
 * @package Bear_Tool
 * @author Konr Ness <konr.ness@sierra-bravo.com>
 * @version $Id$
 */
class Bear_Tool_Project_Context_ProjectLibraryDirectory
    extends Zend_Tool_Project_Context_Filesystem_Directory
{

    /**
     * @var string
     */
    protected $_filesystemName = 'Project';

    /**
     * getName()
     *
     * @return string
     */
    public function getName()
    {
        return 'ProjectLibraryDirectory';
    }

    /**
     * init()
     *
     * @return Zend_Tool_Project_Context_Filesystem_File
     */
    public function init()
    {
        if ($this->_resource->hasAttribute('filesystemName')) {
            $this->_filesystemName = $this->_resource->getAttribute('filesystemName');
        }
        
        return parent::init();
    }
    
    /**
     * create()
     *
     * @return Zend_Tool_Project_Context_Filesystem_Directory;
     */
    public function create()
    {
        parent::create();
    }
    
}