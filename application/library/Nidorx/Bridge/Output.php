<?php

/**
 * Nidorx
 *
 * @category  Library
 * @package   Bridge
 * @version    $Id: $
 */

/**
 * Classe usada para comunicação entre duas camadas do sistema para retornar
 * mensagens de erros e etc.
 *
 *
 * @category  Library
 * @package   Bridge
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Bridge_Output
{

    /**
     * Lista de erros 
     * 
     * @var {array} Nidorx_Bridge_Output_Error
     */
    protected $_errors = array();
    /**
     * O nome do último erro
     * 
     * @var Nidorx_Bridge_Output_Error 
     */
    protected $_lastError = '';

    /**
     * Usado para verificar se existem erros
     * 
     * @return boolean
     */
    public function hasErrors()
    {
        return (count($this->_errors) > 0) ? true : false;
    }

    /**
     * Adiciona um erro
     * 
     * @param type $name Nome do erro
     * @param type $desc Descrição do erro
     */
    public function addError($name, $desc = null)
    {
        $name = trim($name);
        $error = new Nidorx_Bridge_Output_Error($name, $desc);

        $this->_errors[] = $this->_lastError = $error;
    }

    /**
     * Obtém o último erro cadastrado 
     * 
     * @return Nidorx_Bridge_Output_Error 
     */
    public function getLastError()
    {
        return $this->_lastError;
    }

    /**
     * Obtém os erros existentes
     * 
     * @return array 
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * Renderiza a lista de erros 
     * 
     * @return string
     */
    public function renderErrors()
    {
        $output = '<ul class="errors">' . "\n";
        foreach ($this->_errors as $error)
        {
            $output.= '<li>' . $error->text . '</li>' . "\n";
        }

        $output.= '</ul>' . "\n";
        
        return $output;
    }

}