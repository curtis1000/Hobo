<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initRoutes()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();

        $router->addRoute(
            "public-home",
            new Zend_Controller_Router_Route(
                "/",
                array(
                    "module"     => "default",
                    "controller" => "index",
                    "action"     => "index",
                )
            )
        );
    }
}

