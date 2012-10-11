<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Tool
 */

require_once 'Bear/Tool/Project/Provider/SbProject.php';
require_once 'Bear/Tool/Project/Provider/SbModule.php';

/**
 * View Script File Context
 *
 * @category Bear
 * @package Bear_Tool
 * @author Konr Ness <konr.ness@sierra-bravo.com>
 * @version $Id$
 */
class Bear_Tool_Project_Provider_Manifest
  implements Zend_Tool_Framework_Manifest_ProviderManifestable
{

    /**
     * Get the providers for this manifest
     *
     * @return array
     */
    public function getProviders()
    {
        return array(
            'Bear_Tool_Project_Provider_SbProject',
            'Bear_Tool_Project_Provider_SbModule',
        );
    }
}