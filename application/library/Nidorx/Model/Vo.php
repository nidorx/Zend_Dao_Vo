<?php

/**
 * Nidorx
 *
 * @category  Library
 * @package Model
 * @subpackage Vo
 */

/**
 * Nidorx Values Objects
 * Classe pai para criação de VO(Values Objects), usados para mensagens de dados 
 * entre algumas camadas do sistema (business, controllers, models, etc)
 *
 * @category  Library
 * @package Model
 * @subpackage Vo
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Model_Vo
{

    /**
     * Lista com todos a propriedades públicas do objeto
     * 
     * @var array 
     */
    private $_keys = array();
    /**
     * Lista com todos os métodos do objeto
     * @var array 
     */
    private $_getters = array();
    /**
     *
     * @var array 
     */
    private $_setters = array();

    /**
     * Retorna um array com todos os atributos e seus valores
     * 
     * @param boolean $recursive Se setado, entra em até 3 niveis de recusividade
     * para gerar o array do VO
     * @return array 
     */
    public function toArray($recursive = false, $undescored = false)
    {
        $return = array();
        foreach ($this->_keys as $key) {
            $nKey = ($undescored) ? $this->_camelToUnder($key) : $key;
            if ($recursive && is_object($this->{$key}) && method_exists($this->{$key}, 'toArray')) {
                $return[$nKey] = $this->{$key}->toArray();
                continue;
            }

            if ($recursive && is_array($this->{$key})) {
                $array = array();
                foreach ($this->{$key} as $key2 => $value) {
                    $nKey2 = ($undescored) ? $this->_camelToUnder($key2) : $key2;
                    if (is_object($value) && method_exists($value, 'toArray')) {
                        $array[$nKey2] = $value->toArray();
                        continue;
                    }
                    $array[$nKey2] = $value;
                }
                $return[$nKey] = $array;
                continue;
            }

            $return[$nKey] = $this->{$key};
        }

        return $return;
    }

    /**
     * Recebe um array de chaves e valores para setar as propiedades do objeto
     * 
     * @param array $data
     * @throws Exception
     */
    public function populate($data = array())
    {
        if (is_object($data)) {
            $data = (array) $data;
        }
        if (!is_array($data)) {
            throw new Exception('The data must be an array or object');
        }

        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }

        return $this;
    }

    /**
     * Metodo mágico para setar valores aos atributos protected e private
     * 
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value)
    {
        $name = $this->_underToCamel($name);
        // Verifica se existe um método para tratamento do dado
        $method = 'set' . ucfirst($name);
        if (in_array($method, $this->_setters)) {
            $this->$method($value);
        } else {
            if (is_array($value) || is_object($value))
                return;
            if (in_array($name, $this->_keys)) {
                $this->{$name} = $value;
            }
        }
    }

    /**
     * Metodo mágico para retornar os atributos protected e private
     * 
     * @param string $name
     */
    public function __get($name)
    {
        $name = $this->_underToCamel($name);
        //Verfica se existe um método get personalizado
        $method = 'get' . ucfirst($name);
        if (in_array($method, $this->_getters)) {
            return $this->$method();
        }
        if (isset($this->{$name}) || is_null($this->{$name})) {
            return $this->{$name};
        } else {
            throw new Exception('Invalid property');
        }
    }

    /**
     * Construtor padrão de um Value Object
     * 
     * @param type $data
     * @return Nidorx_Model_Vo 
     */
    public function __construct($data = array())
    {
        $this->_parseKeys();
        $this->_parseMethods();

        $this->init();
        $this->populate($data);
    }

    /**
     * Se necessário inicializar alguma variavel
     */
    public function init()
    {
        
    }

    /**
     * Faz o parsing das keys existentes, tornando assim mais rápido o processo
     * de verificação do _set
     */
    protected function _parseKeys()
    {
        if (!isset($this->_keys) || $this->_keys == null) {
            $vars = get_class_vars(get_class($this));
            foreach ($vars as $key => $value) {
                if ($key[0] == '_')
                    unset($vars[$key]);
            }

            $this->_keys = array_keys($vars);
        }

        return $this->_keys;
    }

    /**
     * Faz o parsing de todos os Setters e Getters existentes na classe, tornando
     * mais rápido as chamadas
     */
    protected function _parseMethods()
    {
        if (!isset($this->_methods) || $this->_methods == null) {
            $vars = get_class_methods(get_class($this));

            foreach ($vars as $key => $value) {
                $type = substr($value, 0, 3);
                if ($type == 'set') {
                    $this->_setters[] = $value;
                    continue;
                } elseif ($type == 'get') {
                    $this->_getters[] = $value;
                    continue;
                }
            }

            $this->_methods = $vars;
        }
    }

    /**
     * Metodo para tranformar as variaveis vindas do bd em variaveis PHP
     * id_usuario => idUsuario
     * 
     * @param string $value
     */
    protected function _underToCamel($value)
    {
        $filter = new Zend_Filter_Word_UnderscoreToCamelCase();
        $filter->setSeparator('_');

        return lcfirst($filter->filter($value));
    }

    /**
     * Metodo para tranformar as variaveis PHP em colunas do bd
     * id_usuario => idUsuario
     * 
     * @param string $value
     */
    protected function _camelToUnder($value)
    {
        $filter = new Zend_Filter_Word_CamelCaseToUnderscore();
        return strtolower($filter->filter($value));
    }

}