<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_Base
 * @since 1.1.0
 */

/**
 * Bear base interface
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Base
 */
interface Bear_Base_Interface
{

    /**
     * Set the options from a Zend_Config object
     *
     * @param Zend_Config $config
     * @return Bear_Controller_Action_Helper_Abstract
     */
    public function setConfig(Zend_Config $config);

    /**
     * Set the options from an array
     *
     * @param array $options
     * @return Bear_Controller_Action_Helper_Abstract
     */
    public function setOptions(array $options);

}
