<?php

/**
 * Nidorx
 *
 * @category  Library
 * @package   Model
 * @subpackage Dao
 * @version    $Id: $
 */

/**
 * Classe pai para criação de DAO(Data Access Object's), usados para implementar
 * toda a lógica de negócios em dados provenientes do banco
 *
 * @category  Library
 * @package   Model
 * @subpackage Dao
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Model_Dao extends Zend_Db_Table
{

    /**
     * Usado em alguns outputs
     * 
     * @var Nidorx_Translator 
     */
    protected $_translator;

    /**
     * Construtor padrão
     */
    public function __construct($config = array(), $definition = null)
    {
        parent::__construct($config, $definition);
        $this->_init();

        $this->_translator = new Nidorx_Translator();
    }

    protected function _init()
    {
        
    }

    /**
     * Converte um obejto ou array para uma instancia de um VO
     * 
     * @param mixed $data
     * @return Nidorx_Model_Vo
     */
    public function convert($data)
    {
        
    }

}