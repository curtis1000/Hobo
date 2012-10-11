<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Application
 */

/** Zend_Application_Resource_ResourceAbstract */
require_once 'Zend/Application/Resource/ResourceAbstract.php';

/**
 * Application resource to configure the request time
 *
 * Usage:
 *  resources.requestTime.configEnabled = true
 *  resources.requestTime.configValue   = "2012-01-01T00:00:00"
 *
 *
 * @author Tony Nelson <tony.nelson@nerdery.com>
 * @category Bear
 * @package Bear_Application
 */
class Bear_Application_Resource_Requesttime extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * Initialize resource
     *
     * @return Zend_Date
     */
    public function init()
    {
        $options = array_merge(array(
            'configEnabled' => false,
            'configValue'   => null,
            'configFormat'  => Zend_Date::ISO_8601,
            'paramEnabled'  => false,
            'paramName'     => 'requestTime',
            'paramFormat'   => Zend_Date::ISO_8601,
        ), $this->getOptions());

        $requestTime = null;

        if ($options['paramEnabled']
            && array_key_exists($options['paramName'], $_GET)
            && strlen($_GET[$options['paramName']])) {

            $requestTime = new Zend_Date($_GET[$options['paramName']], $options['paramFormat']);

        } else if ($options['configEnabled']
            && strlen($options['configValue'])) {

            $requestTime = new Zend_Date($options['configValue'], $options['configFormat']);

        }

        if (is_null($requestTime)) {
            $requestTime = new Zend_Date();
        }

        /** @var Bear_Controller_Action_Helper_RequestTime $requestTimeHelper */
        $requestTimeHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('requestTime');
        $requestTimeHelper->setRequestTime($requestTime);

        return $requestTime;
    }
}