<?php

/**
 * Nidorx
 * 
 * @category  Application
 * @package   Controller
 * 
 */

/**
 * IndexController
 * 
 * @category  Application
 * @package   Controller
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 * 
 */
class IndexController extends Nidorx_Controller_Action
{

    /**
     * A business de profile
     * 
     * @var Nidorx_Business_User_Profile
     */
    protected $_bsnUserProfile;

    public function init()
    {
        $this->_bsnUserProfile = new Nidorx_Business_User_Profile();
    }

    /**
     * Action inicial do sistema
     */
    public function indexAction()
    {
        $auth = Zend_Auth::getInstance();
        $identity = $auth->getIdentity();
        if ($identity) {
            $this->view->identity = $identity;
            //Obtém o profile do usuario
            $this->view->profile = $this->_bsnUserProfile->get();
        }
    }

}

