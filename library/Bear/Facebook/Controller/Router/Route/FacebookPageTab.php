<?php
/**
 * BEAR
 *
 * @category Bear
 * @package  Bear_Facebook
 * @author   Konr Ness <konr.ness@nerdery.com>
 */

/**
 * Facebook page tab route
 *
 * @category Bear
 * @package  Bear_Facebook
 * @author   Konr Ness <konr.ness@nerdery.com>
 * @version  $Id$
 */
class Bear_Facebook_Controller_Router_Route_FacebookPageTab
    extends Zend_Controller_Router_Route_Module
{
    /**
     * Key for JSON object to be used for passing app_data to request
     *
     * @var string
     */
    protected $_appDataUrlKey = 'url';

    /**
     * @var Bear_Facebook
     */
    protected $_facebook;

    /**
     * Assembles user submitted parameters forming a Facebook
     * Page URL path defined by this route
     *
     * @param array $data An array of variable and value pairs used as parameters
     * @param bool $reset Whether to reset the current params
     * @param bool $encode Whether to reset the current params
     * @return string Route path with user submitted parameters
     */
    public function assemble($data = array(), $reset = false, $encode = false)
    {
        $url = parent::assemble($data, $reset, $encode);

        $appDataValue = $this->_encodeAppData($url);
        
        return $this->getFacebook()->getPageTabUrl()
               . (strstr($this->getFacebook()->getPageTabUrl(), '?') === false ? '?' : '&')
               . 'app_data='
               . ($encode ? urlencode($appDataValue) : $appDataValue);
    }

    /**
     * Checks if request is a Facebook signed request with app_data and
     * attempts to route the request based off of route params in the app_data
     *
     * @param string $path Is not used since the Facebook signed request is used instead
     * @return array|false An array of assigned values or a false on a mismatch
     */
    public function match($path)
    {
        // check if Facebook has a signed request
        $signedRequest = $this->getFacebook()->getSignedRequest();
        
        if (! $signedRequest) {
            return false;
        }

        // check if signed request has app data
        if (! isset($signedRequest['app_data'])) {
            return false;
        }

        $decodedAppData = $this->_decodeAppData($signedRequest['app_data']);

        if (! $decodedAppData) {
            return false;
        }

        return parent::match($decodedAppData);
    }

    /**
     * Set key for JSON object to be used for passing app_data to request
     *
     * @param string $appDataUrlKey
     * @return Bear_Facebook_Controller_Router_Route_FacebookPageTab
     */
    public function setAppDataUrlKey($appDataUrlKey)
    {
        $this->_appDataUrlKey = $appDataUrlKey;
        return $this;
    }

    /**
     * Get key for JSON object to be used for passing app_data to request
     *
     * @throws UnexpectedValueException if not set
     * @return string
     */
    public function getAppDataUrlKey()
    {
        if (! $this->_appDataUrlKey) {
            throw new UnexpectedValueException('App data key not set');
        }
        return $this->_appDataUrlKey;
    }

    /**
     * Set facebook object
     *
     * @param Bear_Facebook $facebook
     * @return Bear_Facebook_Controller_Router_Route_FacebookPageTab
     */
    public function setFacebook(Bear_Facebook $facebook)
    {
        $this->_facebook = $facebook;
        return $this;
    }

    /**
     * Get facebook object
     *
     * @throws UnexpectedValueException if not set
     * @return Bear_Facebook
     */
    public function getFacebook()
    {
        if (! $this->_facebook) {
            throw new UnexpectedValueException('Facebook not set');
        }
        return $this->_facebook;
    }

    /**
     * Encode the request params into JSON-encoded app data
     *
     * @param string $url Relative URL
     * @return string
     */
    protected function _encodeAppData($url)
    {
        $appData = array(
            $this->getAppDataUrlKey() => $url,
        );
        
        return Zend_Json::encode($appData);
    }

    /**
     * Decode the app data JSON data into request params
     *
     * @param string $encodedParams
     * @return array
     */
    protected function _decodeAppData($encodedParams)
    {
        try {
            $appData = Zend_Json::decode($encodedParams);
        } catch (Zend_Json_Exception $e) {
            return array();
        }

        if (isset($appData[$this->getAppDataUrlKey()]) && is_string($appData[$this->getAppDataUrlKey()])) {
            return $appData[$this->getAppDataUrlKey()];
        }

        return array();
    }

}
