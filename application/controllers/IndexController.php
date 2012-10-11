<?php

class IndexController extends Hobo_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $this->view->latestBuild = 'hobo.beta.120717.tar.gz';
    }


}

