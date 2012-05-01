<?php

class Hobo_InstallerController extends Hobo_Controller_Action {

    public function indexAction()
    {
        if (! $this->_helper->installer->isInstalled()) {
            $this->_helper->installer->install();
        }
        $this->_helper->redirector->gotoRoute(array(), 'hobo-installer-installed', true);
    }

    /**
     * Confirmation page to show the user that hobo is installed
     */
    public function installedAction()
    {

    }
}