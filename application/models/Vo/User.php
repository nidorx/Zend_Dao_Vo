<?php

/**
 * Nidorx
 *
 * @category  Model
 * @package   Vo
 * @subpackage User
 */

/**
 * Classe Vo de dados de usuários
 *
 * @category  Model
 * @package   Vo
 * @subpackage User
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Model_Vo_User extends Nidorx_Model_Vo
{

    public $id;
    public $username;
    public $password;
    public $name;
    public $email;
    public $profile;

    public function setProfile($value)
    {
        if ($value instanceof Nidorx_Model_Vo_User_Name) {
            $this->name = $value;
        } elseif (is_array($value)) {
            $this->name = new Nidorx_Model_Vo_User_Name($value);
        }
    }

}