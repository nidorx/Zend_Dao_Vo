<?php

/**
 * Nidorx
 *
 * @category   Library
 * @package    Form
 * @subpackage Decorator
 */

/**
 *  Adiciona uma div clear abaixo dos elementos do formulário
 *
 * @category   Library
 * @package    Form
 * @subpackage Decorator
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Form_Decorator_Divclear extends Zend_Form_Decorator_Abstract
{

    public function render($content)
    {
        $divClear = '<div class="clear"></div>';
        $separator = $this->getSeparator();
        return $content . $separator . $divClear;
    }

}

