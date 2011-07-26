<?php

/**
 * Nidorx
 *
 * @category  Application
 * @package   Business
 * @subpackage User
 */

/**
 * Classe de tratamento de dados e intermediação com a model de user
 *
 * @category  Application
 * @package   Business
 * @subpackage User
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Business_User_Profile extends Nidorx_Business
{

    /**
     * Classe DAO de user
     * 
     * @var Nidorx_Model_Dao_User_Profile 
     */
    protected $_daoUserProfile;

    public function init()
    {
        $this->_daoUserProfile = new Nidorx_Model_Dao_User_Profile();
    }

    /**
     * Obtém o profile de um usuário, se não for passado o id, obtém o profile
     * do usuário logado atualmente
     * 
     * @param string $userId
     * @return Nidorx_Model_Vo_User_Profile 
     */
    public function get($userId = null)
    {
        if (!$userId) {
            $userId = $this->_userIdentity->id;
        }

        return $this->_daoUserProfile->getByUserId($userId);
    }

    /**
     * Obtém um array com os dados do  profile para edição em um formulário
     * 
     * @param string $step
     * @return array 
     */
    public function getToForm()
    {
        $data = array();
        $userProfile = $this->get();

        if ($userProfile) {
            $data = $userProfile->toArray(true, true);
        }

        return $data;
    }

    public function save($data)
    {
        $data['user_id'] = $this->_userIdentity->id;


        $userProfile = $this->get();
        if (!$userProfile) {
            //Se o profile não existe, será criado
            $userProfile = new Nidorx_Model_Vo_User_Profile($data);
        } else {
            // O profile já existe, será populado apenas
            $userProfile->populate($data);
        }


        return $this->_daoUserProfile->save($userProfile);
    }

}