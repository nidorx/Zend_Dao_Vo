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
class Nidorx_Model_Dao_User_Profile extends Nidorx_Model_Dao
{

    /**
     * Nome da tabela de user profile
     * 
     * @var string 
     */
    protected $_name = 'tb_user_profile';

    /**
     * Obtém o profile pelo id do usuário
     * 
     * @param MongoId $id
     * @return Nidorx_Model_Vo_User_Profile|null 
     */
    public function getByUserId($id, $convert = true)
    {

        $select = $this->select($this->_name);
        $select->where('user_id = ?', $id);
        $profile = $this->fetchRow($select);

        if ($profile) {
            // Se o profile for encontrado , retorna um Nidorx_Model_Vo_User_Profile
            if ($convert) {
                return $this->convert($profile->toArray());
            } else {
                return $profile;
            }
        }
        return null;
    }

    /**
     * Cria um novo usuário no mongo
     * 
     * @param Nidorx_Model_Vo_User $voUserProfile
     * @return Nidorx_Bridge_Output 
     */
    public function save(Nidorx_Model_Vo_User_Profile &$voUserProfile)
    {
        $profileBd = null;
        if ($voUserProfile->id) {
            //Se já existir o id, está editando
            $profileBd = $this->getByUserId($voUserProfile->userId, false);
            $profileBd->setFromArray($voUserProfile->toArray(true, true));
        } else {
            //Está criando o usuaŕio
            $profileBd = $this->createRow($voUserProfile->toArray(true, true));
        }


        //Finalmente salva os dados
        if ($profileBd->save()) {
            $voUser->id = $profileBd->id;
            return true;
        };

        return false;
    }

    /**
     * Se precisar configurar algo ao intanciar, declare aqui
     */
    protected function _init()
    {
        
    }

    /**
     * Converte um array para um vo específico
     * 
     * @return Nidorx_Model_Vo_User_Profile 
     */
    public function convert($data)
    {
        return new Nidorx_Model_Vo_User_Profile($data);
    }

}