<?php

/**
 * Nidorx
 *
 * @category   Library
 */

/**
 *  Classe para tratamentos diverso de datas
 *
 * @category   Library
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Date
{

    /**
     * Timestamp atual
     * 
     * @return int
     */
    public function get()
    {
        $date = new Zend_Date();
        return (int) $date->get(Zend_Date::TIMESTAMP);
    }

    /**
     * Cria um timestamp específico
     * 
     * @param type $year
     * @param type $mounth
     * @param type $day
     * @param type $hour
     * @param type $minute
     * @param type $second
     * @return type 
     */
    public function toUnix($year, $mounth, $day, $hour = null, $minute = null, $second= null)
    {
        $date = new Zend_Date();

        $dateCompleteArray = array(
            'year' => (int) $year,
            'month' => (int) $mounth,
            'day' => (int) $day,
            'hour' => (isset($hour)) ? (int) $hour : null,
            'minute' => (isset($minute)) ? (int) $minute : null,
            'second' => (isset($second)) ? (int) $second : null,
        );

        $date = new Zend_Date($dateCompleteArray);

        return (int) $date->get(Zend_Date::TIMESTAMP);
    }

    /**
     * Converte um timestamp para array
     * 
     * @param int $timeStamp
     * @return ARRAY 
     */
    public function unixToArray($timeStamp)
    {
        if (!$timeStamp)
            return null;

        $date = new Zend_Date();
        $date->set($timeStamp, Zend_Date::TIMESTAMP);

        return $date->toArray();
    }

    /**
     * Obtém a lista de nomes dos meses
     * 
     * @return array
     */
    public static function getMonthsNames()
    {
        $months = array();
        for ($m = 1; $m <= 12; $m++) {
            $month = date("F", mktime(0, 0, 0, $m));
            $months[$m] = $month;
        }
        return $months;
    }

    public static function getYearsList($offsetBefore = 80, $offsetAfter = 0)
    {
        $years = array();
        $year = (int) date("Y");
        for ($y = $year - $offsetBefore; $y <= $year + $offsetAfter; $y++) {
            $years[$y] = $y;
        }
        return $years;
    }

}