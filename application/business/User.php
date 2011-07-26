<?php

/**
 * Nidorx
 *
 * @category  Business
 * @package   User
 * @version    $Id: $
 */

/**
 * Classe de tratamento de dados e intermediação com a model de user
 *
 * @category  Business
 * @package   User
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Business_User extends Nidorx_Business
{

    /**
     * Classe DAO de user
     * 
     * @var Nidorx_Model_Dao_User 
     */
    protected $_daoUser;

    public function init()
    {
        $this->_daoUser = new Nidorx_Model_Dao_User();
    }

    /**
     * Realiza a autenticação do usuário
     * 
     * @param String $username
     * @param String $password
     */
    public function authenticate($username, $password)
    {
        $voUser = $this->_daoUser->getByUsername($username);

        if ($voUser && $voUser->password == md5($password)) {
            unset($voUser->password);
            $auth = Zend_Auth::getInstance();
            $storage = $auth->getStorage();
            $storage->clear();
            $storage->write($voUser);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Obtém um objeto Nidorx_Model_Vo_User_Name a partir de uma string
     * 
     * @param string $fullname
     * @return Nidorx_Model_Vo_User_Name 
     */
    protected function _explodeFullName($fullname)
    {
        $userName = new Nidorx_Model_Vo_User_Name();
        if (is_string($fullname)) {
            $names = explode(' ', $fullname, 2);
            $userName->first = $names[0];

            if (count($names) > 1) {
                $userName->last = $names[1];
            }
        }
        return $userName;
    }

}