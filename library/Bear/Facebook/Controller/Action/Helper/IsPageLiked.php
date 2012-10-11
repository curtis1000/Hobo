<?php
/**
 * BEAR
 *
 * @category Bear
 * @package  Bear_Facebook
 * @author   Konr Ness <konr.ness@nerdery.com>
 */

/**
 * Facebook IsPageLiked action helper
 *
 * @category Bear
 * @package  Bear_Facebook
 * @author   Konr Ness <konr.ness@nerdery.com>
 * @version  $Id$
 */
class Bear_Facebook_Controller_Action_Helper_IsPageLiked
    extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * @var Bear_Facebook
     */
    protected $_facebook;

    /**
     * Direct call when accessing action helper as a method
     * Test if user has liked the Facebook page
     *
     * @return boolean
     * @see isPageAdmin()
     */
    public function direct()
    {
        return $this->isPageLiked();
    }

    /**
     * Test if user has liked the Facebook page
     *
     * @return boolean
     */
    public function isPageLiked()
    {
        // fetch the session-cached signed request in case this is
        // not the first page load
        $signedRequest = $this->getFacebook()->getSignedRequest(true);

        if (empty($signedRequest['page']['id'])) {
            return false;
        }

        // if the signed request was for a page other than
        // the page in the config, bail out
        if (
            $this->getFacebook()->getPageId()
            && $signedRequest['page']['id'] != $this->getFacebook()->getPageId()
        ) {
            return false;
        }

        // tests that page/liked exists AND is boolean true
        return !empty($signedRequest['page']['liked']);
    }

    /**
     * Get Facebook SDK
     * Will retrieve from the Facebook action helper if not set
     *
     * @return Bear_Facebook
     */
    public function getFacebook()
    {
        if (!$this->_facebook) {
            $this->_facebook = $this->getActionController()->getHelper('Facebook')->getFacebook();
        }

        return $this->_facebook;
    }

    /**
     * Set the Facebook SDK
     *
     * @param Bear_Facebook $facebook
     * @return Bear_Facebook_Controller_Action_Helper_IsPageLiked
     */
    public function setFacebook(Bear_Facebook $facebook)
    {
        $this->_facebook = $facebook;
        return $this;
    }
}