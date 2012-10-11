<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Tool
 */

/**
 * Sierra Bravo Module Provider
 *
 * @category Bear
 * @package Bear_Tool
 * @author Konr Ness <konr.ness@sierra-bravo.com>
 * @version $Id$
 */
class Bear_Tool_Project_Provider_SbModule
    extends Zend_Tool_Project_Provider_Module
{

    /**
     * Enable modules for the project
     *
     * @return void
     */
    public function enable()
    {
        $this->_loadProfile(self::NO_PROFILE_THROW_EXCEPTION);

        $appConfigFile = $this->_loadedProfile->search('ApplicationConfigFile');
        $appConfigFile->addStringItem('resources.modules', 'On', 'production');
        $appConfigFile->addStringItem('resources.frontController.moduleDirectory', 'APPLICATION_PATH "/modules"', 'production', false);
        $appConfigFile->create();
    }
    
    // @todo also, when creating a module, if the modulesDirectory is not yet enabled, then run enable on this
    
}

