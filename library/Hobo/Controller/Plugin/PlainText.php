<?php
/* Hobo Plain Text Controller Plugin
 *
 * @category Hobo
 * @package Controller
 * @subpackage Plugin
 * @author Curtis Branum <cbranum@nerdery.com>
 * @version $Id$
 */
class Hobo_Controller_Plugin_PlainText extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch()
    {
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');

        if (null === $viewRenderer->view) {
            $viewRenderer->initView();
        }
        $view = $viewRenderer->view;
        $view->headScript()->appendFile($view->baseUrl() . '/hobo/plain-text/hobo-plain-text.js');
    }
}