<?php

/**
 * Nidorx
 *
 * @category  Library
 * @package   Translator
 */

/**
 * Usado para a internacionalização do documento
 *
 * @category  Library
 * @package   Translator
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Translator
{

    /**
     *
     * @var Zend_Translate_Adapter_Ini 
     */
    protected $_translate = null;

    public function __construct()
    {
        $this->_translate = self::getAdapter();
    }

    static public function getAdapter()
    {
        //Obtém a language atual
        $lang = self::_getLang();
        $config = Zend_Registry::get('config');
        $file = LANGUAGES_PATH . DS . 'lang.' . $lang . '.ini';
        if (file_exists($file) && file_get_contents($file) != '') {
            return new Zend_Translate('Ini', $file, $lang);
        }
    }

    /**
     * Usado para imprimir a tradução da key
     * 
     * @param string $key Key to translate
     * @return string
     */
    public function translate($key = null)
    {
        if (null == $key || $this->_translate == null) {
            return $key;
        }


        return $this->_translate->_($key);
    }

    /**
     * Obtém a linguagem usada pelo usuário
     * 
     * @return string 
     */
    private static function _getLang()
    {
        $lang = 'pt_BR';
        return $lang;
    }

}