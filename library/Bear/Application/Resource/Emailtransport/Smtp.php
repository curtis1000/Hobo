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
 * SMTP resource class
 *
 * @category Bear
 * @deprecated
 * @package Bear_Application
 */
class Bear_Application_Resource_Emailtransport_Smtp extends Zend_Application_Resource_ResourceAbstract
{

    /**
     * Flag for default transport
     * @var boolean
     */
    protected $_defaultTransport = false;

    /**
     * Hostname
     * @var string
     */
    protected $_host;

    /**
     * Initialize the SMTP transport
     *
     * @return Zend_Mail_Transport_Smtp
     */
    public function init()
    {
        $options = $this->getOptions();

        /** Zend_Mail_Transport_Smtp */
        require_once "Zend/Mail/Transport/Smtp.php";

        if (isset($options["options"])) {
            $smtp = new Zend_Mail_Transport_Smtp(
                $this->_host,
                $options["options"]
            );
        } else {
            $smtp = new Zend_Mail_Transport_Smtp(
                $this->_host
            );
        }

        if ($this->_defaultTransport) {
            /** Zend_Mail */
            require_once "Zend/Mail.php";

            Zend_Mail::setDefaultTransport($smtp);
        }

        return $smtp;
    }

    /**
     * Set the transport as the Zend_Mail default
     *
     * @param boolean $defaultTransport
     * @return Bear_Application_Resource_Emailtransport_Smtp
     */
    public function setDefaultTransport($defaultTransport)
    {
        $this->_defaultTransport = $defaultTransport;

        return $this;
    }

    /**
     * Set the host name
     *
     * @param string $host
     * @return Bear_Application_Resource_Emailtransport_Smtp
     */
    public function setHost($host)
    {
        $this->_host = $host;

        return $this;
    }

}
