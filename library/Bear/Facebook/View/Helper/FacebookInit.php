<?php
/**
 * BEAR
 *
 * @category Bear
 * @package  Bear_Facebook
 * @author   Konr Ness <konr.ness@nerdery.com>
 */

/**
 * Facebook JS initializer
 *
 * @category Bear
 * @package  Bear_Facebook
 * @author   Konr Ness <konr.ness@nerdery.com>
 * @version  $Id$
 */
class Bear_Facebook_View_Helper_FacebookInit extends Zend_View_Helper_Abstract
{
    /**
     * @var Bear_Facebook
     */
    protected $_facebook;

    /**
     * Create JS code for initializing Facebook JS SDK
     *
     * @param array|null $initParams OPTIONAL
     * @return string
     * @todo Add capability of asynchronous loading: http://developers.facebook.com/docs/reference/javascript/
     */
    public function facebookInit($initParams = null)
    {
        $initParams = (array) $initParams;

        return '<script type="text/javascript">FB.init('
               . $this->_encodeFacebookInitParams($initParams)
               . ');</script>';
    }

    /**
     * Combine the custom and default init parameters and JSON encode
     *
     * @param array $initParams
     * @return string
     */
    protected function _encodeFacebookInitParams($initParams)
    {
        // allow the user-provided init params to override the defaults
        $defaultFacebookInitParams = $this->_getDefaultFacebookInitParams();
        $params = $initParams + $defaultFacebookInitParams;
        
        return Zend_Json::encode($params);
    }

    /**
     * Get the default Facebook init parameters
     *
     * @return array
     * @see https://developers.facebook.com/docs/reference/javascript/FB.init/
     */
    protected function _getDefaultFacebookInitParams()
    {
        $defaults = array(
            'appId'      => $this->getFacebook()->getAppId(),
            'cookie'     => false,
            'logging'    => true,
            'status'     => true,
            'xfbml'      => false,
            /**
             * @todo Add built-in support for channel URL
             * @see http://developers.facebook.com/docs/reference/javascript/
             */
            'channelUrl' => null,
            'oauth'      => true,
        );

        if ($this->getFacebook()->getSessionAccessToken()) {
            $defaults['authResponse'] = array(
                'accessToken' => $this->getFacebook()->getSessionAccessToken()
            );
        }

        return $defaults;
    }

    /**
     * Set Facebook SDK
     *
     * @param Bear_Facebook $facebook
     * @return Bear_Facebook_View_Helper_FacebookInit
     */
    public function setFacebook($facebook)
    {
        $this->_facebook = $facebook;
        return $this;
    }

    /**
     * Get Facebook SDK
     *
     * @return Bear_Facebook
     */
    public function getFacebook()
    {
        if (! $this->_facebook) {
            throw new Zend_View_Exception('No Facebook set');
        }
        return $this->_facebook;
    }
}