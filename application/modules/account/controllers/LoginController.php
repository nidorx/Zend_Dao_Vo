<?php

class Account_LoginController extends Nidorx_Controller_Action
{

    /**
     * Business de usuário
     * 
     * @var Nidorx_Business_User 
     */
    protected $_bsnUser;
    /**
     * Formulário de login
     * 
     * @var Application_Form_Login 
     */
    protected $_form;

    public function init()
    {
        $this->_bsnUser = new Nidorx_Business_User();

        $this->_form = new Account_Form_Login();

        $this->_form->setRedirect($this->getRedirect());
    }

    public function indexAction()
    {

        //Redireciona se acaso o usuário já estiver logado no sistema
        if ($this->_auth->getIdentity()) {
            $this->autoRedirect();
        }

        if ($_POST) {
            $validAuth = null;
            $username = null;
            $password = null;

            // Valida o formulário
            if ($this->_form->isValid($this->_request->getParams())) {
                $username = $this->_request->getParam('username');
                $password = $this->_request->getParam('password');
            }


            if ($username && $password) {
                // Tenta fazer a autenticação
                if ($this->_bsnUser->authenticate($username, $password)) {
                    $this->autoRedirect();
                } else {
                    $this->_form->getElement('username')->addError('Login e/ou Senha inválidos.');
                    $this->_form->getElement('username')->setValue($_POST['username']);
                }
            }
        }

        $this->view->form = $this->_form;
    }

}

