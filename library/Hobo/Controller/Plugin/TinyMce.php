<?php
/* Hobo TinyMce Controller Plugin
 *
 * @category Hobo
 * @package Controller
 * @subpackage Plugin
 * @author Adam Meech <ameech@nerdery.com>
 * @version $Id$
 */
class Hobo_Controller_Plugin_TinyMce extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch()
    {
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');

        if (null === $viewRenderer->view) {
            $viewRenderer->initView();
        }
        $view = $viewRenderer->view;
        $view->headScript()->appendFile($view->baseUrl() . '/hobo/tiny-mce/hobo-tiny-mce.js');
        $view->headScript()->appendFile($view->baseUrl() . '/hobo/tiny-mce/tiny_mce/tiny_mce.js');
    }
}