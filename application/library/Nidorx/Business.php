<?php

/**
 * Nidorx
 *
 * @category   Library
 */

/**
 *  Classe para tratamento dos negócios dos dados provenientes da model
 *
 * @category   Library
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Business
{

    /**
     * Identidade do usuário na sessao
     * 
     * @var Nidorx_Model_Vo_User
     */
    protected $_userIdentity;

    /**
     *  Instâncias e operações necessárias para execução da Business.
     */
    public function __construct()
    {
        $this->_userIdentity = Zend_Auth::getInstance()->getIdentity();
        $this->init();
    }

    /**
     * Faz as inicializações necessárias na business
     */
    protected function init()
    {
        
    }

    /**
     * Faz a validação do formulário 
     * 
     * @param Nidorx_Form $form
     * @param Array $data 
     */
    public function validateForm(Zend_Form $form, $data)
    {

        if ($form->isValid($data)) {
            return true;
        };

        return false;
    }

}