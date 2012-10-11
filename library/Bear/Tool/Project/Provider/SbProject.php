<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Tool
 */

/**
 * Sierra Bravo Project Provider
 *
 * @category Bear
 * @package Bear_Tool
 * @author Konr Ness <konr.ness@sierra-bravo.com>
 * @version $Id$
 */
class Bear_Tool_Project_Provider_SbProject
    extends Zend_Tool_Project_Provider_Project
{

    /**
     * Project name space
     *
     * @var string
     */
    protected $_projectName;
    
    /**
     * Initialize
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        
        $contextRegistry = Zend_Tool_Project_Context_Repository::getInstance();
        $contextRegistry->addContextsFromDirectory(
            dirname(dirname(__FILE__)) . '/Context/', 'Bear_Tool_Project_Context_'
        );
        $contextRegistry->addContextsFromDirectory(
            dirname(dirname(__FILE__)) . '/Context/Filesystem', 'Bear_Tool_Project_Context_Filesystem'
        );
    }

    /**
     * create()
     *
     * @param string $path
     * @param string $name shortName=n
     * @return void
     */
    public function create($path, $name = null, $fileOfProfile = null)
    {
        $this->_setProjectName($name);
        
        //echo $this->_getDefaultProfile();exit();
        
        parent::create($path);
        
        $response = $this->_registry->getResponse();
        $response->appendContent('');
        $response->appendContent('NEXT STEPS: ', array('separator' => true, 'color' => 'yellow'));
        $response->appendContent('1) chmod -R 777 data');
        $response->appendContent('2) Edit public/.htaccess and set RewriteBase');
        $response->appendContent('3) Check this code into your SVN repo');
        $response->appendContent('  a) Add svn:ignore for public/.htaccess');
        $response->appendContent('  b) Add svn:ignore for logs/*');
        $response->appendContent('4) Add svn:external for Zend & Bear to library directory');
        
    }
    
    /**
     * Get default profile specific to the project name
     *
     * @return string
     */
    protected function _getDefaultProfile()
    {
        $projectName = $this->_getProjectName();
        
        $data = <<<EOS
<?xml version="1.0"?>
<projectProfile type="sierraBravoStandard" version="1.10">
  <projectDirectory>
    <projectProfileFile filesystemName=".zfproject.xml"/>
    <applicationDirectory classNamePrefix="Application_">
      <apisDirectory enabled="false"/>
      <configsDirectory>
        <applicationConfigFile type="ini" projectNamespace="{$projectName}"/>
      </configsDirectory>
      <controllersDirectory>
        <controllerFile controllerName="Index">
          <actionMethod actionName="index"/>
        </controllerFile>
        <controllerFile controllerName="Error"/>
      </controllersDirectory>
      <formsDirectory enabled="false"/>
      <layoutsDirectory>
        <layoutScriptsDirectory>
          <layoutScriptFile layoutName="layout" projectName="{$projectName}"/>
        </layoutScriptsDirectory>
      </layoutsDirectory>
      <modelsDirectory/>
      <modulesDirectory enabled="false" />
      <!--
      <modulesDirectory>
        <moduleDirectory moduleName="test">
          <apisDirectory enabled="false"/>
          <configsDirectory enabled="false"/>
          <controllersDirectory/>
          <formsDirectory enabled="false"/>
          <layoutsDirectory enabled="false">
            <layoutScriptsDirectory enabled="false"/>
          </layoutsDirectory>
          <modelsDirectory/>
          <viewsDirectory>
            <viewScriptsDirectory/>
            <viewHelpersDirectory/>
            <viewFiltersDirectory/>
          </viewsDirectory>
        </moduleDirectory>
      </modulesDirectory>
      -->
      <viewsDirectory>
        <viewScriptsDirectory>
          <viewControllerScriptsDirectory forControllerName="Index">
            <viewScriptFile forActionName="index"/>
          </viewControllerScriptsDirectory>
          <viewControllerScriptsDirectory forControllerName="Error">
            <viewScriptFile forActionName="authentication-required"/>
            <viewScriptFile forActionName="forbidden"/>
            <viewScriptFile forActionName="internal-server-error"/>
            <viewScriptFile forActionName="not-found"/>
          </viewControllerScriptsDirectory>
        </viewScriptsDirectory>
        <viewHelpersDirectory/>
        <viewFiltersDirectory enabled="false"/>
      </viewsDirectory>
      <bootstrapFile filesystemName="Bootstrap.php"/>
    </applicationDirectory>
    <dataDirectory>
      <cacheDirectory enabled="false"/>
      <searchIndexesDirectory enabled="false"/>
      <localesDirectory enabled="false"/>
      <logsDirectory/>
      <sqlDirectory/>
      <sessionsDirectory enabled="false"/>
      <uploadsDirectory enabled="false"/>
    </dataDirectory>
    <docsDirectory>
      <file filesystemName="README.txt"/>
    </docsDirectory>
    <libraryDirectory>
      <zfStandardLibraryDirectory enabled="false"/>
      <projectLibraryDirectory filesystemName="{$projectName}">
        <directory filesystemName="Controller">
            <directory filesystemName="Action">
                <directory filesystemName="Helper"/>
            </directory>
        </directory>
        <directory filesystemName="View">
            <directory filesystemName="Helper"/>
        </directory>
      </projectLibraryDirectory>
    </libraryDirectory>
    <publicDirectory>
      <publicStylesheetsDirectory>
        <file filesystemName="global.css"/>
      </publicStylesheetsDirectory>
      <publicScriptsDirectory>
        <file filesystemName="global.js"/>
      </publicScriptsDirectory>
      <publicImagesDirectory/>
      <publicIndexFile filesystemName="index.php"/>
      <htaccessFile filesystemName=".htaccess"/>
      <htaccessDistFile filesystemName=".htaccess-dist"/>
    </publicDirectory>
    <projectProvidersDirectory enabled="false"/>
    <temporaryDirectory enabled="false"/>
    <testsDirectory>
      <testPHPUnitConfigFile filesystemName="phpunit.xml"/>
      <testApplicationDirectory>
        <testApplicationBootstrapFile filesystemName="bootstrap.php"/>
      </testApplicationDirectory>
      <testLibraryDirectory>
        <testLibraryBootstrapFile filesystemName="bootstrap.php"/>
      </testLibraryDirectory>
    </testsDirectory>
  </projectDirectory>
</projectProfile>
EOS;
        return $data;
    }
    
    /**
     * Get contents for README file
     *
     * @param $caller
     * @return string
     */
    public static function getDefaultReadmeContents($caller = null)
    {
        $projectDirResource = $caller->getResource()->getProfile()->search('projectDirectory');
        if ($projectDirResource) {
            $name = ltrim(strrchr($projectDirResource->getPath(), DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR);
            $path = $projectDirResource->getPath() . '/public';
        } else {
            $path = '/path/to/public';
        }
        
        return <<< EOS
README
======

Sierra Bravo Base Zend Framework Project

This directory should be used to place project specfic documentation including
but not limited to project notes, generated API/phpdoc documentation, or 
manual files generated or hand written.  Ideally, this directory would remain
in your development environment only and should not be deployed with your
application to it's final production location.


Setting Up Your VHOST
=====================

The following is a sample VHOST you might want to consider for your project.

<VirtualHost *:80>
   DocumentRoot "$path"
   ServerName $name.local

   # This should be omitted in the production environment
   SetEnv APPLICATION_ENV development
    
   <Directory "$path">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride All
       Order allow,deny
       Allow from all
   </Directory>
    
</VirtualHost>

EOS;
    }
    
    /**
     * Set project name
     *
     * @param string $name Project name
     * @return Bear_Tool_Project_Provider_SbProject
     */
    protected function _setProjectName($name)
    {
        $this->_projectName = ucfirst($name);
        return $this;
    }
    
    /**
     * Get the project name
     *
     * @return string
     */
    protected function _getProjectName()
    {
        return $this->_projectName;
    }
}