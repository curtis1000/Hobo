<?php
/**
 *
 */

/** Task */
require_once 'phing/Task.php';

/** FileSet */
require_once 'phing/types/FileSet.php';

/**
 *
 */
class Bear_Phing_Task_ChgrpTask extends Task
{

    /**
     * File to change the group ownership of
     * @var PhingFile
     */
    protected $_file;
    
    /**
     * Filesets
     * @var array
     */
    protected $_filesets = array();

    /**
     * Group name to change the files group ownership to
     * @var string
     */
    protected $_group;

    /**
     * Create a fileset
     *
     * @return FileSet
     */
    function createFileSet()
    {
        $num = array_push($this->_filesets, new FileSet());
        return $this->_filesets[$num-1];
    }
    
    /**
     * Get the file
     *
     * @return PhingFile
     */
    public function getFile()
    {
        return $this->_file;
    }
    
    /**
     * Get the filesets
     *
     * @return array
     */
    public function getFilesets()
    {
        return $this->_filesets;
    }
    
    /**
     * Get the group name
     *
     * @return string
     */
    public function getGroup()
    {
        return $this->_group;
    }
    
    /**
     * Set the file
     *
     * @param string|PhingFile $file
     */
    public function setFile($file)
    {
        if (!$file instanceof PhingFile) {
            $file = new PhingFile($file);
        }
        $this->_file = $file;
    }
    
    /**
     * Set the group name
     *
     * @param string $group
     */
    public function setGroup($group)
    {
        $this->_group = $group;
    }
    
    /**
     * Change the ownership of the supplied files and filesets
     */
    public function main()
    {
        if (!$this->getFile() && !$this->getFilesets()) {
            throw new BuildException("Specify at least one source - a file or a fileset.");
        }
        
        if (!$this->getGroup()) {
            throw new BuildException("You have to specify a group.");
        }
        
        if ($this->getFile()) {
            $this->_changeGroupOwnership($this->getFile(), $this->getGroup());
        }

        foreach ($this->getFilesets() as $fileset) {
            $ds = $fileset->getDirectoryScanner($this->project);
            $fromDir = $fileset->getDir($this->project);

            $srcFiles = $ds->getIncludedFiles();
            $srcDirs = $ds->getIncludedDirectories();

            $filecount = count($srcFiles);
            for ($j = 0; $j < $filecount; $j++) {
                $this->_changeGroupOwnership(new PhingFile($fromDir, $srcFiles[$j]), $this->getGroup());
            }

            $dircount = count($srcDirs);
            for ($j = 0; $j <  $dircount; $j++) {
                $this->_changeGroupOwnership(new PhingFile($fromDir, $srcDirs[$j]), $this->getGroup());
            }
        }
    }
    
    /**
     * Change the group ownership of a file
     *
     * @param PhingFile $file
     * @param string $group
     */
    protected function _changeGroupOwnership(PhingFile $file, $group)
    {
        $file->setGroup($group);
    }

}
