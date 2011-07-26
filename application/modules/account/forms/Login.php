<?php

class Account_Form_Login extends Nidorx_Form
{

    public function __construct($options = null)
    {
        parent::__construct($options);
    }

    public function init()
    {
        $this->setAction('/account/login');

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
        $submit->setLabel('form_label_login');
        $this->addElement($submit);
    }

}

