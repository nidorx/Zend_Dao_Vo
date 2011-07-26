<?php

/**
 * Nidorx
 *
 * @category  Application
 * @package   Business
 * @subpackage User
 */

/**
 * Business para tratamento da criação de novo usuário
 *
 * @category  Application
 * @package   Business
 * @subpackage User
 */
class Nidorx_Business_User_Create extends Nidorx_Business_User
{

    /**
     * Faz a validação do formulário de usergroup (usado pelo Admin)
     * 
     * @param Nidorx_Form $form
     * @param Array $data 
     */
    public function validateForm(Zend_Form $form, $data)
    {

        if ($form->isValid($data)) {

            $translator = new Nidorx_Translator();

            $username = $form->getElement('username')->getValue();
            if ($this->_daoUser->getByUsername($username)) {
                $form->getElement('username')->addError($translator->translate('error_username_in_use'));
                $form->addError($translator->translate('error_username_in_use'));
            }

            //Verificando se o email já está em uso
            $email = $form->getElement('email')->getValue();
            if ($this->_daoUser->getByEmail($email)) {
                $form->getElement('email')->addError($translator->translate('error_email_in_use'));
                $form->addError($translator->translate('error_email_in_use'));
            }
        };

        return!$form->isErrors();
    }

    /**
     * Cria um novo usuário
     * 
     * @param array $data
     * @return Nidorx_Bridge_Output 
     */
    public function create(array $data)
    {
        //Criptografando a senha digitada
        if (isset($data['password'])) {
            $data['password'] = md5($data['password']);
        }

        //Passando os dados da requisição para um VO
        $voUser = new Nidorx_Model_Vo_User($data);

        //Passando o Vo para o Dao
        return $this->_daoUser->save($voUser);
    }

}