<?php
/* Hobo Plain Text Module Bootstrap
 *
 * @category Application
 * @package Module
 * @subpackage Bootstrap
 * @author Curtis Branum <cbranum@nerdery.com>
 * @version $Id$
 */
class HoboPlainText_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function _initPlugins()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Hobo_Controller_Plugin_PlainText());
    }
}