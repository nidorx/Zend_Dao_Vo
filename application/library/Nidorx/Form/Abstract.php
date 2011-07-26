<?php

/**
 * Nidorx
 *
 * @category  Library
 */

/**
 * Classe geral de formulários do sistema
 *
 *
 * @category  Library
 * @package Form
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Form_Abstract extends Zend_Form
{

    /**
     * O translate padrão do Zend
     * 
     * @var Zend_Translator_Adapter 
     */
    protected $_translator;

    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->_translator = Nidorx_Translator::getAdapter();
    }

    public function init()
    {
        //// Adicionando o path de decorators do humrum
        $this->addElementPrefixPath('Nidorx_Form_Decorator', 'Nidorx/Form/Decorator', 'decorator');
    }

    /**
     * Cria um elemento de data
     * os valores válidos para ano, mes e dia sao:
     * 1 = Obrigatório
     * 0 = Opcional = defaul
     * -1 = Não exibe

     * @param string $prefix
     * @param string $label
     * @param int $year 
     * @param int $month
     * @param int $day 
     */
    protected function _createElementDate($prefix, $label, $year = 0, $month = 0, $day = 0)
    {
        if (!is_string($prefix)) {
            throw new Exception('O parâmetro $prefix deve ser um String.');
        }
        $decorators = array(
            'ViewHelper',
            'Errors',
            array('Label', array('tag' => 'span')),
            array('HtmlTag', array('tag' => 'div'))
        );


        //Elementos que serão ineridos no displaygroup
        $displayGroup = array();
        if ($year > -1) {
            $fieldName = $prefix . '_year';
            // O gênero do usuário
            $nField = $this->createElement('select', $fieldName);
            $nField->setLabel('Year');
            //Verifica se o campo é obrigatório ou opcional
            if ($year > 0) {
                $nField->setRequired(true);
            } else {
                $nField->setRequired(false);
            }
            $nField->addMultiOptions(Nidorx_Date::getYearsList());
            $nField->setDecorators($decorators);
            $this->addElement($nField);

            $displayGroup[] = $fieldName;
        }

        if ($month > -1) {
            $fieldName = $prefix . '_month';
            // O gênero do usuário
            $nField = $this->createElement('select', $fieldName);
            $nField->setLabel('Mounth');
            //Verifica se o campo é obrigatório ou opcional
            if ($year > 0) {
                $nField->setRequired(true);
            } else {
                $nField->setRequired(false);
            }
            $nField->addMultiOptions(Nidorx_Date::getMonthsNames());
            $nField->setDecorators($decorators);
            $this->addElement($nField);

            $displayGroup[] = $fieldName;

            if ($day > -1) {
                $fieldName = $prefix . '_day';
                // O gênero do usuário
                $nField = $this->createElement('text', $fieldName);
                $nField->setLabel('Day');
                //Verifica se o campo é obrigatório ou opcional
                if ($day > 0) {
                    $nField->setRequired(true);
                } else {
                    $nField->setRequired(false);
                }
                $nField->setAttrib('size', 2);

                //Adicionando um validador de dia
                if ($year > -1 && $month > -1) {


                    $nField->addValidator(new Nidorx_Form_Validate_Checkdate($this, $prefix));
                }

                $nField->setDecorators($decorators);
                $this->addElement($nField);

                $displayGroup[] = $fieldName;
            }
        }



        $this->addDisplayGroup($displayGroup, $prefix, array('legend' => $label, 'class' => 'date'));
    }

}

