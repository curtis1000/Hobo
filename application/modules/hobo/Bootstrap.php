<?php

class Chalkboard_Bootstrap extends ThreeDst_Application_Module_Bootstrap
{
    protected function _initRoutes()
    {
        $router = $this->getApplication()
                       ->bootstrap("frontcontroller")
                       ->getResource("frontcontroller")
                       ->getRouter();

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