<?php

/**
 * Nidorx
 * 
 * @category  Account
 * @package   Controller
 * 
 */

/**
 * IndexController
 * 
 * @category  Account
 * @package   Controller
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 * 
 */
class Account_CreateController extends Nidorx_Controller_Action
{

    /**
     * Formulário usado no cadastro de um novo usuário para o sistema
     * 
     * @var Nidorx_Form_Profile 
     */
    protected $_form;
    /**
     * Business de para tratamento de criação de usuário
     * 
     * @var Nidorx_Business_User_Create
     */
    protected $_bsnUserCreate;

    /**
     * Inicializa os objetos
     */
    public function init()
    {
        $this->_form = new Account_Form_Create();
        // Adiciona no formulário o campo de redirecionamento
        $this->_form->setRedirect($this->getRedirect());

        $this->_bsnUserCreate = new Nidorx_Business_User_Create();
    }

    /**
     * Exibe o formulário de cadastro nas aplicações humrum
     */
    public function indexAction()
    {
        //Faz a validação do formulário
        if ($_POST && $this->_bsnUserCreate->validateForm($this->_form, $_POST)) {

            //Cria o usuário 
            if ($this->_bsnUserCreate->create($_POST)) {
                // Se o usuário foi criado corretamente, já autentica o usuário no sistema
                if ($this->_bsnUserCreate->authenticate($this->_getParam('username'), $this->_getParam('password'))) {
                    // e o redireciona para página que ele estava navegando ao iniciar
                    // o cadastro
                    $this->autoRedirect();
                } else {
                    // Se nao for possível autenticar, redireciona-o para
                    // a tela de login
                    $this->_redirect('/account/login', array('redirect' => $this->getRedirect()));
                }
            }
        }

        $this->view->form = $this->_form;
    }

}

