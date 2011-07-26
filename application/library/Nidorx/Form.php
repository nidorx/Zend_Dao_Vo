<?php

/**
 * Nidorx
 *
 * @category  Library
 * @package Form
 */

/**
 * Classe geral de formulários dos sistemas Nidorx
 *
 * @category  Library
 * @package Form
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Form extends Nidorx_Form_Abstract
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

        //Instanciando o translator
        $this->_translator = Nidorx_Translator::getAdapter();
    }

    /**
     * Get error codes for all elements failing validation
     *
     * @param  string $name
     * @return array
     */
    public function getErrors($name = null, $suppressArrayNotation = false)
    {
        $errors = array();
        if (null !== $name) {
            if (isset($this->_elements[$name])) {
                return $this->getElement($name)->getErrors();
            } else if (isset($this->_subForms[$name])) {
                return $this->getSubForm($name)->getErrors(null, true);
            }
        }

        foreach ($this->_elements as $key => $element) {
            ($element->hasErrors()) &&
                    $errors[$key] = $element->getErrors();
        }
        foreach ($this->getSubForms() as $key => $subForm) {
            $merge = array();
            if (!$subForm->isArray()) {
                $merge[$key] = $subForm->getErrors();
            } else {
                $merge = $this->_attachToArray($subForm->getErrors(null, true), $subForm->getElementsBelongTo());
            }
            $errors = $this->_array_replace_recursive($errors, $merge);
        }

        if (!$suppressArrayNotation &&
                $this->isArray() &&
                !$this->_getIsRendered()) {
            $errors = $this->_attachToArray($errors, $this->getElementsBelongTo());
        }

        return $errors;
    }

    /**
     * Método para adicionar um campo usado para o redirecionamentos após o 
     * preenchimento de formulários
     * 
     * @param string $url 
     */
    public function setRedirect($url = '/')
    {
        $redirect = $this->getElement('redirect');

        if (!$redirect) {
            $redirect = $this->createElement('hidden', 'redirect');
        }
        $redirect->removeDecorator('HtmlTag');
        $redirect->removeDecorator('label');
        $redirect->setRequired(false);
        $redirect->setValue($url);
        $this->addElement($redirect);
    }

}

