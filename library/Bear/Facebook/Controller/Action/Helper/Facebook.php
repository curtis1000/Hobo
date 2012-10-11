<?php
/**
 * BEAR
 *
 * @category Bear
 * @package  Bear_Facebook
 * @author   Konr Ness <konr.ness@nerdery.com>
 */

/**
 * Facebook action helper
 *
 * @category Bear
 * @package  Bear_Facebook
 * @author   Konr Ness <konr.ness@nerdery.com>
 * @version  $Id$
 */
class Bear_Facebook_Controller_Action_Helper_Facebook
    extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * Facebook
     * 
     * @var Bear_Facebook
     */
    protected $_facebook;

    /**
     * @var Bear_Facebook_AuthAdapter
     */
    protected $_authAdapter;

    /**
     * @var string|false
     */
    protected $_p3pCompactPolicy = "HONK";

    /**
     * Get Facebook object
     *
     * @return Bear_Facebook
     */
    public function direct()
    {
        return $this->getFacebook();
    }

    /**
     * Hook into action controller preDispatch() workflow
     *
     * @return void
     */
    public function preDispatch()
    {
        parent::preDispatch();

        // force the loading of the signed request in case
        // the request includes it so that our session always has
        // the latest signed request
        $this->getFacebook()->getSignedRequest(false);
    }

    /**
     * Hook into action controller postDispatch() workflow
     * to inject a P3P compact policy header if available
     *
     * @return void
     */
    public function postDispatch()
    {
        /**
         * Set a P3P security policy header so that IE
         * will accept our session cookie within an iframe
         * @see http://developers.facebook.com/docs/samples/canvas/
         */
        if ($this->getP3pCompactPolicy()) {
            $this->getResponse()
                 ->setHeader('P3P', 'CP="' . $this->getP3pCompactPolicy() . '"');

        }
    }

    /**
     * Set Facebook object
     *
     * @param Bear_Facebook $facebook
     * @return Bear_Facebook_Controller_Action_Helper_Facebook
     */
    public function setFacebook(Bear_Facebook $facebook)
    {
        $this->_facebook = $facebook;
        return $this;
    }

    /**
     * Get Facebook object
     *
     * @throws Zend_Controller_Action_Exception if Facebook is not set
     * @return Bear_Facebook
     */
    public function getFacebook()
    {
        if (! $this->_facebook) {
            throw new Zend_Controller_Action_Exception('Facebook not set');
        }
        return $this->_facebook;
    }

    /**
     * Set the auth adapter
     *
     * @param Bear_Facebook_AuthAdapter $authAdapter
     * @return Bear_Facebook_Controller_Action_Helper_Facebook
     */
    public function setAuthAdapter(Bear_Facebook_AuthAdapter $authAdapter)
    {
        $this->_authAdapter = $authAdapter;
        return $this;
    }

    /**
     * Get the auth adapter
     *
     * @return Bear_Facebook_AuthAdapter
     */
    public function getAuthAdapter()
    {
        if (! $this->_authAdapter) {
            throw new Zend_Controller_Action_Exception('Auth adapter not set');
        }
        return $this->_authAdapter;
    }

    /**
     * Set the P3P Compact Policy. Empty string to disable.
     *
     * @param string $p3pCompactPolicy
     * @return Bear_Facebook_Controller_Action_Helper_Facebook
     */
    public function setP3pCompactPolicy($p3pCompactPolicy)
    {
        $this->_p3pCompactPolicy = $p3pCompactPolicy;
        return $this;
    }

    /**
     * Get the P3P Compact Policy. Empty string means disabled.
     *
     * @return string
     */
    public function getP3pCompactPolicy()
    {
        return $this->_p3pCompactPolicy;
    }

}
