<?php

class Account_LogoutController extends Nidorx_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        $this->_auth->clearIdentity();
        $this->autoRedirect();
    }

}

