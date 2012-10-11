<?php
/**
 * BEAR
 *
 * @category Bear
 * @package  Bear_Facebook
 * @author   Konr Ness <konr.ness@nerdery.com>
 */

/**
 * This allows for only including the version of base_facebook.php that is
 * a part of the Bear library if the BaseFacebook class is not already defined
 */
if (!class_exists('BaseFacebook')) {
    require_once dirname(realpath(__FILE__)) . '/Facebook/_external/base_facebook.php';
}
/**
 * Facebook SDK class
 *
 * @category Bear
 * @package  Bear_Facebook
 * @author   Konr Ness <konr.ness@nerdery.com>
 * @version  $Id$
 */
class Bear_Facebook extends BaseFacebook
{
    /**
     * @var string
     */
    protected $_pageTabUrl;

    /**
     * @var string
     */
    protected $_canvasUrl;

    /**
     * @var string
     */
    protected $_pageId;

    /**
     * Default list of permissions to request when logging the user in
     * A comma-separated list of requested extended perms
     *
     * @var string
     */
    protected $_defaultScope;

    /**
     * @var Zend_Session_Namespace
     */
    protected $_sessionNamespace;

    /**
     * Identical to the parent constructor, except that
     * we start a Zend_Session_Namespace to store the user ID and
     * access token if during the course of execution
     * we discover them.
     *
     * @param array $config the application configuration.
     * @see BaseFacebook::__construct in facebook.php
     */
    public function __construct($config)
    {

        if (isset($config['pageTabUrl'])) {
            $this->setPageTabUrl($config['pageTabUrl']);
            unset($config['pageTabUrl']);
        }

        if (isset($config['canvasUrl'])) {
            $this->setCanvasUrl($config['canvasUrl']);
            unset($config['canvasUrl']);
        }

        if (isset($config['pageId'])) {
            $this->setPageId($config['pageId']);
            unset($config['pageId']);
        }

        if (isset($config['defaultScope'])) {
            $this->setDefaultScope($config['defaultScope']);
            unset($config['defaultScope']);
        }

        $this->_sessionNamespace = new Zend_Session_Namespace('Bear_Facebook_' . $config['appId']);

        parent::__construct($config);

        // attempt to fetch the signed request so it can be cached to the session
        $this->getSignedRequest();

    }

    /**
     * Maintain a cache of the signed_request in the session. This will allow for
     * getting values out of the signed_request even on subsequent page loads where
     * the signed_request is not provided.
     *
     * ex. $signedRequest['page']['liked']
     *
     * @param boolean $getFromSession OPTIONAL If true, will attempt to get the cached signed request from session
     * @return string|void
     */
    public function getSignedRequest($getFromSession = false)
    {
        $signedRequest = parent::getSignedRequest();

        // save the signed request to session for use on subsequent page loads
        if ($signedRequest) {
            $this->setPersistentData('signed_request', $signedRequest);
        }

        if (!$signedRequest && $getFromSession) {
            return $this->getPersistentData('signed_request', null);
        }

        return $signedRequest;
    }

    /**
     * Set the URL for the Facebook page's application tab
     *
     * Examples:
     *  - http://www.facebook.com/MyBrand?v=app_161885633874138
     *  - http://www.facebook.com/pages/MyBrand/156377554403712?sk=app_165940713440192
     *
     * @param string $pageTabUrl
     * @return Bear_Facebook
     */
    public function setPageTabUrl($pageTabUrl)
    {
        $this->_pageTabUrl = $pageTabUrl;
        return $this;
    }

    /**
     * Get the URL for the Facebook page's application tab
     *
     * @return string|null
     */
    public function getPageTabUrl()
    {
        return $this->_pageTabUrl;
    }

    /**
     * Set the URL for the Facebook application's canvas page
     *
     * Example:
     *  - http://apps.facebook.com/myappnamespace/
     *
     * @param string $canvasUrl
     */
    public function setCanvasUrl($canvasUrl)
    {
        // normalize URL
        $canvasUrl = rtrim($canvasUrl, '/');

        $this->_canvasUrl = $canvasUrl;
    }

    /**
     * Get the URL for the Facebook application's canvas page
     *
     * @return string
     */
    public function getCanvasUrl()
    {
        return $this->_canvasUrl;
    }

    /**
     * Set the Page ID for the Facebook page's application tab
     *
     * This is used to make sure a tab request comes from an authorized Facebook page
     *
     * @param string $pageId
     * @return Bear_Facebook
     */
    public function setPageId($pageId)
    {
        $this->_pageId = $pageId;
        return $this;
    }

    /**
     * Get the URL for the Facebook page's application tab
     *
     * @return string|null
     */
    public function getPageId()
    {
        return $this->_pageId;
    }

    /**
     * Provides the implementations of the inherited abstract
     * methods.  This implementation uses Zend sessions to maintain
     * a store for user ids and access tokens.
     */

    /**
     * Set persisted data to session
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    protected function setPersistentData($key, $value)
    {
        $this->_sessionNamespace->{$key} = $value;
    }

    /**
     * Retrieve persisted data from session
     *
     * @param string $key
     * @param mixed $default OPTIONAL default is false
     * @return mixed
     */
    protected function getPersistentData($key, $default = false)
    {
        return isset($this->_sessionNamespace->{$key}) ?
                $this->_sessionNamespace->{$key} : $default;
    }

    /**
     * Remove persisted data from session
     *
     * @param mixed $key
     * @return void
     */
    protected function clearPersistentData($key)
    {
        unset($this->_sessionNamespace->{$key});
    }

    /**
     * Clear all persisted data from session
     *
     * @return void
     */
    protected function clearAllPersistentData()
    {
        foreach ($this->_sessionNamespace as $key => $value) {
            unset($this->_sessionNamespace->{$key});
        }
    }

    /**
     * A comma separated list of requested extended perms
     *
     * @param string $defaultScope
     * @return Bear_Facebook
     */
    public function setDefaultScope($defaultScope)
    {
        $this->_defaultScope = $defaultScope;
        return $this;
    }

    /**
     * A comma separated list of requested extended perms
     *
     * @return string|null
     */
    public function getDefaultScope()
    {
        return $this->_defaultScope;
    }

    /**
     * Set the current list of permissions to request when logging the user in
     * A comma-separated list of requested extended perms
     *
     * This value is stored in the session so it persists between requests
     * during the login process
     * 
     * @param string $currentScope
     * @return Bear_Facebook
     */
    public function setCurrentScope($currentScope)
    {
        $this->setPersistentData('currentScope', $currentScope);
        return $this;
    }

    /**
     * Retrieve current permissions scope from persistent
     * data if set, or get the default scope if not
     *
     * @return string
     */
    public function getCurrentScope()
    {
        return $this->getPersistentData('currentScope', $this->getDefaultScope());
    }

    /**
     * Retrieves the user access token from the user's session
     *
     * @return string
     */
    public function getSessionAccessToken()
    {
        return $this->getPersistentData('access_token');
    }

}
