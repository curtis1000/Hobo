<?php

class Hobo_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function _initRoutes()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();

        $router->addRoute(
            "hobo-ajax-is-admin",
            new Zend_Controller_Router_Route(
                "/hobo/ajax/is-admin",
                array(
                    "module"     => "hobo",
                    "controller" => "ajax",
                    "action"     => "is-admin",
                )
            )
        );
    }
}