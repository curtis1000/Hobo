<?php
/**
 * BEAR
 *
 * @author Konr Ness <konr.ness@sierra-bravo.com>
 * @category Bear
 * @package Bear_Application
 * @since 1.1.0
 */

/**
 * Facebook resource class
 *
 * @category Bear
 * @package Bear_Application
 */
class Bear_Application_Resource_Facebook extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * @var Bear_Facebook
     */
    protected $_facebook;

    /**
     * Initialize resource
     *
     * @return Bear_Facebook
     */
    public function init()
    {
        $facebook = $this->getFacebook();

        // add helper namespace path for action helpers
        Zend_Controller_Action_HelperBroker::addPath(
            "Bear/Facebook/Controller/Action/Helper",
            'Bear_Facebook_Controller_Action_Helper'
        );
        
        // initialize static Facebook helper
        $facebookHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('facebook');
        $facebookHelper->setFacebook($facebook);

        $this->_initPageTabRoute($facebook);

        $this->_initAuthAdapter($facebook);

        $this->_initActionHelpers($facebook);

        $this->_initP3pCompactPolicy($facebookHelper);

        // add helper namespace path for view helpers
        /** @var $view Zend_View */
        $view = $this->getBootstrap()->bootstrap('view')->getResource('view');
        $view->addHelperPath(
            'Bear/Facebook/View/Helper',
            'Bear_Facebook_View_Helper_'
        );

        $view->getHelper('facebookInit')->setFacebook($facebook);
        $view->getHelper('facebookRegistration')->setFacebook($facebook);

        return $facebook;
    }

    /**
     * Get singleton instance of Bear_Facebook
     * 
     * Required options:
     *  - appId: the application ID
     *  - secret: the application secret
     *
     * Optional options:
     *  - fileUpload: boolean indicating if file uploads are enabled
     *
     * All other config options are ignored
     *
     * @return Bear_Facebook
     */
    public function getFacebook()
    {
        if (! $this->_facebook) {

            $options = $this->getOptions();

            // if a custom facebook base SDK was specified, include this first
            if (isset($options['sdkPath'])) {
                require_once $options['sdkPath'];
                unset($options['sdkPath']);
            }

            $this->_facebook = new Bear_Facebook($options);
        }

        return $this->_facebook;
    }

    /**
     * Setup the facebook page tab route if the page tab URL was provided
     *
     * @param Bear_Facebook $facebook
     * @return void
     */
    protected function _initPageTabRoute(Bear_Facebook $facebook)
    {
        if ($facebook->getPageTabUrl()) {

            $frontController = $this->getBootstrap()
                                    ->bootstrap('frontcontroller')
                                    ->getResource('frontcontroller');

            $dispatcher = $frontController->getDispatcher();
            $request = $frontController->getRequest();

            $facebookRoute = new Bear_Facebook_Controller_Router_Route_FacebookPageTab(array(), $dispatcher, $request);

            $facebookRoute->setFacebook($facebook);

            $frontController->getRouter()->addRoute('facebookPageTab', $facebookRoute);
        }
    }

    protected function _initAuthAdapter(Bear_Facebook $facebook)
    {
        $options = $this->getOptions();
        
        if (! empty($options['authAdapter'])) {
            $authAdapter = new Bear_Facebook_AuthAdapter();
            $authAdapter->setFacebook($facebook);

            $facebookHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('facebook');
            $facebookHelper->setAuthAdapter($authAdapter);

        }
    }

    protected function _initActionHelpers(Bear_Facebook $facebook)
    {
        Zend_Controller_Action_HelperBroker::getStaticHelper('assertValidAccessToken')
                                           ->setFacebook($facebook);
    }

    protected function _initP3pCompactPolicy(Bear_Facebook_Controller_Action_Helper_Facebook $facebookHelper)
    {
        $options = $this->getOptions();

        if (isset($options['p3pCompactPolicy'])) {
            $facebookHelper->setP3pCompactPolicy($options['p3pCompactPolicy']);
        }
    }
}
