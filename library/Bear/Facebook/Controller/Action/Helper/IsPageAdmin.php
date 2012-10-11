<?php
/**
 * BEAR
 *
 * @category Bear
 * @package  Bear_Facebook
 * @author   Konr Ness <konr.ness@nerdery.com>
 */

/**
 * Facebook IsPageAdmin action helper
 *
 * @category Bear
 * @package  Bear_Facebook
 * @author   Konr Ness <konr.ness@nerdery.com>
 * @version  $Id$
 */
class Bear_Facebook_Controller_Action_Helper_IsPageAdmin
    extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * @var Bear_Facebook
     */
    protected $_facebook;

    /**
     * Direct call when accessing action helper as a method
     * Test if user is a page admin
     *
     * @return boolean
     * @see isPageAdmin()
     */
    public function direct()
    {
        return $this->isPageAdmin();
    }

    /**
     * Test if user is a page admin
     *
     * @return boolean
     */
    public function isPageAdmin()
    {
        // fetch the session-cached signed request in case this is not the first page load
        $signedRequest = $this->getFacebook()->getSignedRequest(true);

        if (empty($signedRequest['page']['id'])) {
            return false;
        }

        // if the signed request was for a page other than the page in the config, bail out
        if (
            $this->getFacebook()->getPageId()
            && $signedRequest['page']['id'] != $this->getFacebook()->getPageId()
        ) {
            return false;
        }

        // tests that page/admin exists AND is boolean true
        return !empty($signedRequest['page']['admin']);
    }

    /**
     * Get Facebook SDK
     * Will retrieve from the Facebook action helper if not set
     *
     * @return Bear_Facebook
     */
    public function getFacebook()
    {
        if (! $this->_facebook) {
            $this->_facebook = $this->getActionController()->getHelper('Facebook')->getFacebook();
        }

        return $this->_facebook;
    }

    /**
     * Set the Facebook SDK
     *
     * @param Bear_Facebook $facebook
     * @return Bear_Facebook_Controller_Action_Helper_IsPageAdmin
     */
    public function setFacebook(Bear_Facebook $facebook)
    {
        $this->_facebook = $facebook;
        return $this;
    }
}