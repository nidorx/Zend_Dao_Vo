<?php

class UserController extends Nidorx_Controller_Action
{

    /**
     *
     * @var Nidorx_Business_User_Profile 
     */
    protected $_bsnUserProfile;

    public function init()
    {
        $this->_bsnUserProfile = new Nidorx_Business_User_Profile();
    }

    public function indexAction()
    {
        // action body
    }

    /**
     * Renderiza o menu superior
     */
    public function menuAction()
    {
        $toshow = array();
        $identity = $this->_auth->getIdentity();
        if ($identity) {
            $profile = $this->_bsnUserProfile->get();
            $this->view->profile = $profile;
        }


        if ($identity) {
            $toshow['profile'] = true;
        } else {
            $toshow['login'] = true;
        }

        $this->view->toshow = $toshow;
        $this->view->identity = $identity;

        //Cria o redirecionador
        $this->createRedirect();
    }

}

