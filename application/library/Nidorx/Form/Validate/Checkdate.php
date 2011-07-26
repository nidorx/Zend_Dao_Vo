<?php

/**
 * Nidorx
 *
 * @category   Library
 * @package    Form
 * @subpackage Validate
 */
/**
 * @see Zend_Validate_Abstract
 */
require_once 'Zend/Validate/Abstract.php';

/**
 *  Validator de dia de mes
 *
 * @category   Library
 * @package    Form
 * @subpackage Validate
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Form_Validate_Checkdate extends Zend_Validate_Abstract
{
    /**
     * 
     */
    const NOT_VALID = 'notValid';
    /**
     * 
     * @var int 
     */
    protected $_form;
    /**
     * O prefixo do formulário de data
     * 
     * @var string 
     */
    protected $_prefix;
    /**
     *  Mes
     * @var int 
     */
    protected $_month;
    /**
     * Ano 
     * @var int 
     */
    protected $_year;
    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_VALID => "Day '%value%' is invalid in the month '%month%' of '%year%'",
    );
    /**
     * @var array
     */
    protected $_messageVariables = array(
        'month' => '_month',
        'year' => '_year'
    );
    public function __construct(&$form, $prefix)
    {
        $this->_form = $form;
        $this->_prefix = $prefix;
    }

    public function isValid($day)
    {

        $this->_setValue($day);

        $this->_year = $this->_form->getElement($this->_prefix . '_year')->getValue();
        $this->_month = $this->_form->getElement($this->_prefix . '_month')->getValue();

        if (!checkdate($this->_month, $day, $this->_year)) {
            $this->_error(self::NOT_VALID, $day);
            return false;
        }
        return true;
    }

}
