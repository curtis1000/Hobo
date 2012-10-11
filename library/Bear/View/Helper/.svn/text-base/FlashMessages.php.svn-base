<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_View
 * @author Konr Ness <kness@sierra-bravo.com>
 */

/**
 * Flash messages view helper
 *
 * @category Bear
 * @package Bear_View
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Bear_View_Helper_FlashMessages extends Zend_View_Helper_Abstract
{

    /**
     * Flash Messenger
     *
     * @var Zend_Controller_Action_Helper_FlashMessenger
     */
    protected $_flashMessenger;
    
    /**
     * Flash messenger namespaces to check for and display
     *
     * @var array
     */
    protected $_namespaces = array('success','notice','error');
    
    /**
     * Render flash messages
     * 
     * @return string
     */
    public function flashMessages()
    {
        $output = '';
        
        foreach ($this->getNamespaces() as $namespace) {
            if (count($messages = $this->_getFlashMessages($namespace))) {
                $output .= $this->view->htmlList($messages, false, array('class' => 'flashMessages ' . $namespace));
            }
        }
        
        return $output;
    }

    /**
     * Strategy method
     *
     * @return  string
     */
    public function direct()
    {
        return $this->flashMessages();
    }
    
    /**
     * Set supported namespaces to be checked for and displayed
     *
     * @return array
     */
    public function getNamespaces()
    {
        return $this->_namespaces;
    }
    
    /**
     * Set supported namespaces to be checked for and displayed
     *
     * @param array $namespaces
     */
    public function setNamespaces($namespaces)
    {
        $this->_namespaces = (array) $namespaces;
    }
    
    /**
     * Get instance of Flash Messenger action helper
     *
     * @return Zend_Controller_Action_Helper_FlashMessenger
     */
    public function getFlashMessenger()
    {
        if (! $this->_flashMessenger) {
            $this->_flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger');
        }
        
        return $this->_flashMessenger;
    }

    /**
     * Set instance of Flash Messenger action helper
     * 
     * @param Zend_Controller_Action_Helper_FlashMessenger $flashMessenger
     * @return Bear_View_Helper_FlashMessages
     */
    public function setFlashMessenger(Zend_Controller_Action_Helper_FlashMessenger $flashMessenger)
    {
        $this->_flashMessenger = $flashMessenger;
        return $this;
    }
    
    /**
     * Get all messages for a specific namespace
     *
     * @param string $namespace Namespace
     * @return array of Messages
     */
    protected function _getFlashMessages($namespace)
    {
        $messages = false;
        $messages = $this->getFlashMessenger()->setNamespace($namespace)->getMessages();
        
        if (! $messages) {
            // attempt to get current messages
            $messages = $this->getFlashMessenger()->setNamespace($namespace)->getCurrentMessages();
            
            if ($messages) {
                // found some, clear the current messages
                $this->getFlashMessenger()->setNamespace($namespace)->clearCurrentMessages();
            }
        }
        
        return $messages;
    }

}
