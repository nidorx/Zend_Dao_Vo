<?php

/**
 * Nidorx
 *
 * @category  Model
 * @package   Vo
 * @subpackage User
 */

/**
 * Classe Vo de profile de usuário
 *
 * @category  Model
 * @package   Vo
 * @subpackage User
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Model_Vo_User_Profile extends Nidorx_Model_Vo
{

    /**
     * Id do profile
     * 
     * @var MongoId 
     */
    public $id;
    /**
     * Id do usuário
     * 
     * @var MongoId 
     */
    public $userId;
    /**
     * Frase 'sobre mim' do usuário
     * 
     * @var string 
     */
    public $aboutMe;
    /**
     * Sexo do usuário m|f|null
     * 
     * @var char 
     */
    public $gender = null;
    public $birthdayYear;
    public $birthdayMonth;
    public $birthdayDay;
    /**
     * Data de nascimento do usuário
     * 
     * @var Nidorx_Model_Vo_Common_Date 
     */
    public $birthday;

    /**
     * Usado para setar a propriedade birthday
     * 
     */
    public function init()
    {
        $this->birthday = new Nidorx_Model_Vo_Common_Date();
    }

    public function getGenderFormated()
    {
        if ($this->gender != null) {
            return ($this->gender == 'm') ? 'Macho' : 'Fêma';
        }
        return null;
    }

    /**
     * Ao setar o ano, o objeto birthday também é atualizado
     * 
     * @param int $value 
     */
    public function setBirthdayYear($value)
    {
        $this->birthdayYear = $value;
        $this->birthday->year = $value;
    }

    /**
     * Ao setar o mes, o objeto birthday também é atualizado
     * 
     * @param int $value 
     */
    public function setBirthdayMonth($value)
    {
        $this->birthdayMonth = $value;
        $this->birthday->month = $value;
    }

    /**
     * Ao setar o dia, o objeto birthday também é atualizado
     * 
     * @param int $value 
     */
    public function setBirthdayDay($value)
    {
        $this->birthdayDay = $value;
        $this->birthday->day = $value;
    }

}