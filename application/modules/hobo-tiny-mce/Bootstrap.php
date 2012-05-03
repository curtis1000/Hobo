<?php
/* Hobo TinyMce Module Bootstrap
 *
 * @category Application
 * @package Module
 * @subpackage Bootstrap
 * @author Adam Meech <ameech@nerdery.com>
 * @version $Id$
 */
class HoboTinyMce_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function _initPlugins()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Hobo_Controller_Plugin_TinyMce());
    }
}