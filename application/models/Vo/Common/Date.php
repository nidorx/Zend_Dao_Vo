<?php

/**
 * Nidorx
 *
 * @category  Model
 * @package   Vo
 * @subpackage User
 */

/**
 * Classe Vo para tratamento de data
 *
 * @category  Model
 * @package   Vo
 * @subpackage User
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Model_Vo_Common_Date extends Nidorx_Model_Vo
{

    public $year;
    public $month;
    public $day;

    /**
     * Obtém uma data formatada
     */
    public function getFormated()
    {
        return $this->day . '/' . $this->month . '/' . $this->year;
    }

}