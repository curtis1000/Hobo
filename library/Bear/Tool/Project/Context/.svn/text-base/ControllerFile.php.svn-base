<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Tool
 */

/**
 * Controller File Context
 *
 * @category Bear
 * @package Bear_Tool
 * @author Konr Ness <konr.ness@sierra-bravo.com>
 * @version $Id$
 */
class Bear_Tool_Project_Context_ControllerFile 
    extends Zend_Tool_Project_Context_Zf_ControllerFile
{

    /**
     * getContents()
     *
     * @return string
     */
    public function getContents()
    {
        $className = ($this->_moduleName) ? ucfirst($this->_moduleName) . '_' : '';
        $className .= ucfirst($this->_controllerName) . 'Controller';
        
        if ($className != 'ErrorController') {
            return parent::getContents();
        }
    
        $codeGenFile = new Zend_CodeGenerator_Php_File(
            array(
                'fileName' => $this->getPath(),
                'classes'  => array(
                    new Zend_CodeGenerator_Php_Class(
                        array(
                            'name'          => $className,
                            'extendedClass' => 'Zend_Controller_Action',
                            'methods'       => array(
                                $this->_getInitMethod(),
                                $this->_getErrorAction(),
                                $this->_getAuthenticationRequiredAction(),
                                $this->_getForbiddenAction(),
                                $this->_getNotFoundAction(),
                                $this->_getInternalServerErrorAction(),
                                $this->_getGetLogMethod(),
                            ),
                        )
                    )
                ),
            )
        );

        // store the generator into the registry so that the addAction command can use the same object later
        Zend_CodeGenerator_Php_File::registerFileCodeGenerator($codeGenFile); // REQUIRES filename to be set
        return $codeGenFile->generate();
    }
        
    /**
     * Get init method
     *
     * @return Zend_CodeGenerator_Php_Method
     */
    protected function _getInitMethod()
    {
        return new Zend_CodeGenerator_Php_Method(
            array(
                'name'     => 'init',
                'docblock' => new Zend_CodeGenerator_Php_Docblock(
                    array(
                        'shortDescription' => 'Initialize controller',
                        'tags'             => array(
                            array(
                                'name'        => 'return',
                                'description' => 'void',
                            )
                        ),
                    )
                ),
                'body'     => <<<EOS
/**
 * Setup contexts
 */
\$contextSwitch = \$this->_helper->ajaxContext;
\$contextSwitch->addActionContext('authentication-required', array('html', 'json'))
              ->initContext();
EOS
            )
        );
    }
    
    /**
     * Get error action method
     *
     * @return Zend_CodeGenerator_Php_Method
     */
    protected function _getErrorAction()
    {
        return new Zend_CodeGenerator_Php_Method(
            array(
                'name'     => 'errorAction',
                'docblock' => new Zend_CodeGenerator_Php_Docblock(
                    array(
                        'shortDescription' => 'Error action',
                        'longDescription'  => 'Catch-all action for all unhandled exceptions thrown during dispatch',
                        'tags'             => array(
                            array(
                                'name'        => 'return',
                                'description' => 'void',
                            )
                        )
                    )
                ),
                'body'     => <<<EOS
\$errors = \$this->_getParam('error_handler');

\$this->view->exception = \$errors->exception;
\$this->view->request   = \$errors->request;

// conditionally display exceptions
\$this->view->showExceptions = (\$this->getInvokeArg('displayExceptions') == true);

switch (\$errors->type) {
    case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
    case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        \$this->_forward("not-found");
        break;

    default:
        if (\$errors->exception instanceof Zend_Controller_Action_Exception) {
            switch (true) {
                case \$errors->exception instanceof Bear_Controller_Action_Exception_NotAuthenticated:
                    \$this->_forward('authentication-required');
                    break;
                    
                case \$errors->exception instanceof Bear_Controller_Action_Exception_NotAuthorized:
                    \$this->_forward("forbidden");
                    break;
                    
                case \$errors->exception instanceof Bear_Controller_Action_Exception_ParameterMissing:
                    \$this->_forward("not-found");
                    break;
                    
                case \$errors->exception instanceof Bear_Controller_Action_Exception_ResourceNotFound:
                    \$this->_forward("not-found");
                    break;
                    
                default:
                    \$this->_forward("internal-server-error");
                    break;
            }
            
        } else {
            \$this->_forward("internal-server-error");
        }
        break;
}
EOS
            )
        );
    }

    /**
     * Get auth required action method
     *
     * @return Zend_CodeGenerator_Php_Method
     */
    protected function _getAuthenticationRequiredAction()
    {
        return new Zend_CodeGenerator_Php_Method(
            array(
                'name'     => 'authenticationRequiredAction',
                'docblock' => new Zend_CodeGenerator_Php_Docblock(
                    array(
                        'shortDescription' => 'Authentication Required Action',
                        'tags' => array(
                            array(
                                'name'        => 'return',
                                'description' => 'void',
                            )
                        )
                    )
                ),
                'body'     => <<<EOS
// json context: set the message and return immediately    
if (\$this->_helper->ajaxContext->getCurrentContext() == 'json') {
    \$this->view->success = false;
    \$this->view->status  = 'error';
    \$this->view->message = 'Your session has expired. Please login to continue.';
    
    return;
}

// set error message to flash messenger
\$this->_helper
     ->flashMessenger
     ->setNamespace('error')
     ->addMessage("You must be logged in to access that page");

// default context
if (is_null(\$this->_helper->ajaxContext->getCurrentContext())) {
    // save the current requested page in session
    // for post-login redirect
    \$loginSession = new Zend_Session_Namespace('login');
    \$loginSession->postLoginUrl = \$this->getRequest()->getRequestUri();
    
    // redirect to login page
    \$this->_helper
         ->redirector
         ->gotoRoute(
             array(
                 'module'     => 'users',
                 'controller' => 'account',
                 'action'     => 'login',
             )
         );
}
EOS
            )
        );
    }

    /**
     * Get forbidden action method
     *
     * @return Zend_CodeGenerator_Php_Method
     */
    protected function _getForbiddenAction()
    {
        return new Zend_CodeGenerator_Php_Method(
            array(
                'name'     => 'forbiddenAction',
                'docblock' => new Zend_CodeGenerator_Php_Docblock(
                    array(
                        'shortDescription' => 'Forbidden Action',
                        'tags'             => array(
                            array(
                                'name'        => 'return',
                                'description' => 'void',
                            )
                        )
                    )
                ),
                'body'     => <<<EOS
\$this->getResponse()
      ->setHttpResponseCode(403);
EOS
            )
        );
    }

    /**
     * Get not found action method
     *
     * @return Zend_CodeGenerator_Php_Method
     */
    protected function _getNotFoundAction()
    {
        return new Zend_CodeGenerator_Php_Method(
            array(
                'name'     => 'notFoundAction',
                'docblock' => new Zend_CodeGenerator_Php_Docblock(
                    array(
                        'shortDescription' => 'File Not Found Action',
                        'tags'             => array(
                            array(
                                'name'        => 'return',
                                'description' => 'void',
                            )
                        )
                    )
                ),
                'body'     => <<<EOS
// Log notice, if logger available
if (\$log = \$this->_getLog()) {
    \$log->notice(
        "Page Not Found: " 
        . \$_SERVER['REQUEST_URI'] 
        . ' - ' 
        . \$this->_getParam('error_handler')->exception->getMessage()
    );
}

\$this->getResponse()
     ->setHttpResponseCode(404);
EOS
            )
        );
    }

    /**
     * Get internal server error action method
     *
     * @return Zend_CodeGenerator_Php_Method
     */
    protected function _getInternalServerErrorAction()
    {
        return new Zend_CodeGenerator_Php_Method(
            array(
                'name'     => 'internalServerErrorAction',
                'docblock' => new Zend_CodeGenerator_Php_Docblock(
                    array(
                        'shortDescription' => 'Internal Server Error Action',
                        'tags'             => array(
                            array(
                                'name'        => 'return',
                                'description' => 'void',
                            )
                        )
                    )
                ),
                'body'     => <<<EOS
// Log exception, if logger available
if (\$log = \$this->_getLog()) {
    \$log->crit(\$this->_getParam('error_handler')->exception);
}

\$this->getResponse()
     ->setHttpResponseCode(500);
EOS
            )
        );
    }

    /**
     * Get get log method
     *
     * @return Zend_CodeGenerator_Php_Method
     */
    protected function _getGetLogMethod()
    {
        return new Zend_CodeGenerator_Php_Method(
            array(
                'name'       => '_getLog',
                'visibility' => Zend_CodeGenerator_Php_Method::VISIBILITY_PROTECTED,
                'docblock'   => new Zend_CodeGenerator_Php_Docblock(
                    array(
                        'shortDescription' => 'Get Log',
                        'tags'             => array(
                            array(
                                'name'        => 'return',
                                'description' => 'Zend_Log|false',
                            )
                        )
                    )
                ),
                'body'       => <<<EOS
\$bootstrap = \$this->getInvokeArg('bootstrap');
if (!\$bootstrap->hasPluginResource('Log')) {
    return false;
}
\$log = \$bootstrap->getResource('Log');
return \$log;
EOS
            )
        );
    }

}
