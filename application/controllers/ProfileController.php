<?php

class ProfileController extends Nidorx_Controller_Action
{

    /**
     * @var Nidorx_formManage_Profile 
     *
     */
    protected $_formManage = null;
    /**
     * Business para tratamento do profile do usuário
     *
     * @var Nidorx_Business_User_Profile 
     *
     */
    protected $_bsnUserProfile = null;

    public function init()
    {
        $this->_bsnUserProfile = new Nidorx_Business_User_Profile();

        $this->_formManage = new Nidorx_Form_Profile();
        $this->_formManage->setRedirect($this->getRedirect());
    }

    public function indexAction()
    {
        // action body
    }

    /**
     * Gerencia o perfil do usuário online no momento
     *
     */
    public function manageAction()
    {
        $step = $this->_getParam('step', 'personal');


        if(!$this->_auth->getIdentity()){
            $this->autoRedirect('/');
        }

        //Faz a validação do formulário
        if ($_POST && $this->_formManage->isValid($_POST)) {
            // Salva o profile do usuário
            if ($this->_bsnUserProfile->save($_POST)) {
                //Redireciona o usuário para onde estava antes de chegar ao formulário
                $this->autoRedirect();
            }
        } else {
            $this->_formManage->populate($this->_bsnUserProfile->getToForm());
        }



        $this->view->form = $this->_formManage;
    }

}

