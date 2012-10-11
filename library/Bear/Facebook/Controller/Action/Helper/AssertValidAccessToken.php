<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Facebook
 * @author Konr Ness <konr.ness@nerdery.com>
 */

/**
 * Assert that the Facebook client has a valid access token for making Graph API calls
 *
 * @category Bear
 * @package Bear_Facebook
 * @author  Konr Ness <konr.ness@nerdery.com>
 * @version $Id$
 */
class Bear_Facebook_Controller_Action_Helper_AssertValidAccessToken
    extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * Facebook
     *
     * @var Bear_Facebook
     */
    protected $_facebook;

    /**
     * Assert that the user is logged in
     *
     * @param string $scope OPTIONAL comma separated list of requested extended perms
     * @return void
     * @throws Bear_Controller_Action_Exception_NotAuthenticated
     */
    public function direct($scope = null)
    {
        $this->assertValidAccessToken($scope);
    }

    /**
     * Assert that the user has a valid access token and has all of the
     * required permissions granted to the application
     *
     * @param string $scope OPTIONAL comma separated list of requested extended perms
     * @return void
     * @throws Bear_Controller_Action_Exception_NotAuthenticated
     */
    public function assertValidAccessToken($scope = null)
    {
        // get the list of permissions the user has granted to the application
        try {
            $response = $this->getFacebook()->api('/me/permissions');
            $currentPermissions = $response['data'][0];
        } catch (FacebookApiException $e) {
            if ($e->getType() == 'OAuthException') {
                // the user's access token is invalid
                throw new Bear_Controller_Action_Exception_NotAuthenticated();
            } else {
                // rethrow the exception
                throw $e;
            }
        }

        if (null === $scope) {
            $scope = $this->getFacebook()->getCurrentScope();
        }

        // non-empty scope is a comma-separated list of perms
        $requiredPermissions = empty($scope) ? array() : explode(',', $scope);

        if (array_diff($requiredPermissions, array_keys($currentPermissions))) {
            // save to the session the permissions scope that was requested
            // so that the login page requests the proper permissions
            $this->getFacebook()->setCurrentScope($scope);

            // the user is missing a particular access permission
            throw new Bear_Controller_Action_Exception_NotAuthenticated();
        }
    }

    /**
     * Set Facebook object
     *
     * @param Bear_Facebook $facebook
     * @return Bear_Facebook_Controller_Action_Helper_AssertValidAccessToken
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


}