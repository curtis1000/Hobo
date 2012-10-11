<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Facebook
 * @author Konr Ness <konr.ness@nerdery.com>
 */

/**
 * Facebook auth adapter
 *
 * @category Bear
 * @package Bear_Facebook
 * @author  Konr Ness <konr.ness@nerdery.com>
 * @version $Id$
 */
class Bear_Facebook_AuthAdapter
    implements Zend_Auth_Adapter_Interface
{

    /**
     * Facebook
     *
     * @var Facebook
     */
    protected $_facebook;

    /**
     * Authenticate the user
     *
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
        $facebook = $this->getFacebook();

        // force the parsing and storage of the access token
        // from the signed request
        $facebook->getAccessToken();

        // fetch authenticated user's ID based on the signed request
        // or session access token will be 0 if they are not authenticated
        $user = $facebook->getUser();

        if ($user) {
            return new Zend_Auth_Result(
                Zend_Auth_Result::SUCCESS,
                $user
            );
        } else {
            return new Zend_Auth_Result(
                Zend_Auth_Result::FAILURE,
                null
            );
        }
    }

    /**
     * Set Facebook
     *
     * @param Bear_Facebook $facebook
     * @return Bear_Facebook_AuthAdapter
     */
    public function setFacebook(Bear_Facebook $facebook)
    {
        $this->_facebook = $facebook;
        return $this;
    }

    /**
     * Get Facebook
     *
     * @return Bear_Facebook
     * @throws UnexpectedValueException if not set
     */
    public function getFacebook()
    {
        if (!$this->_facebook) {
            throw new UnexpectedValueException('No Facebook set');
        }
        return $this->_facebook;
    }
}
