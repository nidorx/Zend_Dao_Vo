<?php

/**
 * Nidorx
 *
 * @category  Model
 * @package   DAO
 * @subpackage User
 * @version    $Id: $
 */

/**
 * Classe Dao de dados de usuário
 *
 * @category  Model
 * @package   DAO
 * @subpackage User
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Model_Dao_User extends Nidorx_Model_Dao
{

    /**
     * Nome da tabela de user 
     * 
     * @var string 
     */
    protected $_name = 'tb_user';

    /**
     * Obtém um usuário pelo id
     * 
     * @param int $id
     * @return Nidorx_Model_Vo_User|null
     */
    public function getById($id, $convert = true)
    {
        if (is_int($var)) {
            $select = $this->select();
            $select->where('id = ?', $id);

            $user = $this->fetchRow($select);
            if ($user) {
                if ($convert) {
                    //Se for encontrado o usuario, retorna um Nidorx_Model_Vo_User
                    return $this->convert($user->toArray());
                } else {
                    return $user;
                }
            }
        } else {
            throw new Exception('O método espera um INTEGER.');
        }

        return null;
    }

    /**
     * Obtém os dados de um usuário pelo username
     * 
     * @param string $username
     * @return Nidorx_Model_Vo_User|null
     */
    public function getByUsername($username)
    {
        if (is_string($username)) {

            $select = $this->select($this->_name);
            $select->where('username = ?', $username);

            $user = $this->fetchRow($select);

            if ($user) {
                //Se for encontrado o usuario, retorna um Nidorx_Model_Vo_User
                return $this->convert($user->toArray());
            }
        } else {
            throw new Exception('O método espera uma string.');
        }

        return null;
    }

    /**
     * Obtém os dados de um usuário a partir do email
     * 
     * @param string $email
     * @return Nidorx_Model_Vo_User 
     */
    public function getByEmail($email)
    {
        //Faz a validação do email
        $validateEmail = new Zend_Validate_EmailAddress();
        if (is_string($email) && $validateEmail->isValid($email)) {
            $select = $this->select($this->_name);
            $select->where('email = ?', $email);
            $user = $this->fetchRow($select);

            if ($user) {
                //Se for encontrado o usuario, retorna um Nidorx_Model_Vo_User
                return $this->convert($user->toArray());
            }
        } else {
            throw new Exception('O método espera um e-mail válido.');
        }
    }

    /**
     * Cria um novo usuário no mongo
     * 
     * @param Nidorx_Model_Vo_User $voUser
     * @return boolean 
     */
    public function save(Nidorx_Model_Vo_User &$voUser)
    {

        $userBd = null;
        if ($voUser->id) {
            //Se já existir o id, está editando
            $userBd = $this->getById($voUser->id);
            $userBd->setFromArray($voUser->toArray(true, true));
        } else {
            //Está criando o usuaŕio
            $userBd = $this->createRow($voUser->toArray());
        }



        //Finalmente salva os dados
        if ($userBd->save()) {
            $voUser->id = $userBd->id;
            return true;
        };

        return false;
    }

    protected function _init()
    {
        
    }

    /**
     * Converte um array para um vo específico
     * 
     * @return Nidorx_Model_Vo_User 
     */
    public function convert($data)
    {
        return new Nidorx_Model_Vo_User($data);
    }

}