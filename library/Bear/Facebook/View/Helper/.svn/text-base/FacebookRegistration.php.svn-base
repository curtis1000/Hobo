<?php
/**
 * BEAR
 *
 * @category Bear
 * @package  Bear_Facebook
 * @author   Konr Ness <konr.ness@nerdery.com>
 */

/**
 * Facebook JS registration plugin
 *
 * @category Bear
 * @package  Bear_Facebook
 * @author   Konr Ness <konr.ness@nerdery.com>
 * @version  $Id$
 */
class Bear_Facebook_View_Helper_FacebookRegistration
    extends Zend_View_Helper_HtmlElement
{
    /**
     * @var Bear_Facebook
     */
    protected $_facebook;

    /**
     * Generate iframe for displaying Facebook registration plugin
     *
     * @param string $redirectUri OPTIONAL Where to redirect the user to after registering
     * @param array $fields OPTIONAL List of Facebook profile data fields to request from the user
     * @param array $attribs OPTIONAL HTML attributes for iframe element
     * @param array $params OPTIONAL Additional URL parameters for the src of the iframe
     * @return string
     * @see http://developers.facebook.com/docs/plugins/registration/
     */
    public function facebookRegistration($redirectUri, $fields, $attribs = null, $params = null)
    {
        $attribs = (array) $attribs;
        $defaultAttribs = $this->_getDefaultAttribs();

        $defaultAttribs['src'] = 'https://www.facebook.com/plugins/registration.php?'
                               . 'client_id=' . $this->getFacebook()->getAppId()
                               . '&redirect_uri=' . urlencode($redirectUri)
                               . '&fields=' . urlencode($this->_encodeFields($fields));

        if ($params) {
            foreach ($params as $name => $value) {
                $defaultAttribs['src'] .= '&' . urlencode($name) . '=' . urlencode($value);
            }
        }

        $attribs = $attribs + $defaultAttribs;

        return '<iframe' . $this->_htmlAttribs($attribs) . '></iframe>';
    }

    /**
     * Each field in the array can either be a string field names,
     * or an array with [name, description, and type] indexes.
     *
     * @param array $fields
     * @return string JSON encoded format fields
     */
    protected function _encodeFields($fields)
    {
        $output = array();

        foreach ($fields as $field) {
            if (! is_array($field)) {
                // built-in Facebook value
                $field = array('name' => $field);
            } else {
                // required fields for custom form elements
                if (
                    ! isset($field['name'])
                    || ! isset($field['description'])
                    || ! isset($field['type'])
                ) {
                    throw new Zend_View_Exception('Missing required attribute for registration field');
                }
            }

            $output[] = $field;
        }

        return Zend_Json::encode($output);
    }

    /**
     * Get the default attributes
     *
     * @return array
     */
    protected function _getDefaultAttribs()
    {
        return array(
            'scrolling'         => 'auto',
            'frameborder'       => 'no',
            'style'             => 'border:none',
            'allowTransparency' => 'true',
            'width'             => '100%',
            'height'            => '330',
        );
    }

    /**
     * Set Facebook SDK
     *
     * @param Bear_Facebook $facebook
     * @return Bear_Facebook_View_Helper_FacebookRegistration
     */
    public function setFacebook($facebook)
    {
        $this->_facebook = $facebook;
        return $this;
    }

    /**
     * Get the Facebook SDK
     *
     * @return Bear_Facebook
     */
    public function getFacebook()
    {
        if (! $this->_facebook) {
            throw new Zend_View_Exception('Facebook not set');
        }
        return $this->_facebook;
    }
}