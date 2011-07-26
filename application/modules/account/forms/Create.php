<?php

/**
 * Nidorx
 * 
 * @category  Nidorx
 * @package   Account
 * @subpackage Form
 * @version    $Id: $
 * 
 */

/**
 * Account_Form_Create
 * 
 * Formulário de cadastro de usuário
 * 
 * @category  Nidorx
 * @package   Account
 * @subpackage Form
 * @author Alex Rodin - nidor.x@gmail.com
 */
class Account_Form_Create extends Nidorx_Form
{

    /**
     * Primeiro passo do cadastro, contendo poucos dados
     */
    public function init()
    {
        $this->setAction('/account/create');
        $this->setMethod('post');

        // Nome completo do usuário
        $name = $this->createElement('text', 'name');
        $name->setLabel(' Full name');
        $name->setRequired(true);
        $name->addFilters(array(
            new Zend_Filter_StringTrim(),
            new Zend_Filter_StringToLower,
            new Zend_Filter_StripTags(),
            new Zend_Filter_Alpha(true)
        ));
        $name->setAttrib('size', 40);
        $this->addElement($name);


        // Email do usuário
        $email = $this->createElement('text', 'email');
        $email->setLabel('form_label_email');
        $email->setRequired(true);
        $email->addValidator(new Zend_Validate_EmailAddress());
        $email->addFilters(array(
            new Zend_Filter_StringTrim(),
            new Zend_Filter_StringToLower,
            new Zend_Filter_StripTags()
        ));
        $email->setAttrib('size', 40);
        $this->addElement($email);

        // Nome de usuário no sistema
        $username = $this->createElement('text', 'username');
        $username->setLabel('form_label_username');
        $username->setRequired(true);
        $username->addFilters(array(
            new Zend_Filter_StringTrim(),
            new Zend_Filter_StringToLower,
            new Zend_Filter_StripTags()
        ));
        $username->setAttrib('size', 40);
        $this->addElement($username);


        // Password do usuário
        $passwd = $this->createElement('password', 'password');
        $passwd->setLabel('form_label_password');
        $passwd->addValidator(new Zend_Validate_StringLength(array('min' => 6, 'max' => 1000)));
        $passwd->setRequired(true);
        $passwd->setAttrib('size', 30);
        $passwd->setAttrib('class', 'texto-medio');
        $this->addElement($passwd);

        // Botão submit
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel('form_label_createmyaccount');

        $this->addElement($submit);
    }

}

