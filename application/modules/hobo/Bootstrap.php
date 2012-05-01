<?php

class Hobo_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function _initPlugins()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Hobo_Controller_Plugin_Output());
    }
    
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
        
        $router->addRoute(
            "hobo-ajax-save",
            new Zend_Controller_Router_Route(
                "/hobo/ajax/save",
                array(
                    "module"     => "hobo",
                    "controller" => "ajax",
                    "action"     => "save",
                )
            )
        );

        $router->addRoute(
            "hobo-ajax-select-latest",
            new Zend_Controller_Router_Route(
                "/hobo/ajax/select-latest",
                array(
                    "module"     => "hobo",
                    "controller" => "ajax",
                    "action"     => "select-latest",
                )
            )
        );

        $router->addRoute(
            "hobo-installer",
            new Zend_Controller_Router_Route(
                "/hobo/installer",
                array(
                    "module"     => "hobo",
                    "controller" => "installer",
                    "action"     => "index",
                )
            )
        );

        $router->addRoute(
            "hobo-installer-installed",
            new Zend_Controller_Router_Route(
                "/hobo/installer/installed",
                array(
                    "module"     => "hobo",
                    "controller" => "installer",
                    "action"     => "installed",
                )
            )
        );
    }
}