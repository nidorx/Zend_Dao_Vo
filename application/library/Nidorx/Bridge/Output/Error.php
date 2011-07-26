<?php

/**
 * Nidorx
 *
 * @category  Library
 * @package   Bridge
 * @subpackage Output
 * @version    $Id: $
 */

/**
 * Usada para guardar os erros do Bridge Ouput
 *
 *
 * @category  Library
 * @package   Bridge
 * @subpackage Output
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Bridge_Output_Error
{

    /**
     * Nome do erro
     * 
     * @var string 
     */
    public $name;
    /**
     * Descrição do erro
     * 
     * @var string 
     */
    public $text;

    /**
     * Construtor padrão
     * 
     * @param type $name Nome do erro
     * @param type $text Descrição do erro
     */
    public function __construct($name, $text = null)
    {
        $this->name = $name;
        $this->text = $text;
    }

}

?>
