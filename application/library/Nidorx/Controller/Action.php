<?php

/**
 * Nidorx
 *
 * @category   Library
 * @package Controller
 * @subpackage Action
 * @package    Controller
 */

/**
 * Nidorx_Controller_Action
 *
 * A Class de controller do sistema
 *
 * @category   Library
 * @package Controller
 * @subpackage Action
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Controller_Action extends Zend_Controller_Action
{

    /**
     * Os dados da autenticação do usuário
     * 
     * @var Zend_Auth 
     */
    protected $_auth;
    /**
     * Zend_Registry::get('config');
     * Junção de todos os arquivos de config do sistema rodando atualmente
     * 
     * @var stdClass 
     */
    protected $_config;

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);

        $this->_auth = Zend_Auth::getInstance();
        $this->_config = Zend_Registry::get('config');
    }

    /**
     * Auto redireciona o usuário, usado nos formulários em que após o preenchimento
     * o usuário é redirecionado para a pagina que estava acessando
     * 
     * @param string $default
     * @param array $options 
     */
    public function autoRedirect($default = '/', array $options = array())
    {
        $url = $this->_getParam('redirect', $default);
        $this->_redirect($url, $options);
    }

    /**
     * Retorna a url uzada como redirect
     * 
     * @return string 
     */
    public function getRedirect()
    {
        return $this->_getParam('redirect', '/');
    }

    /**
     * Cria a url para redirect, adiciona-o ao request e instancia uma variavel
     * << redirect >> na view
     *  
     * @param string $uri Se nao passado, a url será a atual
     * @return string 
     */
    public function createRedirect($uri = null, $onlyIfNotExist = false)
    {
        if (!$uri || !is_string($uri)) {
            $uri = str_replace($_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);
        }

        if ($onlyIfNotExist) {
            if ($this->_getParam('redirect', false)) {
                $uri = $this->getRedirect();
            }
        }

        $this->_request->setParam('redirect', $uri);

        $this->view->redirect = $uri;
        return $uri;
    }

}

