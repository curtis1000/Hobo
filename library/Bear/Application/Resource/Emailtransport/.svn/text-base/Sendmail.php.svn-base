<?php
/**
 * BEAR
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Application
 * @since 1.1.0
 */

/** Zend_Application_Resource_ResourceAbstract */
require_once "Zend/Application/Resource/ResourceAbstract.php";

/**
 * Sendmail resource class
 *
 * @category Bear
 * @deprecated
 * @package Bear_Application
 */
class Bear_Application_Resource_Emailtransport_Sendmail extends Zend_Application_Resource_ResourceAbstract
{

    /**
     * Flag for default transport
     * @var boolean
     */
    protected $_defaultTransport = false;

    /**
     * Parameters for sendmail
     * @var string
     */
    protected $_parameters;

    /**
     * Initialize sendmail transport
     *
     * @return Zend_Mail_Transport_Sendmail
     */
    public function init()
    {
        /** Zend_Mail_Transport_Sendmail */
        require_once "Zend/Mail/Transport/Sendmail.php";

        $sendmail = new Zend_Mail_Transport_Sendmail(
            $this->_parameters
        );

        if ($this->_defaultTransport) {
            Zend_Mail::setDefaultTransport($sendmail);
        }

        return $sendmail;
    }

    /**
     * Set the transport as the Zend_Mail default
     *
     * @param boolean $defaultTransport
     * @return Bear_Application_Resource_Emailtransport_Sendmail
     */
    public function setDefaultTransport($defaultTransport)
    {
        $this->_defaultTransport = $defaultTransport;

        return $this;
    }

    /**
     * Set the parameters
     *
     * @param string $parameters
     * @return Bear_Application_Resource_Emailtransport_Sendmail
     */
    public function setParameters($parameters)
    {
        $this->_parameters = $parameters;

        return $this;
    }

}