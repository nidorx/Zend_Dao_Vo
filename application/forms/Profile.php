<?php

class Nidorx_Form_Profile extends Nidorx_Form
{

    public function init()
    {

        $this->setAction('/profile/manage/stat/personal');
        $this->setMethod('post');

        // Texto Sobre mim
        $aboutMe = $this->createElement('textarea', 'about_me');
        $aboutMe->setLabel('About me');
        $aboutMe->addFilters(array(
            new Zend_Filter_StringTrim(),
            new Zend_Filter_StripTags(),
                // new Zend_Filter_HtmlEntities(),
        ));
        $aboutMe->setAttrib('rows', 6);
        $aboutMe->setAttrib('cols', 50);
        $this->addElement($aboutMe);


        // O gênero do usuário
        $gender = $this->createElement('select', 'gender');
        $gender->setLabel('Gender');
        $gender->setRequired(false);
        $gender->addMultiOptions(array('' => ' ', 'm' => 'Male', 'f' => 'Female'));
        $this->addElement($gender);


        //Data de nascimento do usuário
        $this->_createElementDate('birthday', 'Date of birth');


        $next = $this->createElement('submit', 'save');
        $next->setLabel('Salvar');
        $this->addElement($next);
    }

}

