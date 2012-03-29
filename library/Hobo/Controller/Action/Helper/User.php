<?php

class Hobo_Controller_Action_Helper_User extends Zend_Controller_Action_Helper_Abstract {
    
    public function isAdmin() {
        return true;
    }
}